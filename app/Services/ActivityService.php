<?php

namespace App\Services;

use App\Interfaces\ActivityRepositoryInterface;

class ActivityService
{
    protected $activityRepository;

    public function __construct(ActivityRepositoryInterface $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function getAll()
    {
        return $this->activityRepository->all();
    }

    public function getById($id)
    {
        return $this->activityRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->activityRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->activityRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->activityRepository->delete($id);
    }
}
