<?php

namespace App\Repositories;

use App\Core\Repository;

class SevaLogRepository extends Repository
{
    protected string $table = 'user_seva_logs';

    public function forUser(int $userId): array
    {
        return $this->query(
            "SELECT l.*, s.title_bn AS seva_title FROM user_seva_logs l
             LEFT JOIN sevas s ON s.id = l.seva_id
             WHERE l.user_id = :uid ORDER BY l.completed_at DESC",
            ['uid' => $userId]
        );
    }

    public function countForUser(int $userId): int
    {
        return $this->count(['user_id' => $userId]);
    }
}
