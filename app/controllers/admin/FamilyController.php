<?php

namespace App\Controllers\Admin;

use App\Repositories\FamilyActivityRepository;

class FamilyController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new FamilyActivityRepository();
        $this->title = 'পরিবার কার্যক্রম';
        $this->routeBase = 'admin/family';
        $this->orderBy = 'day_number ASC, id DESC';
        $this->searchColumns = ['title_bn', 'category'];
        $this->listColumns = ['title_bn', 'category', 'day_number', 'status'];
        $this->imageField = 'image';
        $this->uploadSubdir = 'family';

        $this->fields = [
            ['key' => 'title_bn', 'label' => 'শিরোনাম', 'type' => 'text', 'required' => true],
            ['key' => 'description', 'label' => 'বিবরণ', 'type' => 'textarea'],
            ['key' => 'category', 'label' => 'ক্যাটাগরি', 'type' => 'text'],
            ['key' => 'duration', 'label' => 'সময়কাল', 'type' => 'text'],
            ['key' => 'materials', 'label' => 'প্রয়োজনীয় সামগ্রী', 'type' => 'textarea'],
            ['key' => 'instructions', 'label' => 'নির্দেশনা', 'type' => 'textarea'],
            ['key' => 'day_number', 'label' => 'নবরাত্রি দিন (ঐচ্ছিক)', 'type' => 'number'],
            ['key' => 'image', 'label' => 'ছবি', 'type' => 'image'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], 'required' => true],
        ];
    }
}
