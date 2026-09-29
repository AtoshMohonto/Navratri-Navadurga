<?php

namespace App\Repositories;

use App\Core\Repository;

class ArticleRepository extends Repository
{
    protected string $table = 'articles';

    public function published(int $page = 1, int $perPage = 9, ?int $categoryId = null, ?string $search = null): array
    {
        $clauses = ["a.status = 'published'"];
        $params = [];

        if ($categoryId) {
            $clauses[] = 'a.category_id = :cat';
            $params['cat'] = $categoryId;
        }

        if ($search) {
            $clauses[] = '(a.title_bn LIKE :s OR a.excerpt LIKE :s OR a.content LIKE :s)';
            $params['s'] = '%' . $search . '%';
        }

        $where = 'WHERE ' . implode(' AND ', $clauses);
        $total = (int) $this->query("SELECT COUNT(*) AS c FROM articles a {$where}", $params)[0]['c'];
        $offset = ($page - 1) * $perPage;

        $rows = $this->query(
            "SELECT a.*, c.name_bn AS category_name FROM articles a
             LEFT JOIN categories c ON c.id = a.category_id
             {$where}
             ORDER BY a.published_at DESC, a.created_at DESC
             LIMIT {$perPage} OFFSET {$offset}",
            $params
        );

        return [
            'data' => $rows,
            'total' => $total,
            'page' => $page,
            'last_page' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    public function findBySlugPublished(string $slug): ?array
    {
        $rows = $this->query(
            "SELECT a.*, c.name_bn AS category_name FROM articles a
             LEFT JOIN categories c ON c.id = a.category_id
             WHERE a.slug = :slug AND a.status = 'published' LIMIT 1",
            ['slug' => $slug]
        );
        return $rows[0] ?? null;
    }

    public function related(int $categoryId, int $excludeId, int $limit = 3): array
    {
        return $this->query(
            "SELECT * FROM articles WHERE category_id = :cat AND id != :id AND status='published'
             ORDER BY published_at DESC LIMIT {$limit}",
            ['cat' => $categoryId, 'id' => $excludeId]
        );
    }

    public function featured(int $limit = 1): array
    {
        return $this->query(
            "SELECT * FROM articles WHERE status='published' ORDER BY published_at DESC LIMIT {$limit}"
        );
    }
}
