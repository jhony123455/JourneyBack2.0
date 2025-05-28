<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCalendarEventRequest;
use App\Http\Requests\UpdateCalendarEventRequest;
use App\Services\CalendarEventService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CalendarEventController extends Controller
{
    protected $calendarEventService;

    public function __construct(CalendarEventService $calendarEventService)
    {
        $this->calendarEventService = $calendarEventService;
    }

    /**
     * Obtener todos los eventos del calendario.
     */
    public function index(): JsonResponse
    {
        try {
            $events = $this->calendarEventService->getAllCalendarEvents();
            return response()->json($events, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Crear un nuevo evento de calendario.
     */
    public function store(CreateCalendarEventRequest $request): JsonResponse
    {
        try {
            $calendarEvent = $this->calendarEventService->createCalendarEvent($request->validated());
            return response()->json($calendarEvent, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtener un evento de calendario específico.
     */
    public function show($id): JsonResponse
    {
        try {
            $calendarEvent = $this->calendarEventService->getCalendarEventById($id);
            if (!$calendarEvent) {
                return response()->json(['error' => 'Evento no encontrado'], Response::HTTP_NOT_FOUND);
            }
            return response()->json($calendarEvent, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Actualizar un evento de calendario existente.
     */
    public function update(UpdateCalendarEventRequest $request, $id): JsonResponse
    {
        try {
            $calendarEvent = $this->calendarEventService->updateCalendarEvent($id, $request->validated());
            if (!$calendarEvent) {
                return response()->json(['error' => 'Evento no encontrado'], Response::HTTP_NOT_FOUND);
            }
            return response()->json($calendarEvent, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Eliminar un evento de calendario.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $result = $this->calendarEventService->deleteCalendarEvent($id);
            if (!$result) {
                return response()->json(['error' => 'Evento no encontrado'], Response::HTTP_NOT_FOUND);
            }
            return response()->json(['message' => 'Evento eliminado correctamente'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Obtener eventos por actividad.
     */
    public function getEventsByActivity($activityId): JsonResponse
    {
        try {
            $events = $this->calendarEventService->getCalendarEventsByActivity($activityId);
            return response()->json($events, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
