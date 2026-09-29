<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Env;
use App\Core\Middleware;
use App\Core\Request;
use App\Core\Session;

class AuthMiddleware implements Middleware
{
    public function handle(Request $request): bool
    {
        if (!Auth::check()) {
            Session::flash('error', 'অনুগ্রহ করে প্রথমে লগইন করুন।');
            header('Location: ' . Env::get('APP_BASE_PATH', '') . '/login');
            return false;
        }

        return true;
    }
}
