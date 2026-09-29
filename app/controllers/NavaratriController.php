<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repositories\ChecklistRepository;
use App\Repositories\ChildrenActivityRepository;
use App\Repositories\MantraRepository;
use App\Repositories\NavaratriDayRepository;
use App\Repositories\PujaItemRepository;
use App\Repositories\SevaRepository;

class NavaratriController extends Controller
{
    public function index(Request $request): void
    {
        $repo = new NavaratriDayRepository();

        $this->view('pages/navaratri/index', [
            'title' => 'নবরাত্রি — ৯ দিনের পরিকল্পনা',
            'metaDescription' => 'নবরাত্রির ৯ দিনের সম্পূর্ণ পরিকল্পনা — পূজা, সেবা, শিক্ষা ও পরিবার কার্যক্রমসহ।',
            'breadcrumbs' => [['label' => 'নবরাত্রি']],
            'days' => $repo->allWithNavadurga(),
            'currentDayNumber' => current_navaratri_day(),
        ]);
    }

    public function day(Request $request, string $day): void
    {
        $dayNumber = (int) $day;

        if ($dayNumber < 1 || $dayNumber > 9) {
            $this->abort(404);
            return;
        }

        $repo = new NavaratriDayRepository();
        $item = $repo->findByDayWithNavadurga($dayNumber);

        if (!$item) {
            $this->abort(404);
            return;
        }

        $nextDay = $dayNumber < 9 ? $repo->findByDayWithNavadurga($dayNumber + 1) : null;

        $this->view('pages/navaratri/show', [
            'title' => 'দিন ' . $dayNumber . ' — ' . $item['navadurga_name_bn'],
            'metaDescription' => truncate($item['theme'], 160),
            'breadcrumbs' => [['label' => 'নবরাত্রি', 'url' => '/navaratri'], ['label' => 'দিন ' . $dayNumber]],
            'item' => $item,
            'dayNumber' => $dayNumber,
            'nextDay' => $nextDay,
            'prevDayNumber' => $dayNumber > 1 ? $dayNumber - 1 : null,
            'nextDayNumber' => $dayNumber < 9 ? $dayNumber + 1 : null,
            'checklist' => (new ChecklistRepository())->byPhase('day'),
            'sevas' => (new SevaRepository())->byDay($dayNumber, 6),
            'mantras' => (new MantraRepository())->byDay($dayNumber),
            'pujaItems' => (new PujaItemRepository())->filtered(null, (string) $dayNumber),
            'childrenActivities' => (new ChildrenActivityRepository())->byDay($dayNumber),
        ]);
    }
}
