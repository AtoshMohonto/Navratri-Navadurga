<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\MantraRepository;

class MantraController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('pages/mantras/index', [
            'title' => 'মন্ত্র',
            'metaDescription' => 'নবদুর্গা ও নবরাত্রি সম্পর্কিত মন্ত্র, উচ্চারণ ও অর্থ।',
            'breadcrumbs' => [['label' => 'মন্ত্র']],
            'mantras' => (new MantraRepository())->allActive(),
        ]);
    }

    public function show(Request $request, string $slug): void
    {
        $repo = new MantraRepository();
        $item = $repo->findBySlug($slug);

        if (!$item || $item['status'] !== 'active') {
            $this->abort(404);
            return;
        }

        $this->view('pages/mantras/show', [
            'title' => $item['title_bn'],
            'metaDescription' => truncate($item['meaning_bn'], 160),
            'breadcrumbs' => [['label' => 'মন্ত্র', 'url' => '/mantras'], ['label' => $item['title_bn']]],
            'item' => $item,
        ]);
    }
}
