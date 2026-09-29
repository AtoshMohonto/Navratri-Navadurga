<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\CalendarRepository;
use App\Repositories\ChecklistRepository;
use App\Repositories\ChildrenActivityRepository;
use App\Repositories\EnvironmentActivityRepository;
use App\Repositories\FamilyActivityRepository;
use App\Repositories\MantraRepository;
use App\Repositories\NavadurgaRepository;
use App\Repositories\NavaratriDayRepository;
use App\Repositories\PujaItemRepository;
use App\Repositories\SevaRepository;

class HomeController extends Controller
{
    public function index(Request $request): void
    {
        $year = (int) config('app.current_navaratri_year');
        $calendarRepo = new CalendarRepository();
        $today = current_navaratri_day();

        $navadurgaRepo = new NavadurgaRepository();
        $navaratriRepo = new NavaratriDayRepository();
        $sevaRepo = new SevaRepository();
        $mantraRepo = new MantraRepository();
        $articleRepo = new ArticleRepository();

        $todaysNavadurga = $today ? $navadurgaRepo->findByDay($today) : $navadurgaRepo->findByDay(1);
        $todaysDay = $today ? $navaratriRepo->findByDayWithNavadurga($today) : $navaratriRepo->findByDayWithNavadurga(1);
        $todaysLearning = $todaysDay['learning_focus'] ?? null;
        $upcoming = $calendarRepo->nextUpcoming($year);

        $this->view('pages/home', [
            'title' => null,
            'metaDescription' => config('app.tagline'),
            'navadurgaList' => $navadurgaRepo->allOrdered(),
            'todaysNavadurga' => $todaysNavadurga,
            'todaysDay' => $todaysDay,
            'todaysLearning' => $todaysLearning,
            'currentDayNumber' => $today,
            'upcoming' => $upcoming,
            'checklistPreview' => (new ChecklistRepository())->byPhase('day'),
            'todaysSevas' => $today ? $sevaRepo->byDay($today, 3) : $sevaRepo->all(['status' => 'active'], 'id ASC', 3),
            'childrenActivity' => (new ChildrenActivityRepository())->allActive()[0] ?? null,
            'familyActivity' => (new FamilyActivityRepository())->allActive()[0] ?? null,
            'environmentActivity' => (new EnvironmentActivityRepository())->allActive()[0] ?? null,
            'pujaItems' => (new PujaItemRepository())->all(['status' => 'active'], 'category ASC', 6),
            'todaysMantra' => $today ? ($mantraRepo->byDay($today)[0] ?? null) : null,
            'featuredArticle' => $articleRepo->featured(1)[0] ?? null,
        ]);
    }
}
