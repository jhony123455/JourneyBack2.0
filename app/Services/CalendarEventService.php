<?php

namespace App\Services;

use App\Interfaces\CalendarEventRepositoryInterface;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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
        $data['user_id'] = Auth::id();

        $validator = Validator::make($data, [
            'activity_id' => 'required|exists:activities,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'all_day' => 'boolean'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        // Crear el evento solo con los campos necesarios
        $eventData = [
            'activity_id' => $data['activity_id'],
            'user_id' => $data['user_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'all_day' => $data['all_day'] ?? false
        ];

        $event = $this->calendarEventRepository->create($eventData);

        // Cargar la actividad relacionada para tener acceso a título, descripción, color y tags
        return $this->calendarEventRepository->getById($event->id);
    }

    public function updateCalendarEvent($id, array $data)
    {
        $validator = Validator::make($data, [
            'activity_id' => 'sometimes|exists:activities,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'all_day' => 'boolean'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        // Actualizar solo los campos necesarios
        $eventData = array_intersect_key($data, array_flip([
            'activity_id',
            'start_date',
            'end_date',
            'all_day'
        ]));

        $event = $this->calendarEventRepository->update($id, $eventData);

        // Cargar la actividad relacionada para tener acceso a título, descripción, color y tags
        return $this->calendarEventRepository->getById($event->id);
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
