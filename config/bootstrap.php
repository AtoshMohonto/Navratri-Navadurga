<?php

/**
 * Application bootstrap — loaded once by public/index.php (and CLI scripts).
 * Wires the autoloader, environment, error handling, session and helpers.
 */

define('APP_ROOT', dirname(__DIR__));
define('ASSET_VERSION', '1');

require APP_ROOT . '/app/core/Autoloader.php';
\App\Core\Autoloader::register(APP_ROOT . '/app');

\App\Core\Env::load(APP_ROOT . '/.env');

date_default_timezone_set(\App\Core\Env::get('APP_TIMEZONE', 'Asia/Dhaka'));

$debug = (bool) \App\Core\Env::get('APP_DEBUG', false);
error_reporting($debug ? E_ALL : E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', $debug ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', APP_ROOT . '/storage/logs/php-error.log');

// Detect the base URL path so the app works both:
//  - at a domain root / vhost with DocumentRoot = /public (SCRIPT_NAME dirname is the real base), and
//  - mounted in a subdirectory via the root .htaccess "rewrite everything to public/"
//    trick (e.g. http://localhost/navadurga/ on plain XAMPP), where SCRIPT_NAME
//    reflects the internally-rewritten /public path but the browser-visible
//    REQUEST_URI never includes /public.
if (PHP_SAPI !== 'cli') {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $scriptDir = $scriptDir === '/' ? '' : rtrim($scriptDir, '/');
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

    if ($scriptDir !== '' && str_ends_with($scriptDir, '/public') && !str_starts_with($requestPath, $scriptDir)) {
        $basePath = substr($scriptDir, 0, -strlen('/public'));
    } else {
        $basePath = $scriptDir;
    }

    putenv('APP_BASE_PATH=' . $basePath);
    $_ENV['APP_BASE_PATH'] = $basePath;
}

require APP_ROOT . '/app/helpers/functions.php';

if (PHP_SAPI !== 'cli') {
    \App\Core\Session::start();

    // Baseline security headers on every response.
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
}
