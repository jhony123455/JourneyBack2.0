<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserProfile(int $id): ?User
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new ModelNotFoundException('Usuario no encontrado');
        }
        
        $user->profile_completion = $user->getProfileCompletionPercentage();
        return $user;
    }

    public function updateUserProfile(int $id, array $data): User
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new ModelNotFoundException('Usuario no encontrado');
        }

        return $this->userRepository->update($user, $data);
    }

    public function getUserStats(int $id): array
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new ModelNotFoundException('Usuario no encontrado');
        }

        return $this->userRepository->getUserStats($user);
    }
} 