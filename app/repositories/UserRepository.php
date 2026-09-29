<?php

namespace App\Repositories;

use App\Core\Repository;

class UserRepository extends Repository
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->findBy('email', $email);
    }

    public function create(string $name, string $email, string $password, int $roleId = 1): int
    {
        return $this->insert([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role_id' => $roleId,
            'status' => 'active',
        ]);
    }

    public function paginateWithRole(int $page, int $perPage, array $conditions = []): array
    {
        [$where, $params] = $this->buildWhere($conditions);
        $total = $this->count($conditions);
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT u.*, r.name AS role_name FROM users u
                LEFT JOIN roles r ON r.id = u.role_id
                {$where}
                ORDER BY u.created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $rows = $this->query($sql, $params);

        return [
            'data' => $rows,
            'total' => $total,
            'page' => $page,
            'last_page' => max(1, (int) ceil($total / $perPage)),
        ];
    }
}
