<?php

namespace App\Repositories;

use App\Core\Repository;

class NavadurgaRepository extends Repository
{
    protected string $table = 'navadurga';

    public function allOrdered(bool $activeOnly = true): array
    {
        $conditions = $activeOnly ? ['status' => 'active'] : [];
        return $this->all($conditions, 'day_number ASC');
    }

    public function findByDay(int $day): ?array
    {
        return $this->findBy('day_number', $day);
    }

    public function neighbours(int $dayNumber): array
    {
        $prev = $this->query(
            "SELECT * FROM navadurga WHERE day_number = :d AND status='active'",
            ['d' => $dayNumber - 1]
        );
        $next = $this->query(
            "SELECT * FROM navadurga WHERE day_number = :d AND status='active'",
            ['d' => $dayNumber + 1]
        );

        return [
            'prev' => $prev[0] ?? null,
            'next' => $next[0] ?? null,
        ];
    }
}
