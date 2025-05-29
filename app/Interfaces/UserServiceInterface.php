<?php

namespace App\Interfaces;

use App\Models\User;

interface UserServiceInterface
{
    public function getUserProfile(int $id): ?User;
    public function updateUserProfile(int $id, array $data): User;
    public function getUserStats(int $id): array;
} 