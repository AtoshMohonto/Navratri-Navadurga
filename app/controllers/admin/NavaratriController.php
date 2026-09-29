<?php

namespace App\Controllers\Admin;

use App\Repositories\NavadurgaRepository;
use App\Repositories\NavaratriDayRepository;

class NavaratriController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new NavaratriDayRepository();
        $this->title = '৯ দিনের অনুষ্ঠানসূচি';
        $this->routeBase = 'admin/navaratri';
        $this->orderBy = 'day_number ASC';
        $this->searchColumns = ['title_bn', 'theme'];
        $this->listColumns = ['day_number', 'title_bn', 'theme', 'status'];
        $this->imageField = 'image';
        $this->uploadSubdir = 'navaratri';

        $navadurgaOptions = [];
        foreach ((new NavadurgaRepository())->allOrdered(false) as $n) {
            $navadurgaOptions[$n['id']] = $n['day_number'] . '. ' . $n['name_bn'];
        }

        $this->fields = [
            ['key' => 'day_number', 'label' => 'দিন সংখ্যা (১-৯)', 'type' => 'number', 'required' => true],
            ['key' => 'navadurga_id', 'label' => 'দেবীর রূপ', 'type' => 'select', 'options' => $navadurgaOptions, 'required' => true],
            ['key' => 'date', 'label' => 'তারিখ (চলতি বছরের রেফারেন্স)', 'type' => 'date'],
            ['key' => 'tithi', 'label' => 'তিথি', 'type' => 'text'],
            ['key' => 'title_bn', 'label' => 'শিরোনাম', 'type' => 'text'],
            ['key' => 'theme', 'label' => 'থিম', 'type' => 'text'],
            ['key' => 'traditional_focus', 'label' => 'প্রথাগত ফোকাস', 'type' => 'textarea'],
            ['key' => 'puja_focus', 'label' => 'পূজা ফোকাস', 'type' => 'textarea'],
            ['key' => 'spiritual_focus', 'label' => 'আধ্যাত্মিক ফোকাস', 'type' => 'textarea'],
            ['key' => 'learning_focus', 'label' => 'শেখার বিষয়', 'type' => 'textarea'],
            ['key' => 'family_activity', 'label' => 'পরিবার কার্যক্রম', 'type' => 'textarea'],
            ['key' => 'children_activity', 'label' => 'শিশু কার্যক্রম', 'type' => 'textarea'],
            ['key' => 'environment_activity', 'label' => 'পরিবেশ কার্যক্রম', 'type' => 'textarea'],
            ['key' => 'seva_easy', 'label' => 'সহজ সেবা', 'type' => 'textarea'],
            ['key' => 'seva_moderate', 'label' => 'মাঝারি সেবা', 'type' => 'textarea'],
            ['key' => 'seva_challenging', 'label' => 'কঠিন সেবা', 'type' => 'textarea'],
            ['key' => 'recommended_items', 'label' => 'প্রস্তাবিত সামগ্রী', 'type' => 'textarea'],
            ['key' => 'daily_mantra', 'label' => 'দৈনিক মন্ত্র', 'type' => 'textarea'],
            ['key' => 'daily_message', 'label' => 'দৈনিক বার্তা', 'type' => 'textarea'],
            ['key' => 'avoid_note', 'label' => 'যা এড়িয়ে চলা উচিত', 'type' => 'textarea'],
            ['key' => 'image', 'label' => 'ছবি', 'type' => 'image'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], 'required' => true],
        ];
    }

    protected function rules(bool $isUpdate, $id = null): array
    {
        $rules = parent::rules($isUpdate, $id);
        $rules['day_number'] = 'required|numeric';
        $rules['navadurga_id'] = 'required';
        return $rules;
    }
}
