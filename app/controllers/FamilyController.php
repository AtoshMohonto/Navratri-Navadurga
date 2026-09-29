<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\FamilyActivityRepository;
use App\Repositories\FamilyChallengeRepository;

class FamilyController extends Controller
{
    protected array $challengeDays = [
        1 => 'একটি শিশুকে প্রয়োজনীয় কিছু দিন',
        2 => 'পরিবারে একসাথে পড়াশোনা করুন',
        3 => 'একজন নবদম্পতিকে শুভেচ্ছা পাঠান',
        4 => 'একজন মাকে সহায়তা করুন',
        5 => 'মা/শিশুর সাথে বিশেষ সময় কাটান',
        6 => 'একজন কিশোরীর শিক্ষায় সহায়তা করুন',
        7 => 'অসুস্থ বা সংকটে থাকা কাউকে সাহায্য করুন',
        8 => 'কাপড় বা প্রয়োজনীয় সামগ্রী দান করুন',
        9 => 'কারো সাথে জ্ঞান ভাগ করে নিন',
    ];

    public function index(Request $request): void
    {
        $progress = Auth::check() ? (new FamilyChallengeRepository())->forUser(Auth::id()) : [];

        $this->view('pages/family', [
            'title' => 'পরিবার কার্যক্রম',
            'metaDescription' => 'নবরাত্রিতে পরিবারের সবাই মিলে করার মতো কার্যক্রম ও ৯ দিনের পরিবার চ্যালেঞ্জ।',
            'breadcrumbs' => [['label' => 'পরিবার']],
            'activities' => (new FamilyActivityRepository())->allActive(),
            'challengeDays' => $this->challengeDays,
            'progress' => $progress,
        ]);
    }

    public function toggleChallenge(Request $request): void
    {
        if (!Auth::check()) {
            Session::flash('error', 'চ্যালেঞ্জের অগ্রগতি সংরক্ষণ করতে লগইন করুন।');
            $this->redirect('/login');
            return;
        }

        $day = (int) $request->input('day');
        $status = $request->input('status') === 'completed' ? 'completed' : 'skipped';

        if ($day < 1 || $day > 9) {
            $this->abort(404);
            return;
        }

        (new FamilyChallengeRepository())->setStatus(Auth::id(), $day, $status);
        $this->redirect('/family');
    }
}
