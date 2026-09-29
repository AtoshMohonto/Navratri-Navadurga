<?php

namespace App\Repositories;

use App\Core\Repository;

class NavaratriDayRepository extends Repository
{
    protected string $table = 'navaratri_days';

    public function allWithNavadurga(): array
    {
        return $this->query(
            "SELECT nd.*, n.name_bn AS navadurga_name_bn, n.name_en AS navadurga_name_en,
                    n.slug AS navadurga_slug, n.image AS navadurga_image, n.colour AS navadurga_colour
             FROM navaratri_days nd
             JOIN navadurga n ON n.id = nd.navadurga_id
             WHERE nd.status = 'active'
             ORDER BY nd.day_number ASC"
        );
    }

    public function findByDayWithNavadurga(int $day): ?array
    {
        $rows = $this->query(
            "SELECT nd.*, n.name_bn AS navadurga_name_bn, n.name_en AS navadurga_name_en,
                    n.slug AS navadurga_slug, n.image AS navadurga_image, n.colour AS navadurga_colour,
                    n.mantra AS navadurga_mantra, n.short_description AS navadurga_short_description
             FROM navaratri_days nd
             JOIN navadurga n ON n.id = nd.navadurga_id
             WHERE nd.day_number = :d AND nd.status = 'active'
             LIMIT 1",
            ['d' => $day]
        );

        return $rows[0] ?? null;
    }
}
