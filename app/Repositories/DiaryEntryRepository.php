<?php

namespace App\Repositories;

use App\Interfaces\DiaryEntryRepositoryInterface;
use App\Models\DiaryEntry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DiaryEntryRepository implements DiaryEntryRepositoryInterface
{
    public function getAllByUser(): Collection
    {
        return DiaryEntry::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->get();
    }

    public function getById(int $id): ?DiaryEntry
    {
        return DiaryEntry::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();
    }

    public function create(array $data): DiaryEntry
    {
        $data['user_id'] = Auth::id();
        return DiaryEntry::create($data);
    }

    public function update(int $id, array $data): ?DiaryEntry
    {
        $entry = DiaryEntry::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($entry) {
            $entry->update($data);
            return $entry;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $entry = DiaryEntry::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($entry) {
            return $entry->delete();
        }
        return false;
    }

    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        return DiaryEntry::where('user_id', Auth::id())
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->orderBy('entry_date', 'desc')
            ->get();
    }
} 