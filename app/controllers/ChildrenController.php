<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\ChildrenActivityRepository;

class ChildrenController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('pages/children', [
            'title' => 'শিশু কার্যক্রম',
            'metaDescription' => 'নবরাত্রিতে শিশুদের জন্য নিরাপদ, বয়স-উপযোগী কার্যক্রম।',
            'breadcrumbs' => [['label' => 'শিশু']],
            'activities' => (new ChildrenActivityRepository())->allActive(),
        ]);
    }
}
