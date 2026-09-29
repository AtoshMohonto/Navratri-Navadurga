<h1>স্বাগতম, <?= e($user['name']) ?></h1>

<div class="stat-grid">
    <div class="stat-card"><div class="num"><?= bn_digits($completedChecklist) ?>/<?= bn_digits($totalChecklist) ?></div><div class="label">পূজা চেকলিস্ট সম্পন্ন</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits(count($sevaLogs)) ?></div><div class="label">সম্পন্ন সেবা</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits($familyCompleted) ?>/৯</div><div class="label">পরিবার চ্যালেঞ্জ</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits(count($bookmarks)) ?></div><div class="label">বুকমার্ক</div></div>
</div>

<?php if (!empty($badges)): ?>
<section style="margin-bottom:32px;">
    <h2>আপনার ব্যাজ</h2>
    <div class="flex gap-12" style="flex-wrap:wrap;">
        <?php foreach ($badges as $b): ?>
            <span class="tag" style="font-size:0.9rem;padding:8px 16px;">🏅 <?= e($b['title_bn']) ?></span>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<div class="grid grid-3" style="margin-bottom:32px;">
    <a href="<?= url('/my-checklist') ?>" class="card"><div class="card-body"><h3 class="mb-0">আমার চেকলিস্ট</h3></div></a>
    <a href="<?= url('/my-seva') ?>" class="card"><div class="card-body"><h3 class="mb-0">আমার সেবা</h3></div></a>
    <a href="<?= url('/bookmarks') ?>" class="card"><div class="card-body"><h3 class="mb-0">আমার বুকমার্ক</h3></div></a>
    <a href="<?= url('/profile') ?>" class="card"><div class="card-body"><h3 class="mb-0">প্রোফাইল</h3></div></a>
    <a href="<?= url('/family') ?>" class="card"><div class="card-body"><h3 class="mb-0">পরিবার চ্যালেঞ্জ</h3></div></a>
    <a href="<?= url('/daily-guide') ?>" class="card"><div class="card-body"><h3 class="mb-0">আজকের গাইড</h3></div></a>
</div>

<?php if (!empty($sevaLogs)): ?>
<section>
    <h2>সাম্প্রতিক সেবা</h2>
    <ul class="checklist">
        <?php foreach (array_slice($sevaLogs, 0, 5) as $log): ?>
            <li class="checklist-item completed"><span><?= e($log['seva_title'] ?: $log['custom_title']) ?> — <?= bn_date($log['completed_at']) ?></span></li>
        <?php endforeach; ?>
    </ul>
</section>
<?php endif; ?>
