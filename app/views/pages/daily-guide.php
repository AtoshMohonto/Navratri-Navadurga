<h1 class="text-center">দৈনিক গাইড</h1>

<?php if (!$day): ?>
    <div class="empty-state"><div class="icon">📅</div><p>এই মুহূর্তে নবরাত্রি চলছে না। নবরাত্রি শুরু হলে এখানে দৈনিক গাইড দেখতে পাবেন।</p>
    <a href="<?= url('/navaratri') ?>" class="btn btn-outline btn-sm">৯ দিনের পরিকল্পনা দেখুন</a></div>
<?php else: ?>
<p class="section-subtitle text-center">দিন <?= bn_digits($dayNumber) ?> — <?= e($day['navadurga_name_bn']) ?></p>

<div class="grid grid-2" style="margin-bottom:24px;">
    <div class="card"><div class="card-body">
        <h3>আজকের দেবী</h3>
        <p><?= e($day['navadurga_short_description']) ?></p>
        <a href="<?= url('/navadurga/' . $day['navadurga_slug']) ?>" class="btn btn-outline btn-sm">বিস্তারিত</a>
    </div></div>
    <div class="card"><div class="card-body">
        <h3>আজকের পূজা প্রস্তুতি</h3>
        <p><?= e($day['puja_focus'] ?: $day['traditional_focus']) ?></p>
        <a href="<?= url('/puja-planning') ?>" class="btn btn-outline btn-sm">চেকলিস্ট দেখুন</a>
    </div></div>
</div>

<div class="card" style="margin-bottom:24px;">
    <div class="card-body">
        <h3>আজকের শেখার বিষয়</h3>
        <p class="mb-0"><?= e($day['learning_focus']) ?></p>
    </div>
</div>

<section style="margin-bottom:24px;background:var(--color-surface-alt);padding:20px;border-radius:var(--radius-lg);">
    <h3>আজকের সেবা</h3>
    <div class="grid grid-3">
        <?php foreach ($sevas as $s): ?>
            <div class="card seva-card"><div class="card-body">
                <strong><?= e($s['title_bn']) ?></strong>
                <a href="<?= url('/seva/' . $s['slug']) ?>" class="btn btn-outline btn-sm">বিস্তারিত</a>
            </div></div>
        <?php endforeach; ?>
    </div>
</section>

<div class="grid grid-3" style="margin-bottom:24px;">
    <?php if (!empty($childrenActivities)): ?><div class="card"><div class="card-body"><span class="tag">শিশু</span><p class="mb-0"><?= e($childrenActivities[0]['title']) ?></p></div></div><?php endif; ?>
    <?php if (!empty($familyActivities)): ?><div class="card"><div class="card-body"><span class="tag">পরিবার</span><p class="mb-0"><?= e($familyActivities[0]['title_bn']) ?></p></div></div><?php endif; ?>
    <?php if (!empty($environmentActivities)): ?><div class="card"><div class="card-body"><span class="tag">পরিবেশ</span><p class="mb-0"><?= e($environmentActivities[0]['title_bn']) ?></p></div></div><?php endif; ?>
</div>

<section style="margin-bottom:24px;">
    <h3>আজকের চেকলিস্ট</h3>
    <ul class="checklist">
        <?php foreach (array_slice($checklist, 0, 6) as $c): ?><li class="checklist-item"><span><?= e($c['label_bn']) ?></span></li><?php endforeach; ?>
    </ul>
</section>

<?php if ($nextDay): ?>
<div class="disclaimer-note text-center">আগামীকালের প্রস্তুতি: <?= e($nextDay['navadurga_name_bn']) ?> — <?= e($nextDay['theme']) ?></div>
<?php endif; ?>

<a href="<?= url('/navaratri/day/' . $dayNumber) ?>" class="btn btn-primary" style="margin-top:20px;">সম্পূর্ণ দিনের পরিকল্পনা ও প্রতিফলন দেখুন</a>
<?php endif; ?>
