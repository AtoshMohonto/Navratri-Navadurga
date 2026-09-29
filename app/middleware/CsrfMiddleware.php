<?php

namespace App\Middleware;

use App\Core\Csrf;
use App\Core\Middleware;
use App\Core\Request;
use App\Core\Session;

class CsrfMiddleware implements Middleware
{
    public function handle(Request $request): bool
    {
        if (!$request->isPost()) {
            return true;
        }

        if (!Csrf::verify($request->input('_csrf'))) {
            Session::flash('error', 'সেশন মেয়াদোত্তীর্ণ হয়েছে, অনুগ্রহ করে আবার চেষ্টা করুন।');
            // Note: 419 (the conventional "expired session" code some frameworks use) is not
            // a registered HTTP status and this server rejects it with a blank 500. Use the
            // standard 400 Bad Request instead.
            http_response_code(400);
            require dirname(__DIR__) . '/views/errors/400.php';
            return false;
        }

        return true;
    }
}
