<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index(): JsonResponse
    {
        $tags = $this->tagService->getAll();
        return response()->json($tags);
    }

    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = $this->tagService->create($request->validated());
        return response()->json($tag, 201);
    }

    public function show($id): JsonResponse
    {
        $tag = $this->tagService->getById($id);
        return response()->json($tag);
    }

    public function update(UpdateTagRequest $request, $id): JsonResponse
    {
        $tag = $this->tagService->update($id, $request->validated());
        return response()->json($tag);
    }

    public function destroy($id): JsonResponse
    {
        $this->tagService->delete($id);
        return response()->json(['message' => 'Etiqueta eliminada correctamente']);
    }
}
