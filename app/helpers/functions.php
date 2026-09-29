<?php

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Env;
use App\Core\Session;

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        return Env::get($key, $default);
    }
}

if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        static $cache = [];
        [$file, $item] = array_pad(explode('.', $key, 2), 2, null);

        if (!isset($cache[$file])) {
            $path = dirname(__DIR__) . "/config/{$file}.php";
            $cache[$file] = is_file($path) ? require $path : [];
        }

        if ($item === null) {
            return $cache[$file];
        }

        return $cache[$file][$item] ?? $default;
    }
}

if (!function_exists('base_path')) {
    function base_path(): string
    {
        return rtrim(Env::get('APP_BASE_PATH', ''), '/');
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        return base_path() . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return base_path() . '/assets/' . ltrim($path, '/') . '?v=' . (defined('ASSET_VERSION') ? ASSET_VERSION : '1');
    }
}

if (!function_exists('e')) {
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('old')) {
    function old(string $key, $default = '')
    {
        $old = Session::get('_old_input', []);
        return e($old[$key] ?? $default);
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return Csrf::field();
    }
}

if (!function_exists('auth_user')) {
    function auth_user(): ?array
    {
        return Auth::user();
    }
}

if (!function_exists('is_logged_in')) {
    function is_logged_in(): bool
    {
        return Auth::check();
    }
}

if (!function_exists('is_admin')) {
    function is_admin(): bool
    {
        return Auth::isAdmin();
    }
}

if (!function_exists('flash')) {
    function flash(string $key)
    {
        return Session::flash($key);
    }
}

if (!function_exists('redirect_to')) {
    function redirect_to(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }
}

if (!function_exists('bn_digits')) {
    function bn_digits($number): string
    {
        $western = ['0','1','2','3','4','5','6','7','8','9'];
        $bengali = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return str_replace($western, $bengali, (string) $number);
    }
}

if (!function_exists('bn_month')) {
    function bn_month(string $englishMonth): string
    {
        $map = [
            'January' => 'জানুয়ারি', 'February' => 'ফেব্রুয়ারি', 'March' => 'মার্চ',
            'April' => 'এপ্রিল', 'May' => 'মে', 'June' => 'জুন',
            'July' => 'জুলাই', 'August' => 'আগস্ট', 'September' => 'সেপ্টেম্বর',
            'October' => 'অক্টোবর', 'November' => 'নভেম্বর', 'December' => 'ডিসেম্বর',
        ];
        return $map[$englishMonth] ?? $englishMonth;
    }
}

if (!function_exists('bn_date')) {
    function bn_date(?string $date, string $format = 'j F, Y'): string
    {
        if (!$date) {
            return '';
        }
        $ts = strtotime($date);
        if (!$ts) {
            return '';
        }
        $formatted = date($format, $ts);
        // Replace the English month name portion and digits with Bengali equivalents.
        foreach (['January','February','March','April','May','June','July','August','September','October','November','December'] as $m) {
            if (str_contains($formatted, $m)) {
                $formatted = str_replace($m, bn_month($m), $formatted);
                break;
            }
        }
        return bn_digits($formatted);
    }
}

if (!function_exists('truncate')) {
    function truncate(?string $text, int $length = 150): string
    {
        $text = trim(strip_tags($text ?? ''));
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        return mb_substr($text, 0, $length) . '…';
    }
}

if (!function_exists('active_class')) {
    function active_class(string $path, string $class = 'active'): string
    {
        $current = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $base = base_path();
        if ($base !== '' && str_starts_with($current, $base)) {
            $current = substr($current, strlen($base));
        }
        $current = '/' . ltrim($current, '/');
        $target = '/' . ltrim($path, '/');

        if ($target === '/') {
            return $current === '/' ? $class : '';
        }

        return str_starts_with($current, $target) ? $class : '';
    }
}

if (!function_exists('locale')) {
    function locale(): string
    {
        $loc = Session::get('locale', config('app.locale', 'bn'));
        return in_array($loc, ['bn', 'en'], true) ? $loc : 'bn';
    }
}

if (!function_exists('t')) {
    function t(string $key, ?string $default = null): string
    {
        static $cache = [];
        $loc = locale();

        if (!isset($cache[$loc])) {
            $path = dirname(__DIR__) . "/config/lang/{$loc}.php";
            $cache[$loc] = is_file($path) ? require $path : [];
        }

        return $cache[$loc][$key] ?? $default ?? $key;
    }
}

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        static $cache = null;
        if ($cache === null) {
            $cache = (new \App\Repositories\SettingsRepository())->all();
        }
        return $cache[$key] ?? $default;
    }
}

if (!function_exists('current_path')) {
    function current_path(): string
    {
        return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    }
}

if (!function_exists('current_navaratri_day')) {
    /**
     * Returns the active Navaratri day number (1-9) for today based on
     * festival_calendar for the configured current year, or null if today
     * falls outside the festival window.
     */
    function current_navaratri_day(): ?int
    {
        static $resolved = false;
        static $day = null;

        if ($resolved) {
            return $day;
        }
        $resolved = true;

        $repo = new \App\Repositories\CalendarRepository();
        $year = (int) config('app.current_navaratri_year');
        $today = date('Y-m-d');
        $row = $repo->findByDate($year, $today);
        $day = $row['day_number'] ?? null;

        return $day;
    }
}
