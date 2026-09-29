<?php

namespace App\Controllers\Admin;

use App\Repositories\ChildrenActivityRepository;

class ChildrenController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new ChildrenActivityRepository();
        $this->title = 'শিশু কার্যক্রম';
        $this->routeBase = 'admin/children';
        $this->orderBy = 'day_number ASC, id DESC';
        $this->searchColumns = ['title', 'age_group'];
        $this->listColumns = ['title', 'age_group', 'day_number', 'status'];
        $this->imageField = 'image';
        $this->uploadSubdir = 'children';

        $this->fields = [
            ['key' => 'title', 'label' => 'শিরোনাম', 'type' => 'text', 'required' => true],
            ['key' => 'description', 'label' => 'বিবরণ', 'type' => 'textarea'],
            ['key' => 'age_group', 'label' => 'বয়সসীমা', 'type' => 'text'],
            ['key' => 'duration', 'label' => 'সময়কাল', 'type' => 'text'],
            ['key' => 'materials', 'label' => 'প্রয়োজনীয় সামগ্রী', 'type' => 'textarea'],
            ['key' => 'instructions', 'label' => 'নির্দেশনা', 'type' => 'textarea'],
            ['key' => 'learning_outcome', 'label' => 'শেখার ফলাফল', 'type' => 'textarea'],
            ['key' => 'day_number', 'label' => 'নবরাত্রি দিন (ঐচ্ছিক)', 'type' => 'number'],
            ['key' => 'image', 'label' => 'ছবি', 'type' => 'image'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], 'required' => true],
        ];
    }
}
