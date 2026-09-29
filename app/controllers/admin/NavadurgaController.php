<?php

namespace App\Controllers\Admin;

use App\Repositories\NavadurgaRepository;

class NavadurgaController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new NavadurgaRepository();
        $this->title = 'নবদুর্গা';
        $this->routeBase = 'admin/navadurga';
        $this->orderBy = 'day_number ASC';
        $this->searchColumns = ['name_bn', 'name_en', 'slug'];
        $this->listColumns = ['day_number', 'name_bn', 'slug', 'status'];
        $this->imageField = 'image';
        $this->uploadSubdir = 'navadurga';

        $statusOptions = ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'];

        $this->fields = [
            ['key' => 'day_number', 'label' => 'দিন সংখ্যা (১-৯)', 'type' => 'number', 'required' => true],
            ['key' => 'name_bn', 'label' => 'নাম (বাংলা)', 'type' => 'text', 'required' => true],
            ['key' => 'name_en', 'label' => 'নাম (ইংরেজি)', 'type' => 'text'],
            ['key' => 'sanskrit_name', 'label' => 'সংস্কৃত নাম', 'type' => 'text'],
            ['key' => 'slug', 'label' => 'স্লাগ (URL)', 'type' => 'text', 'required' => true, 'hint' => 'শুধু ইংরেজি ছোট হাতের অক্ষর ও হাইফেন, যেমন: shailaputri'],
            ['key' => 'alternative_names', 'label' => 'বিকল্প নাম', 'type' => 'text'],
            ['key' => 'short_description', 'label' => 'সংক্ষিপ্ত বিবরণ', 'type' => 'textarea'],
            ['key' => 'detailed_description', 'label' => 'বিস্তারিত বিবরণ', 'type' => 'textarea'],
            ['key' => 'name_meaning', 'label' => 'নামের অর্থ', 'type' => 'textarea'],
            ['key' => 'traditional_symbolism', 'label' => 'প্রথাগত প্রতীকতত্ত্ব', 'type' => 'textarea'],
            ['key' => 'iconography', 'label' => 'মূর্তিতত্ত্ব', 'type' => 'textarea'],
            ['key' => 'vehicle', 'label' => 'বাহন', 'type' => 'text'],
            ['key' => 'hands', 'label' => 'হাতের সংখ্যা', 'type' => 'text'],
            ['key' => 'weapons', 'label' => 'অস্ত্র', 'type' => 'text'],
            ['key' => 'objects', 'label' => 'ধারণ করা বস্তু', 'type' => 'text'],
            ['key' => 'colour', 'label' => 'রং', 'type' => 'text'],
            ['key' => 'associated_quality', 'label' => 'সম্পর্কিত গুণ', 'type' => 'text'],
            ['key' => 'associated_chakra', 'label' => 'সম্পর্কিত চক্র', 'type' => 'text'],
            ['key' => 'traditional_association', 'label' => 'প্রথাগত সংযোগ', 'type' => 'textarea'],
            ['key' => 'traditional_food', 'label' => 'প্রথাগত ভোগ/খাবার', 'type' => 'text'],
            ['key' => 'puja_significance', 'label' => 'পূজার তাৎপর্য', 'type' => 'textarea'],
            ['key' => 'story', 'label' => 'কাহিনী', 'type' => 'textarea'],
            ['key' => 'mantra', 'label' => 'মন্ত্র', 'type' => 'textarea'],
            ['key' => 'stotra', 'label' => 'স্তোত্র', 'type' => 'textarea'],
            ['key' => 'scriptural_sources', 'label' => 'শাস্ত্রীয় উৎস', 'type' => 'textarea', 'hint' => 'কখনও উৎস বানিয়ে লিখবেন না; যাচাইযোগ্য না হলে ফাঁকা রাখুন'],
            ['key' => 'regional_variations', 'label' => 'আঞ্চলিক ভিন্নতা', 'type' => 'textarea'],
            ['key' => 'modern_interpretation', 'label' => 'আধুনিক ব্যাখ্যা', 'type' => 'textarea'],
            ['key' => 'seva_note', 'label' => 'সেবা সংক্রান্ত দ্রষ্টব্য', 'type' => 'textarea'],
            ['key' => 'image', 'label' => 'ছবি', 'type' => 'image'],
            ['key' => 'seo_title', 'label' => 'SEO শিরোনাম', 'type' => 'text'],
            ['key' => 'seo_description', 'label' => 'SEO বিবরণ', 'type' => 'textarea'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => $statusOptions, 'required' => true],
        ];
    }

    protected function rules(bool $isUpdate, $id = null): array
    {
        $rules = parent::rules($isUpdate, $id);
        $rules['slug'] = 'required|unique:navadurga,slug' . ($id ? ",{$id}" : '');
        $rules['day_number'] = 'required|numeric';
        return $rules;
    }
}
