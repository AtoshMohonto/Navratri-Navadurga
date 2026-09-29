<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <h4 style="font-family:var(--font-heading);font-size:1.2rem;color:var(--color-primary);"><?= e(setting('site_name', 'নবদুর্গা')) ?></h4>
                <p class="text-muted"><?= e(setting('site_description', 'নবরাত্রির প্রতিটি দিন হোক জ্ঞান, সাধনা, আনন্দ ও সেবার একটি নতুন অধ্যায়।')) ?></p>
            </div>
            <div>
                <h4><?= e(t('footer.explore')) ?></h4>
                <ul>
                    <li><a href="<?= url('/navadurga') ?>"><?= e(t('nav.navadurga')) ?></a></li>
                    <li><a href="<?= url('/navaratri') ?>"><?= e(t('nav.navaratri')) ?></a></li>
                    <li><a href="<?= url('/puja-planning') ?>"><?= e(t('nav.puja_planning')) ?></a></li>
                    <li><a href="<?= url('/seva') ?>"><?= e(t('nav.seva')) ?></a></li>
                    <li><a href="<?= url('/calendar') ?>"><?= e(t('nav.calendar')) ?></a></li>
                </ul>
            </div>
            <div>
                <h4><?= e(t('footer.knowledge')) ?></h4>
                <ul>
                    <li><a href="<?= url('/learning') ?>"><?= e(t('nav.learning')) ?></a></li>
                    <li><a href="<?= url('/mantras') ?>"><?= e(t('nav.mantras')) ?></a></li>
                    <li><a href="<?= url('/articles') ?>"><?= e(t('nav.articles')) ?></a></li>
                    <li><a href="<?= url('/faq') ?>"><?= e(t('nav.faq')) ?></a></li>
                </ul>
            </div>
            <div>
                <h4><?= e(t('footer.institution')) ?></h4>
                <ul>
                    <li><a href="<?= url('/about') ?>"><?= e(t('nav.about')) ?></a></li>
                    <li><a href="<?= url('/contact') ?>"><?= e(t('nav.contact')) ?></a></li>
                    <li><a href="<?= url('/gallery') ?>"><?= e(t('nav.gallery')) ?></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <?= e(setting('footer_text', '© নবদুর্গা — জ্ঞান, সাধনা, পূজা ও সেবার প্ল্যাটফর্ম')) ?> · <?= bn_digits(date('Y')) ?>
        </div>
    </div>
</footer>

<script src="<?= asset('js/app.js') ?>" defer></script>
