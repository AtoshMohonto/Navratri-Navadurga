<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;

class DashboardController extends Controller
{
    protected string $layout = 'layouts/admin';

    public function index(Request $request): void
    {
        $db = Database::connection();

        $count = function (string $table, string $where = '') use ($db): int {
            $sql = "SELECT COUNT(*) AS c FROM {$table}" . ($where ? " WHERE {$where}" : '');
            return (int) $db->query($sql)->fetch()['c'];
        };

        $stats = [
            'users' => $count('users'),
            'articles' => $count('articles'),
            'sevas' => $count('sevas'),
            'puja_items' => $count('puja_items'),
            'mantras' => $count('mantras'),
            'navadurga' => $count('navadurga'),
            'completed_checklists' => $count('user_checklist_status', "status = 'completed'"),
            'completed_seva' => $count('user_seva_logs'),
            'new_messages' => $count('contact_messages', "status = 'new'"),
        ];

        $this->view('admin/dashboard', [
            'title' => 'ড্যাশবোর্ড',
            'stats' => $stats,
        ]);
    }
}
