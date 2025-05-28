<?php

namespace App\Services;

use App\Interfaces\DiaryEntryServiceInterface;
use App\Models\DiaryEntry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\Access\AuthorizationException;

class DiaryEntryService implements DiaryEntryServiceInterface
{
    public function getUserEntries(int $userId): Collection
    {
        return DiaryEntry::where('user_id', $userId)
            ->orderBy('entry_date', 'desc')
            ->get();
    }

    public function getEntry(int $id, int $userId): ?DiaryEntry
    {
        $entry = DiaryEntry::find($id);
        
        if (!$entry || $entry->user_id !== $userId) {
            throw new AuthorizationException('No estás autorizado para ver esta entrada.');
        }

        return $entry;
    }

    public function createEntry(array $data, int $userId): DiaryEntry
    {
        $data['user_id'] = $userId;
        return DiaryEntry::create($data);
    }

    public function updateEntry(int $id, array $data, int $userId): ?DiaryEntry
    {
        $entry = DiaryEntry::find($id);
        
        if (!$entry || $entry->user_id !== $userId) {
            throw new AuthorizationException('No estás autorizado para actualizar esta entrada.');
        }

        $entry->update($data);
        return $entry;
    }

    public function deleteEntry(int $id, int $userId): bool
    {
        $entry = DiaryEntry::find($id);
        
        if (!$entry || $entry->user_id !== $userId) {
            throw new AuthorizationException('No estás autorizado para eliminar esta entrada.');
        }

        return $entry->delete();
    }

    public function getEntriesByDateRange(int $userId, string $startDate, string $endDate): Collection
    {
        return DiaryEntry::where('user_id', $userId)
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->orderBy('entry_date', 'desc')
            ->get();
    }
} 