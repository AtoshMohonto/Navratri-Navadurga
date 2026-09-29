<?php

namespace App\Repositories;

use App\Core\Repository;

class MantraRepository extends Repository
{
    protected string $table = 'mantras';

    public function byDay(int $day): array
    {
        return $this->all(['status' => 'active', 'associated_day' => $day], 'title_bn ASC');
    }

    public function allActive(): array
    {
        return $this->all(['status' => 'active'], 'associated_day ASC, title_bn ASC');
    }
}
