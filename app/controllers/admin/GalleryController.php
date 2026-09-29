<?php

namespace App\Controllers\Admin;

use App\Repositories\GalleryRepository;

class GalleryController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new GalleryRepository();
        $this->title = 'গ্যালারি';
        $this->routeBase = 'admin/gallery';
        $this->orderBy = 'created_at DESC';
        $this->searchColumns = ['title', 'category'];
        $this->listColumns = ['image', 'title', 'category', 'status'];
        $this->imageField = 'image';
        $this->uploadSubdir = 'gallery';

        $this->fields = [
            ['key' => 'title', 'label' => 'শিরোনাম', 'type' => 'text', 'required' => true],
            ['key' => 'image', 'label' => 'ছবি', 'type' => 'image'],
            ['key' => 'caption', 'label' => 'ক্যাপশন', 'type' => 'textarea'],
            ['key' => 'category', 'label' => 'ক্যাটাগরি', 'type' => 'text'],
            ['key' => 'credit_source', 'label' => 'ক্রেডিট/উৎস', 'type' => 'text'],
            ['key' => 'alt_text', 'label' => 'বিকল্প লেখা (Alt text)', 'type' => 'text'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], 'required' => true],
        ];
    }
}
