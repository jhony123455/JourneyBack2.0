<?php

namespace App\Interfaces;

use App\Models\DiaryEntry;
use Illuminate\Database\Eloquent\Collection;

interface DiaryEntryServiceInterface
{
    public function getUserEntries(): Collection;
    public function getEntry(int $id): ?DiaryEntry;
    public function createEntry(array $data): DiaryEntry;
    public function updateEntry(int $id, array $data): ?DiaryEntry;
    public function deleteEntry(int $id): bool;
    public function getEntriesByDateRange(string $startDate, string $endDate): Collection;
} 