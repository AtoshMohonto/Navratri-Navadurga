<?php

use App\Controllers\ArticleController;
use App\Controllers\AuthController;
use App\Controllers\BookmarkController;
use App\Controllers\CalendarController;
use App\Controllers\ChecklistController;
use App\Controllers\ChildrenController;
use App\Controllers\DailyGuideController;
use App\Controllers\DashboardController;
use App\Controllers\EnvironmentController;
use App\Controllers\FamilyController;
use App\Controllers\FaqController;
use App\Controllers\GalleryController;
use App\Controllers\HomeController;
use App\Controllers\LearningController;
use App\Controllers\LocaleController;
use App\Controllers\MantraController;
use App\Controllers\NavadurgaController;
use App\Controllers\NavaratriController;
use App\Controllers\PageController;
use App\Controllers\ProfileController;
use App\Controllers\PujaItemController;
use App\Controllers\SearchController;
use App\Controllers\SevaController;
use App\Controllers\SevaLogController;
use App\Controllers\SitemapController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\GuestMiddleware;

// ---------- Home / locale ----------
$router->get('/', [HomeController::class, 'index']);
$router->get('/lang/{locale}', [LocaleController::class, 'switch']);
$router->get('/sitemap.xml', [SitemapController::class, 'index']);

// ---------- Navadurga ----------
$router->get('/navadurga', [NavadurgaController::class, 'index']);
$router->get('/navadurga/{slug}', [NavadurgaController::class, 'show']);

// ---------- Navaratri ----------
$router->get('/navaratri', [NavaratriController::class, 'index']);
$router->get('/navaratri/day/{day}', [NavaratriController::class, 'day']);

// ---------- Calendar ----------
$router->get('/calendar', [CalendarController::class, 'index']);

// ---------- Puja planning / items ----------
$router->get('/puja-planning', [ChecklistController::class, 'index']);
$router->get('/my-checklist', [ChecklistController::class, 'index'], [AuthMiddleware::class]);
$router->get('/puja-items', [PujaItemController::class, 'index']);

// ---------- Seva ----------
$router->get('/seva', [SevaController::class, 'index']);
$router->get('/seva/{slug}', [SevaController::class, 'show']);
$router->post('/seva/{slug}/complete', [SevaController::class, 'complete'], [CsrfMiddleware::class]);
$router->get('/my-seva', [SevaLogController::class, 'mine'], [AuthMiddleware::class]);

// ---------- Daily guide ----------
$router->get('/daily-guide', [DailyGuideController::class, 'index']);
$router->post('/daily-guide/reflection', [DailyGuideController::class, 'saveReflection'], [CsrfMiddleware::class]);

// ---------- Children / Family / Environment ----------
$router->get('/children', [ChildrenController::class, 'index']);
$router->get('/family', [FamilyController::class, 'index']);
$router->post('/family/challenge', [FamilyController::class, 'toggleChallenge'], [CsrfMiddleware::class]);
$router->get('/environment', [EnvironmentController::class, 'index']);

// ---------- Learning / Mantras / Articles / FAQ / Gallery ----------
$router->get('/learning', [LearningController::class, 'index']);
$router->get('/mantras', [MantraController::class, 'index']);
$router->get('/mantras/{slug}', [MantraController::class, 'show']);
$router->get('/articles', [ArticleController::class, 'index']);
$router->get('/articles/{slug}', [ArticleController::class, 'show']);
$router->get('/faq', [FaqController::class, 'index']);
$router->get('/gallery', [GalleryController::class, 'index']);

// ---------- Search / About / Contact ----------
$router->get('/search', [SearchController::class, 'index']);
$router->get('/about', [PageController::class, 'about']);
$router->get('/contact', [PageController::class, 'contact']);
$router->post('/contact', [PageController::class, 'submitContact'], [CsrfMiddleware::class]);

// ---------- Auth ----------
$router->get('/login', [AuthController::class, 'showLogin'], [GuestMiddleware::class]);
$router->post('/login', [AuthController::class, 'login'], [GuestMiddleware::class, CsrfMiddleware::class]);
$router->get('/register', [AuthController::class, 'showRegister'], [GuestMiddleware::class]);
$router->post('/register', [AuthController::class, 'register'], [GuestMiddleware::class, CsrfMiddleware::class]);
$router->post('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class, CsrfMiddleware::class]);

// ---------- User area ----------
$router->get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);
$router->get('/profile', [ProfileController::class, 'index'], [AuthMiddleware::class]);
$router->post('/profile', [ProfileController::class, 'update'], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->get('/bookmarks', [BookmarkController::class, 'index'], [AuthMiddleware::class]);
