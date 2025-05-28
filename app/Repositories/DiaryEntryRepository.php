<?php

namespace App\Repositories;

use App\Interfaces\DiaryEntryRepositoryInterface;
use App\Models\DiaryEntry;
use Illuminate\Database\Eloquent\Collection;

class DiaryEntryRepository implements DiaryEntryRepositoryInterface
{
    public function getAllByUser(int $userId): Collection
    {
        return DiaryEntry::where('user_id', $userId)
            ->orderBy('entry_date', 'desc')
            ->get();
    }

    public function getById(int $id): ?DiaryEntry
    {
        return DiaryEntry::find($id);
    }

    public function create(array $data): DiaryEntry
    {
        return DiaryEntry::create($data);
    }

    public function update(int $id, array $data): ?DiaryEntry
    {
        $entry = $this->getById($id);
        if ($entry) {
            $entry->update($data);
            return $entry;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $entry = $this->getById($id);
        if ($entry) {
            return $entry->delete();
        }
        return false;
    }

    public function getByDateRange(int $userId, string $startDate, string $endDate): Collection
    {
        return DiaryEntry::where('user_id', $userId)
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->orderBy('entry_date', 'desc')
            ->get();
    }
} 