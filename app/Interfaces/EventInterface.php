<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface EventInterface
{
    public function createEvent($data);
    public function updateEvent($data);
    public function deleteEvent();

    public function getServiceEvents();
    public function getFormattedEvents(): ?array;
    public function getEventById($id): ?array;

    public function getColorsJson(): JsonResponse;
    public function getColorsArray(): array;
}
