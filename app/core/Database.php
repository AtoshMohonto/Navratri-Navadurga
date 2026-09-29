<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    protected static ?PDO $instance = null;

    public static function connection(): PDO
    {
        if (self::$instance === null) {
            $host = Env::get('DB_HOST', '127.0.0.1');
            $port = Env::get('DB_PORT', '3306');
            $name = Env::get('DB_DATABASE', 'navadurga_db');
            $user = Env::get('DB_USERNAME', 'root');
            $pass = Env::get('DB_PASSWORD', '');
            $charset = Env::get('DB_CHARSET', 'utf8mb4');

            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // Emulated prepares (still fully parameter-bound, never string-concatenated)
                    // because MySQL's native prepared statements reject reusing the same named
                    // placeholder more than once in a query (e.g. "WHERE a LIKE :q OR b LIKE :q"),
                    // which several repository queries rely on for readability.
                    PDO::ATTR_EMULATE_PREPARES => true,
                ]);
            } catch (PDOException $e) {
                if (Env::get('APP_DEBUG', false)) {
                    throw $e;
                }
                http_response_code(500);
                require dirname(__DIR__) . '/views/errors/500.php';
                exit;
            }
        }

        return self::$instance;
    }
}
