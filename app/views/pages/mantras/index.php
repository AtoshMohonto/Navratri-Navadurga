<h1 class="text-center">মন্ত্র</h1>
<p class="section-subtitle">নবদুর্গা ও নবরাত্রি সম্পর্কিত মন্ত্র — উচ্চারণ, অর্থ ও উৎসসহ। ঐতিহ্যভেদে পাঠের সামান্য পার্থক্য থাকতে পারে।</p>

<?php if (empty($mantras)): ?>
    <div class="empty-state"><div class="icon">🕉️</div><p>এখনও কোনো মন্ত্র যোগ করা হয়নি।</p></div>
<?php else: ?>
<div class="grid grid-2">
    <?php foreach ($mantras as $m): ?>
        <a href="<?= url('/mantras/' . $m['slug']) ?>" class="card mantra-card">
            <div class="card-body">
                <?php if ($m['associated_day']): ?><span class="day-badge">দিন <?= bn_digits($m['associated_day']) ?></span><?php endif; ?>
                <h3><?= e($m['title_bn']) ?></h3>
                <p style="font-family:var(--font-heading);"><?= e(truncate($m['sanskrit'], 80)) ?></p>
                <span class="text-muted" style="font-size:0.85rem;">বিস্তারিত দেখুন →</span>
            </div>
        </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>
