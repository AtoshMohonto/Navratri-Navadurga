<?php

namespace App\Repositories;

use App\Core\Repository;

class GalleryRepository extends Repository
{
    protected string $table = 'gallery';

    public function allActive(?string $category = null): array
    {
        $conditions = ['status' => 'active'];
        if ($category) {
            $conditions['category'] = $category;
        }
        return $this->all($conditions, 'created_at DESC');
    }
}
