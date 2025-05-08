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
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $activity = Activity::create($data);
        $activity->tags()->sync($tags);

        return $activity->load('tags');
    }

    public function update($id, array $data)
    {
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $activity = $this->find($id);
        $activity->update($data);
        $activity->tags()->sync($tags);

        return $activity->load('tags');
    }

    public function delete($id)
    {
        $activity = $this->find($id);
        return $activity->delete();
    }
}
