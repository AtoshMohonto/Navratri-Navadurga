<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\FaqRepository;

class FaqController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('pages/faq', [
            'title' => 'প্রশ্নোত্তর',
            'metaDescription' => 'নবদুর্গা, নবরাত্রি, পূজা ও সেবা সম্পর্কিত সাধারণ প্রশ্নোত্তর।',
            'breadcrumbs' => [['label' => 'প্রশ্নোত্তর']],
            'grouped' => (new FaqRepository())->groupedByCategory(),
        ]);
    }
}
