<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ImageService
{
    /**
     * Guarda una imagen base64 y retorna la ruta relativa
     */
    public function saveImage(string $base64Image, string $folder = 'uploads'): string
    {
        try {
            // Validar que la imagen sea base64 válida
            if (!Str::startsWith($base64Image, 'data:image')) {
                throw new \Exception('Invalid image format. Must be a base64 image.');
            }

            // Decodificar la imagen base64
            $image = $this->decodeBase64Image($base64Image);
            
            // Validar que el tamaño no exceda 5MB
            if (strlen($image['data']) > 5 * 1024 * 1024) {
                throw new \Exception('Image size exceeds 5MB limit.');
            }

            // Asegurarse de que el directorio existe
            $path = Storage::disk('public')->path($folder);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            
            // Generar nombre único para la imagen
            $fileName = Str::uuid() . '.' . $image['extension'];
            
            // Guardar la imagen
            if (!Storage::disk('public')->put($folder . '/' . $fileName, $image['data'])) {
                throw new \Exception('Failed to save image.');
            }
            
            // Retornar la ruta relativa
            return $folder . '/' . $fileName;
        } catch (\Exception $e) {
            \Log::error('Error saving image: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtiene una imagen y la retorna en formato base64
     */
    public function getImageAsBase64(?string $path): ?string
    {
        try {
            if (!$path || !Storage::disk('public')->exists($path)) {
                return null;
            }

            $image = Storage::disk('public')->get($path);
            if (!$image) {
                return null;
            }

            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $mimeType = $this->getMimeType($extension);

            return 'data:' . $mimeType . ';base64,' . base64_encode($image);
        } catch (\Exception $e) {
            \Log::error('Error getting image as base64: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Elimina una imagen del almacenamiento
     */
    public function deleteImage(?string $path): bool
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    /**
     * Decodifica una imagen base64 y retorna los datos y la extensión
     */
    private function decodeBase64Image(string $base64Image): array
    {
        // Remover el prefijo de data URL si existe
        if (Str::startsWith($base64Image, 'data:image')) {
            $base64Image = explode(',', $base64Image)[1];
        }

        $imageData = base64_decode($base64Image);
        
        // Detectar el tipo de imagen
        $f = finfo_open();
        $mimeType = finfo_buffer($f, $imageData, FILEINFO_MIME_TYPE);
        finfo_close($f);
        
        return [
            'data' => $imageData,
            'extension' => $this->getExtensionFromMimeType($mimeType)
        ];
    }

    /**
     * Obtiene la extensión basada en el tipo MIME
     */
    private function getExtensionFromMimeType(string $mimeType): string
    {
        $mimeToExt = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg'
        ];

        return $mimeToExt[$mimeType] ?? 'jpg';
    }

    /**
     * Obtiene el tipo MIME basado en la extensión
     */
    private function getMimeType(string $extension): string
    {
        $extToMime = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml'
        ];

        return $extToMime[strtolower($extension)] ?? 'image/jpeg';
    }
} 