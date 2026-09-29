<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Repositories\BookmarkRepository;

class BookmarkController extends Controller
{
    protected array $tables = [
        'navadurga' => ['table' => 'navadurga', 'title' => 'name_bn', 'url' => '/navadurga/', 'key' => 'slug'],
        'seva' => ['table' => 'sevas', 'title' => 'title_bn', 'url' => '/seva/', 'key' => 'slug'],
        'article' => ['table' => 'articles', 'title' => 'title_bn', 'url' => '/articles/', 'key' => 'slug'],
        'mantra' => ['table' => 'mantras', 'title' => 'title_bn', 'url' => '/mantras/', 'key' => 'slug'],
    ];

    public function index(Request $request): void
    {
        $userId = Auth::id();
        $bookmarks = (new BookmarkRepository())->forUser($userId);
        $db = Database::connection();

        $items = [];
        foreach ($bookmarks as $b) {
            $meta = $this->tables[$b['item_type']] ?? null;
            if (!$meta) {
                continue;
            }
            $stmt = $db->prepare("SELECT * FROM {$meta['table']} WHERE id = :id");
            $stmt->execute(['id' => $b['item_id']]);
            $row = $stmt->fetch();
            if ($row) {
                $items[] = [
                    'type' => $b['item_type'],
                    'title' => $row[$meta['title']],
                    'url' => $meta['url'] . $row[$meta['key']],
                ];
            }
        }

        $this->view('pages/bookmarks', [
            'title' => 'আমার বুকমার্ক',
            'breadcrumbs' => [['label' => 'বুকমার্ক']],
            'items' => $items,
        ]);
    }
}
