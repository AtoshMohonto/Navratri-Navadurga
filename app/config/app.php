<?php

use App\Core\Env;

return [
    'name' => Env::get('APP_NAME', 'নবদুর্গা'),
    'subtitle' => 'জ্ঞান • সাধনা • পূজা • সেবা',
    'tagline' => 'নবরাত্রির প্রতিটি দিন হোক জ্ঞান, সাধনা, আনন্দ ও সেবার একটি নতুন অধ্যায়।',
    'env' => Env::get('APP_ENV', 'production'),
    'debug' => (bool) Env::get('APP_DEBUG', false),
    'url' => Env::get('APP_URL', 'http://localhost'),
    'timezone' => Env::get('APP_TIMEZONE', 'Asia/Dhaka'),
    'locale' => Env::get('APP_LOCALE', 'bn'),
    'current_navaratri_year' => Env::get('CURRENT_NAVARATRI_YEAR', date('Y')),
];
