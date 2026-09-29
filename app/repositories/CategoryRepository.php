<?php

namespace App\Repositories;

use App\Core\Repository;

class CategoryRepository extends Repository
{
    protected string $table = 'categories';

    public function byType(string $type): array
    {
        return $this->all(['type' => $type], 'name_bn ASC');
    }
}
