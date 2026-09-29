<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;

class LearningController extends Controller
{
    public function index(Request $request): void
    {
        $categoryRepo = new CategoryRepository();
        $articleRepo = new ArticleRepository();

        $topics = [
            ['label' => 'নবদুর্গা', 'desc' => 'নয়টি রূপের পরিচিতি ও প্রথাগত বিবরণ', 'url' => '/navadurga'],
            ['label' => 'নবরাত্রি', 'desc' => 'নয় দিনের অনুষ্ঠান ও তাৎপর্য', 'url' => '/navaratri'],
            ['label' => 'পূজা ঐতিহ্য', 'desc' => 'পূজার রীতিনীতি ও প্রস্তুতি', 'url' => '/puja-planning'],
            ['label' => 'মন্ত্র ও স্তোত্র', 'desc' => 'উচ্চারণ, অর্থ ও উৎসসহ', 'url' => '/mantras'],
            ['label' => 'সেবা দর্শন', 'desc' => 'পূজা ও সেবার সংযোগ', 'url' => '/about#seva-philosophy'],
            ['label' => 'পঞ্জিকা', 'desc' => 'তারিখ ও তিথি', 'url' => '/calendar'],
        ];

        $articles = [];
        foreach (['আধ্যাত্মিকতা', 'সংস্কৃতি'] as $catName) {
            $cat = null;
            foreach ($categoryRepo->byType('article') as $c) {
                if ($c['name_bn'] === $catName) { $cat = $c; break; }
            }
            if ($cat) {
                $articles = array_merge($articles, $articleRepo->published(1, 3, (int) $cat['id'])['data']);
            }
        }

        $this->view('pages/learning', [
            'title' => 'আধ্যাত্মিক জ্ঞান',
            'metaDescription' => 'নবদুর্গা, নবরাত্রি, শক্তি সাধনা ও পূজা ঐতিহ্য সম্পর্কে জ্ঞানভিত্তিক তথ্য — শাস্ত্রীয়, প্রথাগত ও আধুনিক ব্যাখ্যা পৃথকভাবে উপস্থাপিত।',
            'breadcrumbs' => [['label' => 'জ্ঞান']],
            'topics' => $topics,
            'articles' => $articles,
        ]);
    }
}
