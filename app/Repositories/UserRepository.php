<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['fecha_registro'] = now();
        
        return $this->model->create($data);
    }

    public function findByName(string $name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function getUserStats(User $user): array
    {
        return [
            'diary_entries_count' => $user->diaryEntries()->count(),
            'activities_count' => $user->activities()->count(),
            'calendar_events_count' => $user->calendarEvents()->count(),
            'tags_count' => $user->tags()->count(),
            'profile_completion' => $user->getProfileCompletionPercentage(),
            'age' => $user->getAge(),
            'member_since' => $user->fecha_registro->diffForHumans()
        ];
    }
}