<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\ContactRepository;
use App\Validators\Validator;

class PageController extends Controller
{
    public function about(Request $request): void
    {
        $this->view('pages/about', [
            'title' => 'আমাদের সম্পর্কে',
            'metaDescription' => 'নবদুর্গা ওয়েবসাইটের লক্ষ্য, দর্শন ও পূজা-সেবার সংযোগ সম্পর্কে জানুন।',
            'breadcrumbs' => [['label' => 'আমাদের সম্পর্কে']],
        ]);
    }

    public function contact(Request $request): void
    {
        $this->view('pages/contact', [
            'title' => 'যোগাযোগ',
            'metaDescription' => 'আমাদের সাথে যোগাযোগ করুন।',
            'breadcrumbs' => [['label' => 'যোগাযোগ']],
        ]);
    }

    public function submitContact(Request $request): void
    {
        $data = $request->only(['name', 'email', 'message']);

        $validator = Validator::make($data, [
            'name' => 'required|max:150',
            'email' => 'required|email',
            'message' => 'required|max:2000',
        ], ['name' => 'নাম', 'email' => 'ইমেইল', 'message' => 'বার্তা']);

        if ($validator->fails()) {
            Session::flash('error', $validator->firstError());
            Session::flash('old', $data);
            $this->redirect('/contact');
            return;
        }

        (new ContactRepository())->insert($data);

        Session::flash('success', 'আপনার বার্তা পাঠানো হয়েছে। ধন্যবাদ!');
        $this->redirect('/contact');
    }
}
