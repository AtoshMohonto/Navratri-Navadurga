<?php

namespace App\Repositories;

use App\Core\Repository;

class EnvironmentActivityRepository extends Repository
{
    protected string $table = 'environment_activities';

    public function allActive(): array
    {
        return $this->all(['status' => 'active'], 'id ASC');
    }
}
