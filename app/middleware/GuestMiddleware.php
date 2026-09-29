<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Env;
use App\Core\Middleware;
use App\Core\Request;

class GuestMiddleware implements Middleware
{
    public function handle(Request $request): bool
    {
        if (Auth::check()) {
            header('Location: ' . Env::get('APP_BASE_PATH', '') . '/dashboard');
            return false;
        }

        return true;
    }
}
