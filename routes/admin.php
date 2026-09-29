<?php

use App\Controllers\Admin\ArticleController;
use App\Controllers\Admin\CalendarController;
use App\Controllers\Admin\ChildrenController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\EnvironmentController;
use App\Controllers\Admin\FamilyController;
use App\Controllers\Admin\FaqController;
use App\Controllers\Admin\GalleryController;
use App\Controllers\Admin\MantraController;
use App\Controllers\Admin\MessageController;
use App\Controllers\Admin\NavadurgaController;
use App\Controllers\Admin\NavaratriController;
use App\Controllers\Admin\PujaItemController;
use App\Controllers\Admin\SettingsController;
use App\Controllers\Admin\SevaController;
use App\Controllers\Admin\UserController;
use App\Middleware\AdminMiddleware;
use App\Middleware\CsrfMiddleware;

$adminMw = [AdminMiddleware::class];
$adminMwPost = [AdminMiddleware::class, CsrfMiddleware::class];

$router->get('/admin', [DashboardController::class, 'index'], $adminMw);

/**
 * Registers the standard CRUD route set for a resource-style admin
 * controller: list/search, create form, store, edit form, update, delete.
 */
$registerCrud = function (string $base, string $controllerClass) use ($router, $adminMw, $adminMwPost) {
    $router->get("/{$base}", [$controllerClass, 'index'], $adminMw);
    $router->get("/{$base}/create", [$controllerClass, 'create'], $adminMw);
    $router->post("/{$base}", [$controllerClass, 'store'], $adminMwPost);
    $router->get("/{$base}/{id}/edit", [$controllerClass, 'edit'], $adminMw);
    $router->post("/{$base}/{id}/update", [$controllerClass, 'update'], $adminMwPost);
    $router->post("/{$base}/{id}/delete", [$controllerClass, 'destroy'], $adminMwPost);
};

$registerCrud('admin/navadurga', NavadurgaController::class);
$registerCrud('admin/navaratri', NavaratriController::class);
$registerCrud('admin/seva', SevaController::class);
$registerCrud('admin/puja-items', PujaItemController::class);
$registerCrud('admin/mantras', MantraController::class);
$registerCrud('admin/articles', ArticleController::class);
$registerCrud('admin/children', ChildrenController::class);
$registerCrud('admin/family', FamilyController::class);
$registerCrud('admin/environment', EnvironmentController::class);
$registerCrud('admin/faq', FaqController::class);
$registerCrud('admin/gallery', GalleryController::class);
$registerCrud('admin/users', UserController::class);
$registerCrud('admin/calendar', CalendarController::class);

$router->get('/admin/settings', [SettingsController::class, 'index'], $adminMw);
$router->post('/admin/settings', [SettingsController::class, 'update'], $adminMwPost);

$router->get('/admin/messages', [MessageController::class, 'index'], $adminMw);
$router->post('/admin/messages/{id}/read', [MessageController::class, 'markRead'], $adminMwPost);
$router->post('/admin/messages/{id}/delete', [MessageController::class, 'destroy'], $adminMwPost);
