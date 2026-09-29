<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\UserRepository;
use App\Validators\Validator;

class AuthController extends Controller
{
    public function showLogin(Request $request): void
    {
        $this->view('auth/login', [
            'title' => 'লগইন',
            'breadcrumbs' => [['label' => 'লগইন']],
        ]);
    }

    public function login(Request $request): void
    {
        $email = trim((string) $request->input('email'));
        $password = (string) $request->input('password');

        if ($email === '' || $password === '') {
            Session::flash('error', 'ইমেইল ও পাসওয়ার্ড দিন।');
            $this->redirect('/login');
            return;
        }

        if (Auth::attempt($email, $password)) {
            $redirectTo = Auth::isAdmin() ? '/admin' : '/dashboard';
            $this->redirect($redirectTo);
            return;
        }

        Session::flash('error', 'ইমেইল বা পাসওয়ার্ড সঠিক নয়।');
        $this->redirect('/login');
    }

    public function showRegister(Request $request): void
    {
        $this->view('auth/register', [
            'title' => 'নিবন্ধন',
            'breadcrumbs' => [['label' => 'নিবন্ধন']],
        ]);
    }

    public function register(Request $request): void
    {
        $data = $request->only(['name', 'email', 'password', 'password_confirmation']);

        $validator = Validator::make($data, [
            'name' => 'required|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ], ['name' => 'নাম', 'email' => 'ইমেইল', 'password' => 'পাসওয়ার্ড', 'password_confirmation' => 'পাসওয়ার্ড নিশ্চিতকরণ']);

        if ($validator->fails()) {
            Session::flash('error', $validator->firstError());
            $this->redirect('/register');
            return;
        }

        $repo = new UserRepository();
        $repo->create($data['name'], $data['email'], $data['password']);

        Auth::attempt($data['email'], $data['password']);
        Session::flash('success', 'স্বাগতম! আপনার অ্যাকাউন্ট তৈরি হয়েছে।');
        $this->redirect('/dashboard');
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        $this->redirect('/');
    }
}
