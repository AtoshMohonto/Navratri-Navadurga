<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\SettingsRepository;

class SettingsController extends Controller
{
    protected string $layout = 'layouts/admin';

    protected array $keys = [
        'site_name' => 'সাইটের নাম',
        'site_subtitle' => 'সাবটাইটেল',
        'site_description' => 'সাইট বিবরণ',
        'contact_email' => 'যোগাযোগের ইমেইল',
        'current_navaratri_year' => 'চলতি নবরাত্রি বছর',
        'default_language' => 'ডিফল্ট ভাষা',
        'footer_text' => 'ফুটার লেখা',
        'facebook_url' => 'ফেসবুক লিংক',
        'youtube_url' => 'ইউটিউব লিংক',
        'instagram_url' => 'ইনস্টাগ্রাম লিংক',
    ];

    public function index(Request $request): void
    {
        $repo = new SettingsRepository();
        $values = $repo->all();

        $this->view('admin/settings', [
            'title' => 'সেটিংস',
            'keys' => $this->keys,
            'values' => $values,
        ]);
    }

    public function update(Request $request): void
    {
        $repo = new SettingsRepository();
        foreach ($this->keys as $key => $label) {
            $repo->set($key, (string) $request->input($key, ''));
        }
        Session::flash('success', 'সেটিংস সংরক্ষণ করা হয়েছে।');
        $this->redirect('/admin/settings');
    }
}
