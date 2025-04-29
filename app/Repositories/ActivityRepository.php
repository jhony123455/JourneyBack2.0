<?php

namespace App\Repositories;

use App\Interfaces\ActivityRepositoryInterface;
use App\Models\Activity;


class ActivityRepository implements ActivityRepositoryInterface
{
    public function all()
    {
        return Activity::all();
    }

    public function find($id)
    {
        return Activity::findOrFail($id);
    }

    public function create(array $data)
    {
        return Activity::create($data);
    }

    public function update($id, array $data)
    {
        $activity = $this->find($id);
        $activity->update($data);
        return $activity;
    }

    public function delete($id)
    {
        $activity = $this->find($id);
        return $activity->delete();
    }
}
