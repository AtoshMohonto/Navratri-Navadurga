<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\GalleryRepository;

class GalleryController extends Controller
{
    public function index(Request $request): void
    {
        $category = $request->query('category') ?: null;

        $this->view('pages/gallery', [
            'title' => 'গ্যালারি',
            'metaDescription' => 'পূজা প্রস্তুতি, কমিউনিটি সেবা ও উৎসবের ছবি।',
            'breadcrumbs' => [['label' => 'গ্যালারি']],
            'images' => (new GalleryRepository())->allActive($category),
        ]);
    }
}
