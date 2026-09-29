<?php

require dirname(__DIR__) . '/config/bootstrap.php';

$router = new \App\Core\Router();
$router->setBasePath(\App\Core\Env::get('APP_BASE_PATH', ''));

require dirname(__DIR__) . '/routes/web.php';
require dirname(__DIR__) . '/routes/admin.php';
require dirname(__DIR__) . '/routes/api.php';

$request = new \App\Core\Request();
$router->dispatch($request);
