<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\ChildrenActivityRepository;
use App\Repositories\EnvironmentActivityRepository;
use App\Repositories\FamilyActivityRepository;
use App\Repositories\NavadurgaRepository;
use App\Repositories\SevaRepository;

class NavadurgaController extends Controller
{
    public function index(Request $request): void
    {
        $repo = new NavadurgaRepository();

        $this->view('pages/navadurga/index', [
            'title' => 'নবদুর্গা — নয়টি রূপ',
            'metaDescription' => 'নবদুর্গার নয়টি রূপের পরিচিতি — শৈলপুত্রী থেকে সিদ্ধিদাত্রী পর্যন্ত।',
            'breadcrumbs' => [['label' => 'নবদুর্গা']],
            'forms' => $repo->allOrdered(),
        ]);
    }

    public function show(Request $request, string $slug): void
    {
        $repo = new NavadurgaRepository();
        $item = $repo->findBySlug($slug);

        if (!$item || $item['status'] !== 'active') {
            $this->abort(404);
            return;
        }

        $neighbours = $repo->neighbours($item['day_number']);
        $sevaRepo = new SevaRepository();

        $this->view('pages/navadurga/show', [
            'title' => $item['seo_title'] ?: $item['name_bn'] . ' — নবদুর্গা',
            'metaDescription' => $item['seo_description'] ?: truncate($item['short_description'], 160),
            'breadcrumbs' => [['label' => 'নবদুর্গা', 'url' => '/navadurga'], ['label' => $item['name_bn']]],
            'item' => $item,
            'prev' => $neighbours['prev'],
            'next' => $neighbours['next'],
            'sevas' => $sevaRepo->byDay($item['day_number'], 6),
            'childrenActivities' => (new ChildrenActivityRepository())->byDay($item['day_number']),
            'familyActivities' => (new FamilyActivityRepository())->byDay($item['day_number']),
            'environmentActivities' => (new EnvironmentActivityRepository())->allActive(),
            'relatedArticles' => (new ArticleRepository())->published(1, 3)['data'],
        ]);
    }
}
