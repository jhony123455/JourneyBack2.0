<?php

namespace App\Repositories;

use App\Interfaces\CalendarEventRepositoryInterface;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\Auth;

class CalendarEventRepository implements CalendarEventRepositoryInterface
{
    protected $model;

    public function __construct(CalendarEvent $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->whereHas('activity', function($query) {
            $query->where('user_id', Auth::id());
        })->with('activity')->get();
    }

    public function getById($id)
    {
        return $this->model->whereHas('activity', function($query) {
            $query->where('user_id', Auth::id());
        })->with('activity')->find($id);
    }

    public function create(array $data)
    {
        // Verificar que la actividad pertenezca al usuario actual
        $activity = \App\Models\Activity::where('id', $data['activity_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $calendarEvent = $this->model->whereHas('activity', function($query) {
            $query->where('user_id', Auth::id());
        })->find($id);

        if ($calendarEvent) {
            if (isset($data['activity_id'])) {
                // Verificar que la nueva actividad pertenezca al usuario actual
                \App\Models\Activity::where('id', $data['activity_id'])
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
            }
            $calendarEvent->update($data);
            return $calendarEvent;
        }
        return null;
    }

    public function delete($id)
    {
        $calendarEvent = $this->model->whereHas('activity', function($query) {
            $query->where('user_id', Auth::id());
        })->find($id);

        if ($calendarEvent) {
            $calendarEvent->delete();
            return true;
        }
        return false;
    }

    public function getByActivityId($activityId)
    {
        return $this->model->whereHas('activity', function($query) {
            $query->where('user_id', Auth::id());
        })->where('activity_id', $activityId)
          ->with('activity')
          ->get();
    }
}
