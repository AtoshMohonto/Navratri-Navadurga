<h1 class="text-center">শিশু কার্যক্রম</h1>
<p class="section-subtitle">নবরাত্রিতে শিশুদের জন্য নিরাপদ ও বয়স-উপযোগী কার্যক্রম — আঁকা, গল্প শোনা, বই দান ও আরও অনেক কিছু।</p>

<?php if (empty($activities)): ?>
    <div class="empty-state"><div class="icon">🧒</div><p>এখনও কোনো কার্যক্রম যোগ করা হয়নি।</p></div>
<?php else: ?>
<div class="grid grid-3">
    <?php foreach ($activities as $a): ?>
        <div class="card activity-card">
            <?php if ($a['image']): ?><img src="<?= url($a['image']) ?>" alt="<?= e($a['title']) ?>"><?php endif; ?>
            <div class="card-body">
                <?php if ($a['day_number']): ?><span class="day-badge">দিন <?= bn_digits($a['day_number']) ?></span><?php endif; ?>
                <h3><?= e($a['title']) ?></h3>
                <p class="text-muted" style="font-size:0.85rem;"><?= e($a['age_group']) ?> · <?= e($a['duration']) ?></p>
                <p><?= e(truncate($a['description'], 120)) ?></p>
                <?php if ($a['materials']): ?><p class="text-muted" style="font-size:0.85rem;"><strong>প্রয়োজনীয়:</strong> <?= e($a['materials']) ?></p><?php endif; ?>
                <?php if ($a['instructions']): ?><p style="font-size:0.9rem;"><?= nl2br(e($a['instructions'])) ?></p><?php endif; ?>
                <?php if ($a['learning_outcome']): ?><p class="text-muted" style="font-size:0.85rem;"><strong>শেখার ফলাফল:</strong> <?= e($a['learning_outcome']) ?></p><?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
