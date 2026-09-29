<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Env;
use App\Core\Request;
use App\Core\Session;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): void
    {
        if (in_array($locale, ['bn', 'en'], true)) {
            Session::put('locale', $locale);
        }

        $back = $request->query('back');
        $base = Env::get('APP_BASE_PATH', '');

        // Only allow redirecting back within this site (prevent open redirect).
        if ($back && str_starts_with($back, '/') && !str_starts_with($back, '//')) {
            header('Location: ' . $base . $back);
            exit;
        }

        header('Location: ' . $base . '/');
        exit;
    }
}
