<?php

namespace App\Interfaces;

use App\Models\DiaryEntry;
use Illuminate\Database\Eloquent\Collection;

interface DiaryEntryServiceInterface
{
    public function getUserEntries(int $userId): Collection;
    public function getEntry(int $id, int $userId): ?DiaryEntry;
    public function createEntry(array $data, int $userId): DiaryEntry;
    public function updateEntry(int $id, array $data, int $userId): ?DiaryEntry;
    public function deleteEntry(int $id, int $userId): bool;
    public function getEntriesByDateRange(int $userId, string $startDate, string $endDate): Collection;
} 