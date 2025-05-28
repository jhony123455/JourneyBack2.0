<?php

namespace App\Repositories;

use App\Interfaces\ActivityRepositoryInterface;
use App\Models\Activity;


class ActivityRepository implements ActivityRepositoryInterface
{
    public function all()
    {
        return Activity::where('user_id', auth('api')->id())->get();
    }

    public function find($id)
    {
        return Activity::where('id', $id)
        ->where('user_id', auth('api')->id())
        ->firstOrFail();
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
