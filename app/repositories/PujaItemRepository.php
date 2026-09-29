<?php

namespace App\Repositories;

use App\Core\Repository;

class PujaItemRepository extends Repository
{
    protected string $table = 'puja_items';

    public function categories(): array
    {
        return [
            'মূল পূজার উপকরণ', 'ফুল', 'ফল', 'নৈবেদ্য', 'প্রদীপ', 'ধূপ',
            'বস্ত্র', 'পাত্র', 'সাজসজ্জা', 'প্রসাদ', 'অন্যান্য',
        ];
    }

    public function filtered(?string $category = null, ?string $day = null): array
    {
        $clauses = ["status = 'active'"];
        $params = [];

        if ($category) {
            $clauses[] = 'category = :category';
            $params['category'] = $category;
        }

        if ($day) {
            $clauses[] = 'used_day LIKE :day';
            $params['day'] = '%' . $day . '%';
        }

        $where = 'WHERE ' . implode(' AND ', $clauses);
        return $this->query("SELECT * FROM puja_items {$where} ORDER BY category ASC, name_bn ASC", $params);
    }
}
