<?php

namespace App\Controllers\Admin;

use App\Repositories\EnvironmentActivityRepository;

class EnvironmentController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new EnvironmentActivityRepository();
        $this->title = 'পরিবেশ কার্যক্রম';
        $this->routeBase = 'admin/environment';
        $this->orderBy = 'id DESC';
        $this->searchColumns = ['title_bn'];
        $this->listColumns = ['title_bn', 'difficulty', 'estimated_cost', 'status'];
        $this->imageField = 'image';
        $this->uploadSubdir = 'environment';

        $this->fields = [
            ['key' => 'title_bn', 'label' => 'শিরোনাম', 'type' => 'text', 'required' => true],
            ['key' => 'why_text', 'label' => 'কেন?', 'type' => 'textarea'],
            ['key' => 'how_text', 'label' => 'কীভাবে?', 'type' => 'textarea'],
            ['key' => 'materials_needed', 'label' => 'প্রয়োজনীয় সামগ্রী', 'type' => 'textarea'],
            ['key' => 'difficulty', 'label' => 'কঠিনতার মাত্রা', 'type' => 'select', 'options' => ['সহজ' => 'সহজ', 'মাঝারি' => 'মাঝারি', 'কঠিন' => 'কঠিন'], 'required' => true],
            ['key' => 'estimated_cost', 'label' => 'আনুমানিক খরচ', 'type' => 'text'],
            ['key' => 'time_required', 'label' => 'সময়', 'type' => 'text'],
            ['key' => 'image', 'label' => 'ছবি', 'type' => 'image'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], 'required' => true],
        ];
    }
}
