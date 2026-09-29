<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Repositories\PujaItemRepository;
use App\Repositories\PujaStatusRepository;

class PujaItemController extends Controller
{
    public function index(Request $request): void
    {
        $repo = new PujaItemRepository();
        $category = $request->query('category') ?: null;
        $day = $request->query('day') ?: null;

        $items = $repo->filtered($category, $day);
        $statuses = Auth::check() ? (new PujaStatusRepository())->forUser(Auth::id()) : [];

        $this->view('pages/puja-items', [
            'title' => 'পূজা সামগ্রী',
            'metaDescription' => 'নবরাত্রি পূজার জন্য প্রয়োজনীয় সামগ্রীর সম্পূর্ণ তালিকা।',
            'breadcrumbs' => [['label' => 'পূজা সামগ্রী']],
            'items' => $items,
            'categories' => $repo->categories(),
            'category' => $category,
            'day' => $day,
            'statuses' => $statuses,
        ]);
    }
}
