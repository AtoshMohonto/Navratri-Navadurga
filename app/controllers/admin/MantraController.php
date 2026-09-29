<?php

namespace App\Controllers\Admin;

use App\Repositories\MantraRepository;

class MantraController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new MantraRepository();
        $this->title = 'মন্ত্র';
        $this->routeBase = 'admin/mantras';
        $this->orderBy = 'associated_day ASC, id DESC';
        $this->searchColumns = ['title_bn', 'associated_deity'];
        $this->listColumns = ['title_bn', 'associated_deity', 'associated_day', 'status'];

        $this->fields = [
            ['key' => 'title_bn', 'label' => 'শিরোনাম', 'type' => 'text', 'required' => true],
            ['key' => 'slug', 'label' => 'স্লাগ (URL)', 'type' => 'text', 'required' => true],
            ['key' => 'sanskrit', 'label' => 'সংস্কৃত পাঠ', 'type' => 'textarea'],
            ['key' => 'transliteration', 'label' => 'প্রতিবর্ণীকরণ', 'type' => 'textarea'],
            ['key' => 'pronunciation_bn', 'label' => 'বাংলা উচ্চারণ', 'type' => 'textarea'],
            ['key' => 'meaning_bn', 'label' => 'অর্থ (বাংলা)', 'type' => 'textarea'],
            ['key' => 'meaning_en', 'label' => 'অর্থ (ইংরেজি)', 'type' => 'textarea'],
            ['key' => 'associated_deity', 'label' => 'সম্পর্কিত দেবী', 'type' => 'text'],
            ['key' => 'associated_day', 'label' => 'সম্পর্কিত দিন (১-৯)', 'type' => 'number'],
            ['key' => 'source', 'label' => 'উৎস', 'type' => 'text', 'hint' => 'কখনও উৎস বানিয়ে লিখবেন না'],
            ['key' => 'audio_url', 'label' => 'অডিও লিংক', 'type' => 'text'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], 'required' => true],
        ];
    }

    protected function rules(bool $isUpdate, $id = null): array
    {
        $rules = parent::rules($isUpdate, $id);
        $rules['slug'] = 'required|unique:mantras,slug' . ($id ? ",{$id}" : '');
        return $rules;
    }
}
