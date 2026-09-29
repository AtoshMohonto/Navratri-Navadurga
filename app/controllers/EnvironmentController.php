<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\EnvironmentActivityRepository;

class EnvironmentController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('pages/environment', [
            'title' => 'পরিবেশ কার্যক্রম',
            'metaDescription' => 'নবরাত্রিতে পরিবেশের যত্নে করার মতো কার্যক্রম — বৃক্ষরোপণ, পরিচ্ছন্নতা ও প্লাস্টিক হ্রাস।',
            'breadcrumbs' => [['label' => 'পরিবেশ']],
            'activities' => (new EnvironmentActivityRepository())->allActive(),
        ]);
    }
}
