<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Repositories\BookmarkRepository;
use App\Repositories\ChecklistRepository;
use App\Repositories\PujaStatusRepository;

class ApiController extends Controller
{
    public function toggleChecklist(Request $request): void
    {
        $userId = Auth::id();
        if (!$userId) {
            $this->json(['error' => 'unauthenticated'], 401);
            return;
        }

        $itemId = (int) $request->input('item_id');
        $repo = new ChecklistRepository();
        $current = $repo->statusesForUser($userId)[$itemId] ?? 'not_started';
        $next = $current === 'completed' ? 'not_started' : 'completed';
        $repo->toggleForUser($userId, $itemId, $next);

        $this->json(['status' => $next]);
    }

    public function togglePujaStatus(Request $request): void
    {
        $userId = Auth::id();
        if (!$userId) {
            $this->json(['error' => 'unauthenticated'], 401);
            return;
        }

        $itemId = (int) $request->input('item_id');
        $field = $request->input('field') === 'prepared' ? 'prepared' : 'purchased';
        $repo = new PujaStatusRepository();
        $current = $repo->forUser($userId)[$itemId] ?? ['purchased' => 0, 'prepared' => 0];
        $newValue = !((bool) $current[$field]);

        if ($field === 'purchased') {
            $repo->updateStatus($userId, $itemId, $newValue, null);
        } else {
            $repo->updateStatus($userId, $itemId, null, $newValue);
        }

        $this->json(['field' => $field, 'value' => $newValue]);
    }

    public function toggleBookmark(Request $request): void
    {
        $userId = Auth::id();
        if (!$userId) {
            $this->json(['error' => 'unauthenticated'], 401);
            return;
        }

        $type = $request->input('type');
        $id = (int) $request->input('id');

        if (!in_array($type, ['navadurga', 'seva', 'article', 'mantra'], true)) {
            $this->json(['error' => 'invalid_type'], 422);
            return;
        }

        $repo = new BookmarkRepository();
        $bookmarked = $repo->toggle($userId, $type, $id);

        $this->json(['bookmarked' => $bookmarked]);
    }
}
