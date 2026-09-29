<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Repositories\ChecklistRepository;

class ChecklistController extends Controller
{
    public function index(Request $request): void
    {
        $repo = new ChecklistRepository();
        $grouped = $repo->allGroupedByPhase();
        $statuses = Auth::check() ? $repo->statusesForUser(Auth::id()) : [];

        $this->view('pages/puja-planning', [
            'title' => 'পূজা পরিকল্পনা',
            'metaDescription' => 'নবরাত্রি পূজার ধাপে ধাপে প্রস্তুতি ও চেকলিস্ট।',
            'breadcrumbs' => [['label' => 'পূজা পরিকল্পনা']],
            'grouped' => $grouped,
            'statuses' => $statuses,
        ]);
    }
}
