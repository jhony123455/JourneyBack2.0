<?php

namespace App\Interfaces;

use App\Models\User;

interface UserServiceInterface
{
    public function getUserProfile(int $userId): User;
    public function updateUserProfile(int $userId, array $data): User;
    public function getUserStats(int $userId): array;
} 