<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\FaqRepository;
use App\Repositories\MantraRepository;
use App\Repositories\NavadurgaRepository;
use App\Repositories\PujaItemRepository;
use App\Repositories\SevaRepository;

class SearchController extends Controller
{
    public function index(Request $request): void
    {
        $q = trim((string) $request->query('q', ''));
        $results = [
            'navadurga' => [], 'articles' => [], 'seva' => [], 'mantras' => [], 'puja_items' => [], 'faq' => [],
        ];

        if ($q !== '') {
            $like = '%' . $q . '%';

            $results['navadurga'] = (new NavadurgaRepository())->query(
                "SELECT * FROM navadurga WHERE status='active' AND (name_bn LIKE :q OR name_en LIKE :q OR short_description LIKE :q) LIMIT 6",
                ['q' => $like]
            );
            $results['articles'] = (new ArticleRepository())->query(
                "SELECT * FROM articles WHERE status='published' AND (title_bn LIKE :q OR excerpt LIKE :q OR content LIKE :q) LIMIT 6",
                ['q' => $like]
            );
            $results['seva'] = (new SevaRepository())->query(
                "SELECT * FROM sevas WHERE status='active' AND (title_bn LIKE :q OR description LIKE :q) LIMIT 6",
                ['q' => $like]
            );
            $results['mantras'] = (new MantraRepository())->query(
                "SELECT * FROM mantras WHERE status='active' AND (title_bn LIKE :q OR meaning_bn LIKE :q) LIMIT 6",
                ['q' => $like]
            );
            $results['puja_items'] = (new PujaItemRepository())->query(
                "SELECT * FROM puja_items WHERE status='active' AND (name_bn LIKE :q OR name_en LIKE :q) LIMIT 6",
                ['q' => $like]
            );
            $results['faq'] = (new FaqRepository())->query(
                "SELECT * FROM faqs WHERE status='active' AND (question_bn LIKE :q OR answer_bn LIKE :q) LIMIT 6",
                ['q' => $like]
            );
        }

        $total = array_sum(array_map('count', $results));

        $this->view('pages/search', [
            'title' => 'অনুসন্ধান',
            'metaDescription' => 'নবদুর্গা ওয়েবসাইটে অনুসন্ধান করুন।',
            'breadcrumbs' => [['label' => 'অনুসন্ধান']],
            'q' => $q,
            'results' => $results,
            'total' => $total,
        ]);
    }
}
