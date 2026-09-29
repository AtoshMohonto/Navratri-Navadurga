<?php

namespace App\Repositories;

use App\Core\Repository;

class ReflectionRepository extends Repository
{
    protected string $table = 'daily_reflections';

    public function forUser(int $userId): array
    {
        return $this->all(['user_id' => $userId], 'day_number DESC, created_at DESC');
    }

    public function save(int $userId, int $day, string $learned, string $helped, string $change): int
    {
        return $this->insert([
            'user_id' => $userId,
            'day_number' => $day,
            'learned_text' => $learned,
            'helped_text' => $helped,
            'change_text' => $change,
        ]);
    }
}
