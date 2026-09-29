<?php

namespace App\Repositories;

use App\Core\Repository;

class BookmarkRepository extends Repository
{
    protected string $table = 'bookmarks';

    public function forUser(int $userId): array
    {
        return $this->all(['user_id' => $userId], 'created_at DESC');
    }

    public function isBookmarked(int $userId, string $type, int $itemId): bool
    {
        return $this->count(['user_id' => $userId, 'item_type' => $type, 'item_id' => $itemId]) > 0;
    }

    public function toggle(int $userId, string $type, int $itemId): bool
    {
        if ($this->isBookmarked($userId, $type, $itemId)) {
            $this->statement(
                "DELETE FROM bookmarks WHERE user_id = :u AND item_type = :t AND item_id = :i",
                ['u' => $userId, 't' => $type, 'i' => $itemId]
            );
            return false;
        }

        $this->insert(['user_id' => $userId, 'item_type' => $type, 'item_id' => $itemId]);
        return true;
    }
}
