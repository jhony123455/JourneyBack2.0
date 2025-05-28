<?php

namespace App\Http\Controllers;

use App\Services\ActivityService;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;

class ActivityController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index()
    {
        return response()->json($this->activityService->getAll());
    }

    public function store(StoreActivityRequest $request)
    {
    
        $data = $request->validated();
        $data['user_id'] = auth('api')->id();
        return response()->json($this->activityService->create($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->activityService->getById($id));
    }

    public function update(UpdateActivityRequest $request, $id)
    {
        return response()->json($this->activityService->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->activityService->delete($id);
        return response()->json(['message' => 'Actividad eliminada correctamente.']);
    }
}
