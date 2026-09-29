<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\ChecklistRepository;
use App\Repositories\ChildrenActivityRepository;
use App\Repositories\EnvironmentActivityRepository;
use App\Repositories\FamilyActivityRepository;
use App\Repositories\NavaratriDayRepository;
use App\Repositories\ReflectionRepository;
use App\Repositories\SevaRepository;

class DailyGuideController extends Controller
{
    public function index(Request $request): void
    {
        $dayNumber = current_navaratri_day() ?? 1;
        $day = (new NavaratriDayRepository())->findByDayWithNavadurga($dayNumber);
        $nextDay = $dayNumber < 9 ? (new NavaratriDayRepository())->findByDayWithNavadurga($dayNumber + 1) : null;

        $this->view('pages/daily-guide', [
            'title' => 'দৈনিক গাইড',
            'metaDescription' => 'আজকের দেবী, পূজা প্রস্তুতি, সেবা ও কার্যক্রমের সংক্ষিপ্ত দৈনিক গাইড।',
            'breadcrumbs' => [['label' => 'দৈনিক গাইড']],
            'day' => $day,
            'dayNumber' => $dayNumber,
            'nextDay' => $nextDay,
            'checklist' => (new ChecklistRepository())->byPhase('day'),
            'sevas' => $day ? (new SevaRepository())->byDay($dayNumber, 3) : [],
            'childrenActivities' => (new ChildrenActivityRepository())->byDay($dayNumber),
            'familyActivities' => (new FamilyActivityRepository())->byDay($dayNumber),
            'environmentActivities' => array_slice((new EnvironmentActivityRepository())->allActive(), 0, 2),
        ]);
    }

    public function saveReflection(Request $request): void
    {
        if (!Auth::check()) {
            Session::flash('error', 'প্রতিফলন সংরক্ষণ করতে লগইন করুন।');
            $this->redirect('/login');
            return;
        }

        $day = (int) $request->input('day_number');

        (new ReflectionRepository())->save(
            Auth::id(),
            $day,
            trim((string) $request->input('learned_text', '')),
            trim((string) $request->input('helped_text', '')),
            trim((string) $request->input('change_text', ''))
        );

        Session::flash('success', 'আপনার প্রতিফলন সংরক্ষণ করা হয়েছে।');
        $this->redirect($request->input('day_number') ? '/navaratri/day/' . $day : '/daily-guide');
    }
}
