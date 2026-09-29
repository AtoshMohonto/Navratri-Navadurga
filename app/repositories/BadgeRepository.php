<?php

namespace App\Repositories;

use App\Core\Repository;

class BadgeRepository extends Repository
{
    protected string $table = 'badges';

    public function forUser(int $userId): array
    {
        return $this->query(
            "SELECT b.* FROM badges b
             JOIN user_badges ub ON ub.badge_id = b.id
             WHERE ub.user_id = :uid",
            ['uid' => $userId]
        );
    }

    public function award(int $userId, string $code): void
    {
        $badge = $this->findBy('code', $code);
        if (!$badge) {
            return;
        }

        $this->statement(
            "INSERT IGNORE INTO user_badges (user_id, badge_id) VALUES (:u, :b)",
            ['u' => $userId, 'b' => $badge['id']]
        );
    }
}
