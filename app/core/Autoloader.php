<?php

namespace App\Core;

class Autoloader
{
    protected static array $map = [
        'App\\Core\\' => 'core/',
        'App\\Controllers\\Admin\\' => 'controllers/admin/',
        'App\\Controllers\\' => 'controllers/',
        'App\\Models\\' => 'models/',
        'App\\Repositories\\' => 'repositories/',
        'App\\Services\\' => 'services/',
        'App\\Middleware\\' => 'middleware/',
        'App\\Validators\\' => 'validators/',
        'App\\Helpers\\' => 'helpers/',
    ];

    public static function register(string $appPath): void
    {
        spl_autoload_register(function (string $class) use ($appPath) {
            foreach (self::$map as $prefix => $dir) {
                if (str_starts_with($class, $prefix)) {
                    $relative = substr($class, strlen($prefix));
                    $relative = str_replace('\\', '/', $relative);
                    $file = rtrim($appPath, '/\\') . '/' . $dir . $relative . '.php';

                    if (is_file($file)) {
                        require_once $file;
                        return;
                    }
                }
            }
        });
    }
}
