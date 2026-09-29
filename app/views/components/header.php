<a href="#main-content" class="skip-link">মূল বিষয়বস্তুতে যান</a>
<header class="site-header">
    <div class="container nav-bar">
        <a href="<?= url('/') ?>" class="brand">
            <svg class="brand-mark" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="20" cy="20" r="19" stroke="currentColor" stroke-width="1.4"/>
                <path d="M20 6 C24 14 24 14 20 20 C16 14 16 14 20 6 Z" fill="currentColor"/>
                <path d="M20 34 C24 26 24 26 20 20 C16 26 16 26 20 34 Z" fill="currentColor"/>
                <path d="M6 20 C14 16 14 16 20 20 C14 24 14 24 6 20 Z" fill="currentColor"/>
                <path d="M34 20 C26 16 26 16 20 20 C26 24 26 24 34 20 Z" fill="currentColor"/>
            </svg>
            <span>
                <?= e(setting('site_name', 'নবদুর্গা')) ?>
                <span class="brand-sub"><?= e(setting('site_subtitle', 'জ্ঞান • সাধনা • পূজা • সেবা')) ?></span>
            </span>
        </a>

        <nav aria-label="প্রধান মেনু">
            <ul class="nav-links">
                <li><a href="<?= url('/navadurga') ?>" class="<?= active_class('/navadurga') ?>"><?= e(t('nav.navadurga')) ?></a></li>
                <li><a href="<?= url('/navaratri') ?>" class="<?= active_class('/navaratri') ?>"><?= e(t('nav.navaratri')) ?></a></li>
                <li><a href="<?= url('/puja-planning') ?>" class="<?= active_class('/puja-planning') ?>"><?= e(t('nav.puja_planning')) ?></a></li>
                <li><a href="<?= url('/seva') ?>" class="<?= active_class('/seva') ?>"><?= e(t('nav.seva')) ?></a></li>
                <li><a href="<?= url('/learning') ?>" class="<?= active_class('/learning') ?>"><?= e(t('nav.learning')) ?></a></li>
                <li><a href="<?= url('/articles') ?>" class="<?= active_class('/articles') ?>"><?= e(t('nav.articles')) ?></a></li>
            </ul>
        </nav>

        <div class="nav-actions">
            <a href="<?= url('/search') ?>" class="theme-toggle" aria-label="<?= e(t('nav.search')) ?>" title="<?= e(t('nav.search')) ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.35-4.35"/></svg>
            </a>
            <a href="<?= url('/lang/' . (locale() === 'bn' ? 'en' : 'bn') . '?back=' . urlencode(current_path())) ?>" class="theme-toggle" aria-label="Switch language" title="Switch language / ভাষা পরিবর্তন করুন" style="width:auto;padding:0 12px;font-weight:700;font-size:0.8rem;">
                <?= locale() === 'bn' ? 'EN' : 'বাং' ?>
            </a>
            <button type="button" class="theme-toggle" id="theme-toggle" aria-label="থিম পরিবর্তন করুন" title="থিম পরিবর্তন করুন">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
            </button>
            <?php if (is_logged_in()): ?>
                <a href="<?= url('/dashboard') ?>" class="btn btn-outline btn-sm"><?= e(t('nav.dashboard')) ?></a>
                <form method="POST" action="<?= url('/logout') ?>" style="margin:0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-ghost btn-sm"><?= e(t('nav.logout')) ?></button>
                </form>
            <?php else: ?>
                <a href="<?= url('/login') ?>" class="btn btn-primary btn-sm"><?= e(t('nav.login')) ?></a>
            <?php endif; ?>
            <button type="button" class="menu-toggle" id="mobile-menu-toggle" aria-label="<?= e(t('nav.menu')) ?>" aria-expanded="false">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
</header>

<div class="mobile-nav" id="mobile-nav">
    <div class="mobile-nav-panel">
        <button type="button" class="mobile-nav-close" id="mobile-nav-close" aria-label="মেনু বন্ধ করুন">&times;</button>
        <nav aria-label="মোবাইল মেনু" style="clear:both;">
            <a href="<?= url('/') ?>"><?= e(t('nav.home')) ?></a>
            <a href="<?= url('/navadurga') ?>"><?= e(t('nav.navadurga')) ?></a>
            <a href="<?= url('/navaratri') ?>"><?= e(t('nav.navaratri')) ?></a>
            <a href="<?= url('/puja-planning') ?>"><?= e(t('nav.puja_planning')) ?></a>
            <a href="<?= url('/puja-items') ?>"><?= e(t('nav.puja_items')) ?></a>
            <a href="<?= url('/seva') ?>"><?= e(t('nav.seva')) ?></a>
            <a href="<?= url('/daily-guide') ?>"><?= e(t('nav.daily_guide')) ?></a>
            <a href="<?= url('/children') ?>"><?= e(t('nav.children')) ?></a>
            <a href="<?= url('/family') ?>"><?= e(t('nav.family')) ?></a>
            <a href="<?= url('/environment') ?>"><?= e(t('nav.environment')) ?></a>
            <a href="<?= url('/learning') ?>"><?= e(t('nav.learning')) ?></a>
            <a href="<?= url('/mantras') ?>"><?= e(t('nav.mantras')) ?></a>
            <a href="<?= url('/articles') ?>"><?= e(t('nav.articles')) ?></a>
            <a href="<?= url('/calendar') ?>"><?= e(t('nav.calendar')) ?></a>
            <a href="<?= url('/faq') ?>"><?= e(t('nav.faq')) ?></a>
            <a href="<?= url('/about') ?>"><?= e(t('nav.about')) ?></a>
            <a href="<?= url('/contact') ?>"><?= e(t('nav.contact')) ?></a>
            <?php if (is_logged_in()): ?>
                <a href="<?= url('/dashboard') ?>"><?= e(t('nav.dashboard')) ?></a>
                <form method="POST" action="<?= url('/logout') ?>" style="margin:8px;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline btn-block"><?= e(t('nav.logout')) ?></button>
                </form>
            <?php else: ?>
                <a href="<?= url('/login') ?>"><?= e(t('nav.login')) ?></a>
            <?php endif; ?>
        </nav>
    </div>
</div>
