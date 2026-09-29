<?php

namespace App\Repositories;

use App\Core\Repository;

class CalendarRepository extends Repository
{
    protected string $table = 'festival_calendar';

    public function forYear(int $year): array
    {
        return $this->query(
            "SELECT fc.*, n.name_bn AS navadurga_name_bn, n.slug AS navadurga_slug
             FROM festival_calendar fc
             LEFT JOIN navadurga n ON n.id = fc.navadurga_id
             WHERE fc.year = :year
             ORDER BY fc.gregorian_date ASC",
            ['year' => $year]
        );
    }

    public function findByDate(int $year, string $date): ?array
    {
        $rows = $this->query(
            "SELECT * FROM festival_calendar WHERE year = :year AND gregorian_date = :date LIMIT 1",
            ['year' => $year, 'date' => $date]
        );
        return $rows[0] ?? null;
    }

    public function availableYears(): array
    {
        $rows = $this->query("SELECT DISTINCT year FROM festival_calendar ORDER BY year DESC");
        return array_map(fn($r) => (int) $r['year'], $rows);
    }

    public function nextUpcoming(int $year): ?array
    {
        $rows = $this->query(
            "SELECT * FROM festival_calendar WHERE year = :year AND gregorian_date >= :today ORDER BY gregorian_date ASC LIMIT 1",
            ['year' => $year, 'today' => date('Y-m-d')]
        );
        return $rows[0] ?? null;
    }
}
