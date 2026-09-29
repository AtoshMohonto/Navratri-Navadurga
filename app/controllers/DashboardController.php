<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Repositories\BadgeRepository;
use App\Repositories\BookmarkRepository;
use App\Repositories\ChecklistRepository;
use App\Repositories\FamilyChallengeRepository;
use App\Repositories\SevaLogRepository;

class DashboardController extends Controller
{
    public function index(Request $request): void
    {
        $userId = Auth::id();
        $checklistRepo = new ChecklistRepository();
        $statuses = $checklistRepo->statusesForUser($userId);
        $completedChecklist = count(array_filter($statuses, fn($s) => $s === 'completed'));
        $totalChecklist = (new ChecklistRepository())->count(['status' => 'active']);

        $sevaLogs = (new SevaLogRepository())->forUser($userId);
        $familyChallenge = (new FamilyChallengeRepository())->forUser($userId);
        $familyCompleted = count(array_filter($familyChallenge, fn($r) => $r['status'] === 'completed'));
        $badges = (new BadgeRepository())->forUser($userId);
        $bookmarks = (new BookmarkRepository())->forUser($userId);

        // Simple, non-competitive badge awarding based on activity so far.
        $badgeRepo = new BadgeRepository();
        if (count($sevaLogs) >= 1) { $badgeRepo->award($userId, 'first_seva'); }
        if ($familyCompleted >= 9) { $badgeRepo->award($userId, 'nine_day_companion'); }
        if (count($bookmarks) >= 5) { $badgeRepo->award($userId, 'gyan_sondhani'); }

        $this->view('pages/dashboard', [
            'title' => 'আমার অ্যাকাউন্ট',
            'breadcrumbs' => [['label' => 'আমার অ্যাকাউন্ট']],
            'user' => Auth::user(),
            'completedChecklist' => $completedChecklist,
            'totalChecklist' => $totalChecklist,
            'sevaLogs' => $sevaLogs,
            'familyCompleted' => $familyCompleted,
            'badges' => (new BadgeRepository())->forUser($userId),
            'bookmarks' => $bookmarks,
        ]);
    }
}
