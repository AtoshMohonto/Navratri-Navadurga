<?php

namespace App\Controllers\Admin;

use App\Repositories\SevaRepository;

class SevaController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new SevaRepository();
        $this->title = 'সেবা';
        $this->routeBase = 'admin/seva';
        $this->orderBy = 'id DESC';
        $this->searchColumns = ['title_bn', 'title_en', 'slug', 'category'];
        $this->listColumns = ['title_bn', 'category', 'difficulty', 'status'];

        $categoryOptions = array_combine((new SevaRepository())->categories(), (new SevaRepository())->categories());

        $this->fields = [
            ['key' => 'title_bn', 'label' => 'শিরোনাম (বাংলা)', 'type' => 'text', 'required' => true],
            ['key' => 'title_en', 'label' => 'শিরোনাম (ইংরেজি)', 'type' => 'text'],
            ['key' => 'slug', 'label' => 'স্লাগ (URL)', 'type' => 'text', 'required' => true],
            ['key' => 'category', 'label' => 'ক্যাটাগরি', 'type' => 'select', 'options' => $categoryOptions, 'required' => true],
            ['key' => 'description', 'label' => 'বিবরণ', 'type' => 'textarea'],
            ['key' => 'beneficiary', 'label' => 'উপকারভোগী', 'type' => 'text'],
            ['key' => 'difficulty', 'label' => 'কঠিনতার মাত্রা', 'type' => 'select', 'options' => ['সহজ' => 'সহজ', 'মাঝারি' => 'মাঝারি', 'কঠিন' => 'কঠিন'], 'required' => true],
            ['key' => 'estimated_cost', 'label' => 'আনুমানিক খরচ (প্রদর্শনের জন্য)', 'type' => 'text', 'hint' => 'যেমন: ৳100-500'],
            ['key' => 'estimated_cost_min', 'label' => 'সর্বনিম্ন খরচ (৳)', 'type' => 'number'],
            ['key' => 'estimated_cost_max', 'label' => 'সর্বোচ্চ খরচ (৳)', 'type' => 'number'],
            ['key' => 'time_required', 'label' => 'সময় (প্রদর্শনের জন্য)', 'type' => 'text', 'hint' => 'যেমন: ৩০ মিনিট'],
            ['key' => 'time_required_minutes', 'label' => 'সময় (মিনিটে, ফিল্টারের জন্য)', 'type' => 'number'],
            ['key' => 'materials', 'label' => 'প্রয়োজনীয় সামগ্রী', 'type' => 'textarea'],
            ['key' => 'how_to', 'label' => 'কীভাবে করবেন', 'type' => 'textarea'],
            ['key' => 'safety_note', 'label' => 'নিরাপত্তা সংক্রান্ত দ্রষ্টব্য', 'type' => 'textarea'],
            ['key' => 'navadurga_day', 'label' => 'নবরাত্রি দিন (১-৯)', 'type' => 'number'],
            ['key' => 'impact_level', 'label' => 'প্রভাবের মাত্রা', 'type' => 'text'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], 'required' => true],
        ];
    }

    protected function rules(bool $isUpdate, $id = null): array
    {
        $rules = parent::rules($isUpdate, $id);
        $rules['slug'] = 'required|unique:sevas,slug' . ($id ? ",{$id}" : '');
        return $rules;
    }
}
