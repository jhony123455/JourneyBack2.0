<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function update(User $user, array $data): User;
    public function getUserStats(User $user): array;
} 