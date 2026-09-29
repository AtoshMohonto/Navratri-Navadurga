<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\UserRepository;
use App\Validators\Validator;

class ProfileController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('pages/profile', [
            'title' => 'প্রোফাইল',
            'breadcrumbs' => [['label' => 'প্রোফাইল']],
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): void
    {
        $userId = Auth::id();
        $data = $request->only(['name', 'email']);

        $validator = Validator::make($data, [
            'name' => 'required|max:150',
            'email' => 'required|email|unique:users,email,' . $userId,
        ], ['name' => 'নাম', 'email' => 'ইমেইল']);

        if ($validator->fails()) {
            Session::flash('error', $validator->firstError());
            $this->redirect('/profile');
            return;
        }

        $repo = new UserRepository();
        $repo->update($userId, $data);

        $newPassword = $request->input('new_password');
        if (!empty($newPassword)) {
            if (mb_strlen($newPassword) < 8) {
                Session::flash('error', 'নতুন পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে।');
                $this->redirect('/profile');
                return;
            }
            $repo->update($userId, ['password_hash' => password_hash($newPassword, PASSWORD_DEFAULT)]);
        }

        Session::flash('success', 'প্রোফাইল হালনাগাদ করা হয়েছে।');
        $this->redirect('/profile');
    }
}
