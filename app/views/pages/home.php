<section class="hero">
    <div class="container">
        <div class="hero-eyebrow"><?= e(setting('site_subtitle', 'জ্ঞান • সাধনা • পূজা • সেবা')) ?></div>
        <h1><?= e(t('hero.title')) ?></h1>
        <p class="lead"><?= e(t('hero.subtitle')) ?></p>
        <div class="hero-actions">
            <a href="<?= url('/navaratri') ?>" class="btn btn-primary"><?= e(t('hero.btn_plan')) ?></a>
            <a href="<?= url('/navadurga') ?>" class="btn btn-outline"><?= e(t('hero.btn_about')) ?></a>
            <a href="<?= url('/seva') ?>" class="btn btn-outline"><?= e(t('hero.btn_seva')) ?></a>
            <a href="<?= url('/puja-planning') ?>" class="btn btn-outline"><?= e(t('hero.btn_puja')) ?></a>
        </div>
    </div>
</section>

<?php if ($todaysNavadurga): ?>
<section class="section">
    <div class="section-head-row">
        <div>
            <h2 class="mb-0"><?= e(t('section.today_navadurga')) ?><?= $currentDayNumber ? ' — ' . e(t('common.day')) . ' ' . bn_digits($currentDayNumber) : '' ?></h2>
            <p class="text-muted mb-0"><?= e($todaysNavadurga['name_bn']) ?></p>
        </div>
        <a href="<?= url('/navadurga/' . $todaysNavadurga['slug']) ?>" class="btn btn-outline btn-sm"><?= e(t('common.view_details')) ?></a>
    </div>
    <div class="card">
        <div class="card-body flex gap-12" style="flex-wrap:wrap;">
            <div style="flex:1;min-width:220px;">
                <h3><?= e($todaysNavadurga['name_bn']) ?> <span class="text-muted" style="font-size:0.9rem;">(<?= e($todaysNavadurga['sanskrit_name']) ?>)</span></h3>
                <p><?= e($todaysNavadurga['short_description']) ?></p>
                <?php if ($todaysDay): ?>
                <p class="text-muted"><strong>আজকের থিম:</strong> <?= e($todaysDay['theme']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($upcoming): ?>
<section class="section" style="padding-top:0;">
    <div class="card">
        <div class="card-body text-center">
            <p class="text-muted mb-0"><?= e(t('section.upcoming_festival')) ?></p>
            <h3 class="mb-0"><?= e($upcoming['event_label'] ?: 'নবরাত্রি') ?> — <?= bn_date($upcoming['gregorian_date']) ?></h3>
            <div id="countdown" class="flex gap-12 justify-between" style="max-width:360px;margin:16px auto 0;" data-target="<?= e($upcoming['gregorian_date']) ?>T00:00:00">
                <div><div class="num" id="cd-days" style="font-family:var(--font-heading);font-size:1.6rem;color:var(--color-primary);">০</div><div class="text-muted" style="font-size:0.8rem;">দিন</div></div>
                <div><div class="num" id="cd-hours" style="font-family:var(--font-heading);font-size:1.6rem;color:var(--color-primary);">০</div><div class="text-muted" style="font-size:0.8rem;">ঘণ্টা</div></div>
                <div><div class="num" id="cd-mins" style="font-family:var(--font-heading);font-size:1.6rem;color:var(--color-primary);">০</div><div class="text-muted" style="font-size:0.8rem;">মিনিট</div></div>
                <div><div class="num" id="cd-secs" style="font-family:var(--font-heading);font-size:1.6rem;color:var(--color-primary);">০</div><div class="text-muted" style="font-size:0.8rem;">সেকেন্ড</div></div>
            </div>
        </div>
    </div>
</section>
<script>
(function () {
    var el = document.getElementById('countdown');
    if (!el) return;
    var target = new Date(el.getAttribute('data-target')).getTime();
    var bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
    function toBn(n) { return String(n).split('').map(function (d) { return bn[d] || d; }).join(''); }
    function tick() {
        var diff = target - Date.now();
        if (diff < 0) diff = 0;
        var days = Math.floor(diff / 86400000);
        var hours = Math.floor((diff % 86400000) / 3600000);
        var mins = Math.floor((diff % 3600000) / 60000);
        var secs = Math.floor((diff % 60000) / 1000);
        document.getElementById('cd-days').textContent = toBn(days);
        document.getElementById('cd-hours').textContent = toBn(hours);
        document.getElementById('cd-mins').textContent = toBn(mins);
        document.getElementById('cd-secs').textContent = toBn(secs);
    }
    tick();
    setInterval(tick, 1000);
})();
</script>
<?php endif; ?>

<section class="section">
    <h2 class="section-title text-center"><?= e(t('section.nine_forms')) ?></h2>
    <p class="section-subtitle">নবরাত্রির নয়টি দিনে পূজিতা দেবী দুর্গার নয়টি রূপ</p>
    <div class="grid grid-3">
        <?php foreach ($navadurgaList as $n): ?>
            <a href="<?= url('/navadurga/' . $n['slug']) ?>" class="card navadurga-card">
                <div class="thumb">
                    <?php if (!empty($n['image'])): ?>
                        <img src="<?= url($n['image']) ?>" alt="<?= e($n['name_bn']) ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <?= bn_digits($n['day_number']) ?>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <span class="day-badge">দিন <?= bn_digits($n['day_number']) ?></span>
                    <h3><?= e($n['name_bn']) ?></h3>
                    <div class="sanskrit"><?= e($n['sanskrit_name']) ?></div>
                    <span class="text-muted" style="font-size:0.85rem;"><?= e(t('common.view_details')) ?> →</span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="section" style="background:var(--color-surface-alt);border-radius:var(--radius-lg);">
    <div class="grid grid-2">
        <div>
            <h2><?= e(t('section.today_checklist')) ?></h2>
            <ul class="checklist">
                <?php foreach (array_slice($checklistPreview, 0, 5) as $item): ?>
                    <li class="checklist-item"><span><?= e($item['label_bn']) ?></span></li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= url('/puja-planning') ?>" class="btn btn-outline btn-sm"><?= e(t('common.view_all')) ?></a>
        </div>
        <div>
            <h2><?= e(t('section.today_seva')) ?></h2>
            <?php foreach ($todaysSevas as $s): ?>
                <div class="card" style="margin-bottom:10px;">
                    <div class="card-body">
                        <strong><?= e($s['title_bn']) ?></strong>
                        <div class="meta">
                            <span class="tag tag-difficulty-<?= $s['difficulty'] === 'সহজ' ? 'easy' : ($s['difficulty'] === 'মাঝারি' ? 'medium' : 'hard') ?>"><?= e($s['difficulty']) ?></span>
                            <span class="tag"><?= e($s['time_required']) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <a href="<?= url('/seva') ?>" class="btn btn-outline btn-sm"><?= e(t('common.view_all')) ?></a>
        </div>
    </div>
</section>

<?php if ($todaysLearning): ?>
<section class="section" style="padding-top:0;">
    <div class="card" style="max-width:820px;margin:0 auto;">
        <div class="card-body">
            <h2 style="margin-bottom:8px;">আজকের শেখার বিষয়</h2>
            <p class="mb-0"><?= e($todaysLearning) ?></p>
            <a href="<?= url('/daily-guide') ?>" class="btn btn-outline btn-sm" style="margin-top:12px;">সম্পূর্ণ দৈনিক গাইড দেখুন</a>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section">
    <h2 class="section-title text-center"><?= e(t('section.today_activities')) ?></h2>
    <div class="grid grid-3">
        <?php if ($childrenActivity): ?>
        <div class="card activity-card"><div class="card-body">
            <span class="tag">শিশু কার্যক্রম</span>
            <h3><?= e($childrenActivity['title']) ?></h3>
            <p class="text-muted"><?= e(truncate($childrenActivity['description'], 100)) ?></p>
            <a href="<?= url('/children') ?>">বিস্তারিত →</a>
        </div></div>
        <?php endif; ?>
        <?php if ($familyActivity): ?>
        <div class="card activity-card"><div class="card-body">
            <span class="tag">পরিবার কার্যক্রম</span>
            <h3><?= e($familyActivity['title_bn']) ?></h3>
            <p class="text-muted"><?= e(truncate($familyActivity['description'], 100)) ?></p>
            <a href="<?= url('/family') ?>">বিস্তারিত →</a>
        </div></div>
        <?php endif; ?>
        <?php if ($environmentActivity): ?>
        <div class="card activity-card"><div class="card-body">
            <span class="tag">পরিবেশ কার্যক্রম</span>
            <h3><?= e($environmentActivity['title_bn']) ?></h3>
            <p class="text-muted"><?= e(truncate($environmentActivity['why_text'], 100)) ?></p>
            <a href="<?= url('/environment') ?>">বিস্তারিত →</a>
        </div></div>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="section-head-row">
        <h2 class="mb-0"><?= e(t('section.puja_samagri')) ?></h2>
        <a href="<?= url('/puja-items') ?>" class="btn btn-outline btn-sm"><?= e(t('common.view_all')) ?></a>
    </div>
    <div class="grid grid-3">
        <?php foreach ($pujaItems as $item): ?>
            <div class="card"><div class="card-body">
                <strong><?= e($item['name_bn']) ?></strong>
                <p class="text-muted mb-0" style="font-size:0.85rem;"><?= e($item['category']) ?> · <?= e($item['quantity']) ?> <?= e($item['unit']) ?></p>
            </div></div>
        <?php endforeach; ?>
    </div>
</section>

<?php if ($todaysMantra): ?>
<section class="section">
    <h2 class="section-title text-center"><?= e(t('section.today_mantra')) ?></h2>
    <div class="card" style="max-width:640px;margin:0 auto;">
        <div class="card-body text-center">
            <p style="font-family:var(--font-heading);font-size:1.3rem;"><?= e($todaysMantra['sanskrit']) ?></p>
            <p class="text-muted"><?= e($todaysMantra['meaning_bn']) ?></p>
            <a href="<?= url('/mantras') ?>" class="btn btn-outline btn-sm"><?= e(t('common.view_all')) ?></a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($featuredArticle): ?>
<section class="section">
    <h2 class="section-title text-center"><?= e(t('section.featured_article')) ?></h2>
    <div class="card article-card" style="max-width:720px;margin:0 auto;">
        <?php if (!empty($featuredArticle['featured_image'])): ?>
            <img src="<?= url($featuredArticle['featured_image']) ?>" alt="<?= e($featuredArticle['title_bn']) ?>">
        <?php endif; ?>
        <div class="card-body">
            <h3><?= e($featuredArticle['title_bn']) ?></h3>
            <p class="text-muted"><?= e(truncate($featuredArticle['excerpt'], 150)) ?></p>
            <a href="<?= url('/articles/' . $featuredArticle['slug']) ?>" class="btn btn-outline btn-sm">পুরো নিবন্ধ পড়ুন</a>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section text-center">
    <div class="disclaimer-note" style="max-width:720px;margin:0 auto;">
        <?= e(t('disclaimer.seva_focus')) ?>
    </div>
</section>
