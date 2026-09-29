<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;

class ArticleController extends Controller
{
    public function index(Request $request): void
    {
        $repo = new ArticleRepository();
        $page = max(1, (int) $request->query('page', 1));
        $categoryId = $request->query('category') ? (int) $request->query('category') : null;
        $search = trim((string) $request->query('q', ''));

        $result = $repo->published($page, 9, $categoryId, $search ?: null);

        $this->view('pages/articles/index', [
            'title' => 'নিবন্ধ',
            'metaDescription' => 'নবদুর্গা, নবরাত্রি, পূজা, আধ্যাত্মিকতা ও সেবা বিষয়ক নিবন্ধ।',
            'breadcrumbs' => [['label' => 'নিবন্ধ']],
            'articles' => $result['data'],
            'pagination' => $result,
            'categories' => (new CategoryRepository())->byType('article'),
            'categoryId' => $categoryId,
            'q' => $search,
        ]);
    }

    public function show(Request $request, string $slug): void
    {
        $repo = new ArticleRepository();
        $item = $repo->findBySlugPublished($slug);

        if (!$item) {
            $this->abort(404);
            return;
        }

        $related = $item['category_id'] ? $repo->related((int) $item['category_id'], (int) $item['id']) : [];

        $this->view('pages/articles/show', [
            'title' => $item['seo_title'] ?: $item['title_bn'],
            'metaDescription' => $item['seo_description'] ?: truncate($item['excerpt'], 160),
            'breadcrumbs' => [['label' => 'নিবন্ধ', 'url' => '/articles'], ['label' => $item['title_bn']]],
            'item' => $item,
            'related' => $related,
        ]);
    }
}
