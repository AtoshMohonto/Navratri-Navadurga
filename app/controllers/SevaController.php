<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\SevaLogRepository;
use App\Repositories\SevaRepository;

class SevaController extends Controller
{
    public function index(Request $request): void
    {
        $repo = new SevaRepository();
        $page = max(1, (int) $request->query('page', 1));

        $filters = [
            'category' => $request->query('category') ?: null,
            'difficulty' => $request->query('difficulty') ?: null,
            'budget' => $request->query('budget') ?: null,
            'time' => $request->query('time') ?: null,
            'day' => $request->query('day') ?: null,
        ];

        $result = $repo->filter($filters, $page, 12);

        $this->view('pages/seva/index', [
            'title' => 'সেবা',
            'metaDescription' => 'সময়, বাজেট ও আগ্রহ অনুযায়ী নবরাত্রিতে করার মতো সেবা ও সামাজিক কাজের প্রস্তাব।',
            'breadcrumbs' => [['label' => 'সেবা']],
            'sevas' => $result['data'],
            'pagination' => $result,
            'categories' => $repo->categories(),
            'filters' => $filters,
        ]);
    }

    public function show(Request $request, string $slug): void
    {
        $repo = new SevaRepository();
        $item = $repo->findBySlug($slug);

        if (!$item || $item['status'] !== 'active') {
            $this->abort(404);
            return;
        }

        $this->view('pages/seva/show', [
            'title' => $item['title_bn'],
            'metaDescription' => truncate($item['description'], 160),
            'breadcrumbs' => [['label' => 'সেবা', 'url' => '/seva'], ['label' => $item['title_bn']]],
            'item' => $item,
        ]);
    }

    public function complete(Request $request, string $slug): void
    {
        if (!Auth::check()) {
            Session::flash('error', 'সেবা সম্পন্ন হিসেবে চিহ্নিত করতে লগইন করুন।');
            $this->redirect('/login');
            return;
        }

        $repo = new SevaRepository();
        $item = $repo->findBySlug($slug);

        if (!$item) {
            $this->abort(404);
            return;
        }

        (new SevaLogRepository())->insert([
            'user_id' => Auth::id(),
            'seva_id' => $item['id'],
            'navadurga_day' => $item['navadurga_day'],
            'note' => trim((string) $request->input('note', '')) ?: null,
        ]);

        Session::flash('success', 'অভিনন্দন! আপনার সেবা রেকর্ড করা হয়েছে।');
        $this->redirect('/seva/' . $slug);
    }
}
