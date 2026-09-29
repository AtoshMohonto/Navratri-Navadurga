<?php

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;

class ArticleController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new ArticleRepository();
        $this->title = 'নিবন্ধ';
        $this->routeBase = 'admin/articles';
        $this->orderBy = 'created_at DESC';
        $this->searchColumns = ['title_bn', 'title_en', 'slug'];
        $this->listColumns = ['title_bn', 'status', 'published_at'];
        $this->imageField = 'featured_image';
        $this->uploadSubdir = 'articles';

        $categoryOptions = [];
        foreach ((new CategoryRepository())->byType('article') as $c) {
            $categoryOptions[$c['id']] = $c['name_bn'];
        }

        $this->fields = [
            ['key' => 'title_bn', 'label' => 'শিরোনাম (বাংলা)', 'type' => 'text', 'required' => true],
            ['key' => 'title_en', 'label' => 'শিরোনাম (ইংরেজি)', 'type' => 'text'],
            ['key' => 'slug', 'label' => 'স্লাগ (URL)', 'type' => 'text', 'required' => true],
            ['key' => 'excerpt', 'label' => 'সারসংক্ষেপ', 'type' => 'textarea'],
            ['key' => 'content', 'label' => 'বিস্তারিত লেখা', 'type' => 'textarea', 'required' => true],
            ['key' => 'category_id', 'label' => 'ক্যাটাগরি', 'type' => 'select', 'options' => $categoryOptions],
            ['key' => 'author', 'label' => 'লেখক', 'type' => 'text'],
            ['key' => 'featured_image', 'label' => 'প্রধান ছবি', 'type' => 'image'],
            ['key' => 'source', 'label' => 'উৎস', 'type' => 'text'],
            ['key' => 'reading_time', 'label' => 'পড়ার সময়', 'type' => 'text', 'hint' => 'যেমন: ৫ মিনিট'],
            ['key' => 'seo_title', 'label' => 'SEO শিরোনাম', 'type' => 'text'],
            ['key' => 'seo_description', 'label' => 'SEO বিবরণ', 'type' => 'textarea'],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['draft' => 'খসড়া', 'published' => 'প্রকাশিত'], 'required' => true],
            ['key' => 'published_at', 'label' => 'প্রকাশের তারিখ', 'type' => 'date'],
        ];
    }

    protected function rules(bool $isUpdate, $id = null): array
    {
        $rules = parent::rules($isUpdate, $id);
        $rules['slug'] = 'required|unique:articles,slug' . ($id ? ",{$id}" : '');
        return $rules;
    }

    protected function collectData(Request $request): array
    {
        $data = parent::collectData($request);
        if (($data['status'] ?? '') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }
        if (empty($data['category_id'])) {
            $data['category_id'] = null;
        }
        return $data;
    }
}
