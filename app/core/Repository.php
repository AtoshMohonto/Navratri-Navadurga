<?php

namespace App\Core;

use PDO;

abstract class Repository
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * @param array<string,mixed> $conditions column => value (AND-combined, always parameter bound)
     */
    public function all(array $conditions = [], ?string $orderBy = null, ?int $limit = null): array
    {
        [$where, $params] = $this->buildWhere($conditions);
        $sql = "SELECT * FROM {$this->table} {$where}";

        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }

        if ($limit) {
            $sql .= " LIMIT " . (int) $limit;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find($id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findBy(string $column, $value): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1");
        $stmt->execute(['value' => $value]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->findBy('slug', $slug);
    }

    public function count(array $conditions = []): int
    {
        [$where, $params] = $this->buildWhere($conditions);
        $stmt = $this->db->prepare("SELECT COUNT(*) AS c FROM {$this->table} {$where}");
        $stmt->execute($params);
        return (int) $stmt->fetch()['c'];
    }

    public function paginate(int $page, int $perPage, array $conditions = [], ?string $orderBy = null): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;
        $total = $this->count($conditions);

        [$where, $params] = $this->buildWhere($conditions);
        $sql = "SELECT * FROM {$this->table} {$where}";
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        $sql .= " LIMIT {$perPage} OFFSET {$offset}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return [
            'data' => $stmt->fetchAll(),
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'last_page' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    public function insert(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($c) => ':' . $c, $columns);

        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    public function update($id, array $data): bool
    {
        $set = implode(',', array_map(fn($c) => "{$c} = :{$c}", array_keys($data)));
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = :__id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array_merge($data, ['__id' => $id]));
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    protected function buildWhere(array $conditions): array
    {
        if (empty($conditions)) {
            return ['', []];
        }

        $clauses = [];
        $params = [];

        foreach ($conditions as $column => $value) {
            if (is_array($value)) {
                $in = [];
                foreach ($value as $i => $v) {
                    $key = "{$column}_{$i}";
                    $in[] = ":{$key}";
                    $params[$key] = $v;
                }
                $clauses[] = "{$column} IN (" . implode(',', $in) . ")";
            } else {
                $clauses[] = "{$column} = :{$column}";
                $params[$column] = $value;
            }
        }

        return ['WHERE ' . implode(' AND ', $clauses), $params];
    }

    /**
     * @param string[] $columns columns to LIKE-search across (OR-combined)
     */
    public function searchPaginate(array $columns, string $term, int $page, int $perPage, array $extraConditions = [], ?string $orderBy = null): array
    {
        [$extraWhere, $params] = $this->buildWhere($extraConditions);
        $clauses = [];

        if ($term !== '' && !empty($columns)) {
            $likeClauses = [];
            foreach ($columns as $i => $col) {
                $key = "search_{$i}";
                $likeClauses[] = "{$col} LIKE :{$key}";
                $params[$key] = '%' . $term . '%';
            }
            $clauses[] = '(' . implode(' OR ', $likeClauses) . ')';
        }

        $where = $extraWhere;
        if (!empty($clauses)) {
            $where = $where === '' ? 'WHERE ' . implode(' AND ', $clauses) : $where . ' AND ' . implode(' AND ', $clauses);
        }

        $total = (int) $this->query("SELECT COUNT(*) AS c FROM {$this->table} {$where}", $params)[0]['c'];
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM {$this->table} {$where}";
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        $sql .= " LIMIT {$perPage} OFFSET {$offset}";

        $rows = $this->query($sql, $params);

        return [
            'data' => $rows,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'last_page' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function statement(string $sql, array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
