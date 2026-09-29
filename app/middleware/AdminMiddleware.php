<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Env;
use App\Core\Middleware;
use App\Core\Request;
use App\Core\Session;

class AdminMiddleware implements Middleware
{
    public function handle(Request $request): bool
    {
        if (!Auth::check()) {
            header('Location: ' . Env::get('APP_BASE_PATH', '') . '/login');
            return false;
        }

        if (!Auth::isAdmin()) {
            http_response_code(403);
            require dirname(__DIR__) . '/views/errors/403.php';
            return false;
        }

        return true;
    }
}
