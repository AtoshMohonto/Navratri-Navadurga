<?php

namespace App\Controllers\Admin;

use App\Repositories\PujaItemRepository;

class PujaItemController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new PujaItemRepository();
        $this->title = 'পূজা সামগ্রী';
        $this->routeBase = 'admin/puja-items';
        $this->orderBy = 'category ASC, name_bn ASC';
        $this->searchColumns = ['name_bn', 'name_en', 'category'];
        $this->listColumns = ['name_bn', 'category', 'used_day', 'status'];
        $this->imageField = 'image';
        $this->uploadSubdir = 'puja-items';

        $categoryOptions = array_combine((new PujaItemRepository())->categories(), (new PujaItemRepository())->categories());

        $this->fields = [
            ['key' => 'name_bn', 'label' => 'নাম (বাংলা)', 'type' => 'text', 'required' => true],
            ['key' => 'name_en', 'label' => 'নাম (ইংরেজি)', 'type' => 'text'],
            ['key' => 'category', 'label' => 'ক্যাটাগরি', 'type' => 'select', 'options' => $categoryOptions, 'required' => true],
            ['key' => 'quantity', 'label' => 'পরিমাণ', 'type' => 'text'],
            ['key' => 'unit', 'label' => 'একক', 'type' => 'text'],
            ['key' => 'used_day', 'label' => 'কোন দিন ব্যবহৃত হয়', 'type' => 'text'],
            ['key' => 'importance', 'label' => 'গুরুত্ব', 'type' => 'text', 'hint' => 'যেমন: আবশ্যক / ঐচ্ছিক'],
            ['key' => 'alternative', 'label' => 'বিকল্প', 'type' => 'text'],
            ['key' => 'notes', 'label' => 'মন্তব্য', 'type' => 'textarea'],
            ['key' => 'image', 'label' => 'ছবি', 'type' => 'image'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], 'required' => true],
        ];
    }
}
