<?php

namespace App\Repositories;

use App\Core\Repository;

class ChildrenActivityRepository extends Repository
{
    protected string $table = 'children_activities';

    public function allActive(): array
    {
        return $this->all(['status' => 'active'], 'day_number ASC, id ASC');
    }

    public function byDay(int $day): array
    {
        return $this->all(['status' => 'active', 'day_number' => $day], 'id ASC');
    }
}
