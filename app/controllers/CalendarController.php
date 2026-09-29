<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\CalendarRepository;

class CalendarController extends Controller
{
    public function index(Request $request): void
    {
        $repo = new CalendarRepository();
        $years = $repo->availableYears();
        $defaultYear = (int) config('app.current_navaratri_year');
        $year = (int) $request->query('year', $defaultYear);

        if (!in_array($year, $years, true) && !empty($years)) {
            $year = $years[0];
        }

        $this->view('pages/calendar', [
            'title' => 'নবরাত্রি পঞ্জিকা',
            'metaDescription' => 'নবরাত্রির তারিখ, তিথি ও অনুষ্ঠানসূচি।',
            'breadcrumbs' => [['label' => 'পঞ্জিকা']],
            'years' => $years,
            'year' => $year,
            'entries' => $repo->forYear($year),
        ]);
    }
}
