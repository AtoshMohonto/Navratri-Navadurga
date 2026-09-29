<?php

namespace App\Repositories;

use App\Core\Repository;

class ChecklistRepository extends Repository
{
    protected string $table = 'checklist_items';

    public function byPhase(string $phase): array
    {
        return $this->all(['status' => 'active', 'phase' => $phase], 'sort_order ASC, id ASC');
    }

    public function allGroupedByPhase(): array
    {
        $rows = $this->all(['status' => 'active'], 'phase ASC, sort_order ASC, id ASC');
        $grouped = ['before' => [], 'day' => [], 'dashami' => []];
        foreach ($rows as $row) {
            $grouped[$row['phase']][] = $row;
        }
        return $grouped;
    }

    public function statusesForUser(int $userId): array
    {
        $rows = $this->query(
            "SELECT checklist_item_id, status FROM user_checklist_status WHERE user_id = :uid",
            ['uid' => $userId]
        );

        $map = [];
        foreach ($rows as $row) {
            $map[$row['checklist_item_id']] = $row['status'];
        }
        return $map;
    }

    public function toggleForUser(int $userId, int $itemId, string $status): void
    {
        $completedAt = $status === 'completed' ? date('Y-m-d H:i:s') : null;

        $this->statement(
            "INSERT INTO user_checklist_status (user_id, checklist_item_id, status, completed_at)
             VALUES (:uid, :item, :status, :completed_at)
             ON DUPLICATE KEY UPDATE status = :status2, completed_at = :completed_at2",
            [
                'uid' => $userId, 'item' => $itemId, 'status' => $status, 'completed_at' => $completedAt,
                'status2' => $status, 'completed_at2' => $completedAt,
            ]
        );
    }
}
