<?php
$__title = isset($title) ? $title . ' — ' . setting('site_name', 'নবদুর্গা') : setting('site_name', 'নবদুর্গা') . ' — ' . setting('site_subtitle', 'জ্ঞান • সাধনা • পূজা • সেবা');
$__description = $metaDescription ?? setting('site_description', 'নবরাত্রির প্রতিটি দিন হোক জ্ঞান, সাধনা, আনন্দ ও সেবার একটি নতুন অধ্যায়।');
$__scheme = ((($_SERVER['HTTPS'] ?? '') !== '' && ($_SERVER['HTTPS'] ?? '') !== 'off') || ($_SERVER['SERVER_PORT'] ?? '') == 443) ? 'https' : 'http';
$__requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$__canonical = $__scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $__requestPath;
?><!DOCTYPE html>
<html lang="<?= locale() === 'en' ? 'en' : 'bn' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($__title) ?></title>
<meta name="description" content="<?= e($__description) ?>">
<link rel="canonical" href="<?= e($__canonical) ?>">
<meta property="og:title" content="<?= e($__title) ?>">
<meta property="og:description" content="<?= e($__description) ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="<?= locale() === 'en' ? 'en_US' : 'bn_BD' ?>">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= asset('images/favicon.svg') ?>" type="image/svg+xml">
<link rel="manifest" href="<?= url('/manifest.json') ?>">
<meta name="theme-color" content="#8B2E3C">
<script>
(function(){
    try {
        var t = localStorage.getItem('navadurga_theme');
        if (t) document.documentElement.setAttribute('data-theme', t);
    } catch (e) {}
})();
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@500;600;700&display=swap">
<link rel="stylesheet" href="<?= asset('css/app.css') ?>">
<?= $extraHead ?? '' ?>
</head>
<body>
<script>window.CSRF_TOKEN = <?= json_encode(\App\Core\Csrf::token()) ?>;</script>
<?php require __DIR__ . '/../components/header.php'; ?>

<main id="main-content">
    <?php if (!empty($breadcrumbs)): ?>
        <div class="container" style="padding-top:20px;">
            <?php require __DIR__ . '/../components/breadcrumb.php'; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($noContainer)): ?>
        <div class="container" style="padding-top: 8px;">
            <?php require __DIR__ . '/../components/alerts.php'; ?>
            <?= $content ?>
        </div>
    <?php else: ?>
        <?= $content ?>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
