<?php

namespace App\Repositories;

use App\Core\Repository;

class FaqRepository extends Repository
{
    protected string $table = 'faqs';

    public function allActive(): array
    {
        return $this->all(['status' => 'active'], 'sort_order ASC, id ASC');
    }

    public function groupedByCategory(): array
    {
        $rows = $this->allActive();
        $grouped = [];
        foreach ($rows as $row) {
            $cat = $row['category'] ?: 'সাধারণ';
            $grouped[$cat][] = $row;
        }
        return $grouped;
    }
}
