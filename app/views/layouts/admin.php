<?php
$__title = isset($title) ? $title . ' — অ্যাডমিন' : 'অ্যাডমিন প্যানেল';
$__adminUser = auth_user();
?><!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($__title) ?> — <?= e(setting('site_name', 'নবদুর্গা')) ?></title>
<meta name="robots" content="noindex, nofollow">
<script>
(function(){ try { var t = localStorage.getItem('navadurga_theme'); if (t) document.documentElement.setAttribute('data-theme', t); } catch(e){} })();
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@500;600;700&display=swap">
<link rel="stylesheet" href="<?= asset('css/app.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a href="<?= url('/admin') ?>" class="admin-brand"><?= e(setting('site_name', 'নবদুর্গা')) ?> <span>অ্যাডমিন</span></a>
        <nav>
            <?php $__dashActive = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/') === rtrim(url('/admin'), '/'); ?>
            <a href="<?= url('/admin') ?>" class="<?= $__dashActive ? 'active' : '' ?>">ড্যাশবোর্ড</a>
            <a href="<?= url('/admin/navadurga') ?>" class="<?= active_class('/admin/navadurga') ?>">নবদুর্গা</a>
            <a href="<?= url('/admin/navaratri') ?>" class="<?= active_class('/admin/navaratri') ?>">৯ দিন</a>
            <a href="<?= url('/admin/seva') ?>" class="<?= active_class('/admin/seva') ?>">সেবা</a>
            <a href="<?= url('/admin/puja-items') ?>" class="<?= active_class('/admin/puja-items') ?>">পূজা সামগ্রী</a>
            <a href="<?= url('/admin/mantras') ?>" class="<?= active_class('/admin/mantras') ?>">মন্ত্র</a>
            <a href="<?= url('/admin/children') ?>" class="<?= active_class('/admin/children') ?>">শিশু কার্যক্রম</a>
            <a href="<?= url('/admin/family') ?>" class="<?= active_class('/admin/family') ?>">পরিবার কার্যক্রম</a>
            <a href="<?= url('/admin/environment') ?>" class="<?= active_class('/admin/environment') ?>">পরিবেশ কার্যক্রম</a>
            <a href="<?= url('/admin/articles') ?>" class="<?= active_class('/admin/articles') ?>">নিবন্ধ</a>
            <a href="<?= url('/admin/gallery') ?>" class="<?= active_class('/admin/gallery') ?>">গ্যালারি</a>
            <a href="<?= url('/admin/faq') ?>" class="<?= active_class('/admin/faq') ?>">প্রশ্নোত্তর</a>
            <a href="<?= url('/admin/calendar') ?>" class="<?= active_class('/admin/calendar') ?>">পঞ্জিকা</a>
            <a href="<?= url('/admin/messages') ?>" class="<?= active_class('/admin/messages') ?>">বার্তা</a>
            <a href="<?= url('/admin/users') ?>" class="<?= active_class('/admin/users') ?>">ব্যবহারকারী</a>
            <a href="<?= url('/admin/settings') ?>" class="<?= active_class('/admin/settings') ?>">সেটিংস</a>
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="menu-toggle" id="admin-sidebar-toggle" aria-label="মেনু" style="display:none;">☰</button>
            <div></div>
            <div class="flex items-center gap-12">
                <a href="<?= url('/') ?>" class="btn btn-ghost btn-sm" target="_blank" rel="noopener">সাইট দেখুন</a>
                <span class="text-muted"><?= e($__adminUser['name'] ?? '') ?></span>
                <form method="POST" action="<?= url('/logout') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline btn-sm">লগআউট</button>
                </form>
            </div>
        </header>
        <div class="admin-content">
            <?php require __DIR__ . '/../components/alerts.php'; ?>
            <?= $content ?>
        </div>
    </div>
</div>
<script src="<?= asset('js/app.js') ?>" defer></script>
</body>
</html>
