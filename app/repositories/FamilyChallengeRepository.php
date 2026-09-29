<?php

namespace App\Repositories;

use App\Core\Repository;

class FamilyChallengeRepository extends Repository
{
    protected string $table = 'family_challenge_log';

    public function forUser(int $userId): array
    {
        $rows = $this->all(['user_id' => $userId]);
        $map = [];
        foreach ($rows as $row) {
            $map[$row['day_number']] = $row;
        }
        return $map;
    }

    public function setStatus(int $userId, int $day, string $status, ?string $note = null): void
    {
        $this->statement(
            "INSERT INTO family_challenge_log (user_id, day_number, status, note)
             VALUES (:u, :d, :s, :n)
             ON DUPLICATE KEY UPDATE status = :s2, note = :n2, updated_at = CURRENT_TIMESTAMP",
            ['u' => $userId, 'd' => $day, 's' => $status, 'n' => $note, 's2' => $status, 'n2' => $note]
        );
    }
}
