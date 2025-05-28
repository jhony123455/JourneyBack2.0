<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDiaryEntryRequest;
use App\Http\Requests\UpdateDiaryEntryRequest;
use App\Interfaces\DiaryEntryServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryEntryController extends Controller
{
    protected $service;

    public function __construct(DiaryEntryServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $entries = $this->service->getUserEntries(Auth::id());
        return response()->json($entries);
    }

    public function show(int $id): JsonResponse
    {
        $entry = $this->service->getEntry($id, Auth::id());
        return response()->json($entry);
    }

    public function store(CreateDiaryEntryRequest $request): JsonResponse
    {
        $entry = $this->service->createEntry($request->validated(), Auth::id());
        return response()->json($entry, 201);
    }

    public function update(UpdateDiaryEntryRequest $request, int $id): JsonResponse
    {
        $entry = $this->service->updateEntry($id, $request->validated(), Auth::id());
        return response()->json($entry);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->deleteEntry($id, Auth::id());
        return response()->json(null, 204);
    }

    public function getByDateRange(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $entries = $this->service->getEntriesByDateRange(
            Auth::id(),
            $request->start_date,
            $request->end_date
        );

        return response()->json($entries);
    }
} 