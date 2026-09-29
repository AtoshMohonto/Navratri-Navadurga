<?php

namespace App\Repositories;

use App\Core\Repository;

class SettingsRepository extends Repository
{
    protected string $table = 'site_settings';

    public function all(array $conditions = [], ?string $orderBy = null, ?int $limit = null): array
    {
        $rows = parent::all($conditions, $orderBy, $limit);
        $map = [];
        foreach ($rows as $row) {
            $map[$row['key']] = $row['value'];
        }
        return $map;
    }

    public function allRaw(): array
    {
        return parent::all([], 'key ASC');
    }

    public function get(string $key, $default = null)
    {
        $row = $this->findBy('key', $key);
        return $row ? $row['value'] : $default;
    }

    public function set(string $key, string $value): void
    {
        $this->statement(
            "INSERT INTO site_settings (`key`, `value`) VALUES (:k, :v)
             ON DUPLICATE KEY UPDATE `value` = :v2",
            ['k' => $key, 'v' => $value, 'v2' => $value]
        );
    }
}
