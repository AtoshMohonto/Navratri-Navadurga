<?php

namespace App\Controllers\Admin;

use App\Repositories\CalendarRepository;
use App\Repositories\NavadurgaRepository;

class CalendarController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new CalendarRepository();
        $this->title = 'উৎসব পঞ্জিকা';
        $this->routeBase = 'admin/calendar';
        $this->orderBy = 'year DESC, gregorian_date ASC';
        $this->searchColumns = ['event_label', 'tithi'];
        $this->listColumns = ['year', 'gregorian_date', 'event_label', 'day_number'];

        $navadurgaOptions = ['' => '— প্রযোজ্য নয় —'];
        foreach ((new NavadurgaRepository())->allOrdered(false) as $n) {
            $navadurgaOptions[$n['id']] = $n['day_number'] . '. ' . $n['name_bn'];
        }

        $this->fields = [
            ['key' => 'year', 'label' => 'বছর', 'type' => 'number', 'required' => true],
            ['key' => 'day_number', 'label' => 'দিন সংখ্যা (দশমীর জন্য ফাঁকা রাখুন)', 'type' => 'number'],
            ['key' => 'gregorian_date', 'label' => 'তারিখ', 'type' => 'date', 'required' => true],
            ['key' => 'tithi', 'label' => 'তিথি', 'type' => 'text'],
            ['key' => 'navadurga_id', 'label' => 'দেবীর রূপ', 'type' => 'select', 'options' => $navadurgaOptions],
            ['key' => 'event_label', 'label' => 'ইভেন্টের নাম', 'type' => 'text'],
            ['key' => 'is_dashami', 'label' => 'এটি কি বিজয়া দশমী?', 'type' => 'checkbox'],
            ['key' => 'notes', 'label' => 'মন্তব্য', 'type' => 'textarea'],
        ];
    }

    protected function rules(bool $isUpdate, $id = null): array
    {
        return [
            'year' => 'required|numeric',
            'gregorian_date' => 'required',
        ];
    }
}
