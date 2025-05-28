<?php

namespace App\Services;

use App\Interfaces\CalendarEventRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class CalendarEventService
{
    protected $calendarEventRepository;

    public function __construct(CalendarEventRepositoryInterface $calendarEventRepository)
    {
        $this->calendarEventRepository = $calendarEventRepository;
    }

    public function getAllCalendarEvents()
    {
        return $this->calendarEventRepository->all();
    }

    public function getCalendarEventById($id)
    {
        return $this->calendarEventRepository->getById($id);
    }

    public function createCalendarEvent(array $data)
    {
        $validator = Validator::make($data, [
            'activity_id' => 'required|exists:activities,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'all_day' => 'boolean',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->calendarEventRepository->create($data);
    }

    public function updateCalendarEvent($id, array $data)
    {
        $validator = Validator::make($data, [
            'activity_id' => 'sometimes|exists:activities,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'all_day' => 'boolean',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->calendarEventRepository->update($id, $data);
    }

    public function deleteCalendarEvent($id)
    {
        return $this->calendarEventRepository->delete($id);
    }

    public function getCalendarEventsByActivity($activityId)
    {
        return $this->calendarEventRepository->getByActivityId($activityId);
    }
}
