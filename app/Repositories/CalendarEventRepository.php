<?php

namespace App\Repositories;

use App\Interfaces\CalendarEventRepositoryInterface;
use App\Models\CalendarEvent;

class CalendarEventRepository implements CalendarEventRepositoryInterface
{
    protected $model;

    public function __construct(CalendarEvent $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('activity')->get();
    }

    public function getById($id)
    {
        return $this->model->with('activity')->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $calendarEvent = $this->model->find($id);
        if ($calendarEvent) {
            $calendarEvent->update($data);
            return $calendarEvent;
        }
        return null;
    }

    public function delete($id)
    {
        $calendarEvent = $this->model->find($id);
        if ($calendarEvent) {
            $calendarEvent->delete();
            return true;
        }
        return false;
    }

    public function getByActivityId($activityId)
    {
        return $this->model->where('activity_id', $activityId)->with('activity')->get();
    }
}
