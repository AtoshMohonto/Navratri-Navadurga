<?php

namespace App\Controllers\Admin;

use App\Repositories\FaqRepository;

class FaqController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new FaqRepository();
        $this->title = 'প্রশ্নোত্তর';
        $this->routeBase = 'admin/faq';
        $this->orderBy = 'sort_order ASC, id ASC';
        $this->searchColumns = ['question_bn', 'category'];
        $this->listColumns = ['question_bn', 'category', 'sort_order', 'status'];

        $this->fields = [
            ['key' => 'question_bn', 'label' => 'প্রশ্ন', 'type' => 'textarea', 'required' => true],
            ['key' => 'answer_bn', 'label' => 'উত্তর', 'type' => 'textarea', 'required' => true],
            ['key' => 'category', 'label' => 'ক্যাটাগরি', 'type' => 'text'],
            ['key' => 'sort_order', 'label' => 'ক্রম', 'type' => 'number'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], 'required' => true],
        ];
    }
}
