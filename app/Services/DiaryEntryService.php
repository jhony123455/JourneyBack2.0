<?php

namespace App\Services;

use App\Interfaces\DiaryEntryRepositoryInterface;
use App\Interfaces\DiaryEntryServiceInterface;
use App\Models\DiaryEntry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\Access\AuthorizationException;

class DiaryEntryService implements DiaryEntryServiceInterface
{
    protected $repository;

    public function __construct(DiaryEntryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getUserEntries(): Collection
    {
        return $this->repository->getAllByUser();
    }

    public function getEntry(int $id): ?DiaryEntry
    {
        $entry = $this->repository->getById($id);
        
        if (!$entry) {
            throw new AuthorizationException('No estás autorizado para ver esta entrada.');
        }

        return $entry;
    }

    public function createEntry(array $data): DiaryEntry
    {
        return $this->repository->create($data);
    }

    public function updateEntry(int $id, array $data): ?DiaryEntry
    {
        $entry = $this->repository->update($id, $data);
        
        if (!$entry) {
            throw new AuthorizationException('No estás autorizado para actualizar esta entrada.');
        }

        return $entry;
    }

    public function deleteEntry(int $id): bool
    {
        if (!$this->repository->delete($id)) {
            throw new AuthorizationException('No estás autorizado para eliminar esta entrada.');
        }

        return true;
    }

    public function getEntriesByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->repository->getByDateRange($startDate, $endDate);
    }
} 