<?php

namespace App\Interfaces;

use App\Models\DiaryEntry;
use Illuminate\Database\Eloquent\Collection;

interface DiaryEntryRepositoryInterface
{
    public function getAllByUser(): Collection;
    public function getById(int $id): ?DiaryEntry;
    public function create(array $data): DiaryEntry;
    public function update(int $id, array $data): ?DiaryEntry;
    public function delete(int $id): bool;
    public function getByDateRange(string $startDate, string $endDate): Collection;
} 