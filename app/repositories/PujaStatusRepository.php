<?php

namespace App\Repositories;

use App\Core\Repository;

class PujaStatusRepository extends Repository
{
    protected string $table = 'user_puja_status';

    public function forUser(int $userId): array
    {
        $rows = $this->all(['user_id' => $userId]);
        $map = [];
        foreach ($rows as $row) {
            $map[$row['puja_item_id']] = $row;
        }
        return $map;
    }

    public function updateStatus(int $userId, int $itemId, ?bool $purchased, ?bool $prepared): void
    {
        $existing = $this->query(
            "SELECT * FROM user_puja_status WHERE user_id = :u AND puja_item_id = :i",
            ['u' => $userId, 'i' => $itemId]
        );
        $current = $existing[0] ?? ['purchased' => 0, 'prepared' => 0];

        $purchasedVal = $purchased === null ? $current['purchased'] : (int) $purchased;
        $preparedVal = $prepared === null ? $current['prepared'] : (int) $prepared;

        $this->statement(
            "INSERT INTO user_puja_status (user_id, puja_item_id, purchased, prepared)
             VALUES (:u, :i, :p, :pr)
             ON DUPLICATE KEY UPDATE purchased = :p2, prepared = :pr2",
            ['u' => $userId, 'i' => $itemId, 'p' => $purchasedVal, 'pr' => $preparedVal, 'p2' => $purchasedVal, 'pr2' => $preparedVal]
        );
    }
}
