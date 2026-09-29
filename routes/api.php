<?php

use App\Controllers\ApiController;
use App\Middleware\CsrfMiddleware;

$router->post('/api/checklist/toggle', [ApiController::class, 'toggleChecklist'], [CsrfMiddleware::class]);
$router->post('/api/puja-status/toggle', [ApiController::class, 'togglePujaStatus'], [CsrfMiddleware::class]);
$router->post('/api/bookmark/toggle', [ApiController::class, 'toggleBookmark'], [CsrfMiddleware::class]);
