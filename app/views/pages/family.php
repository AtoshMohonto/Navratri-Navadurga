<h1 class="text-center">পরিবার কার্যক্রম</h1>
<p class="section-subtitle">নবরাত্রিতে পরিবারের সবাই মিলে করার মতো কার্যক্রম — প্রার্থনা, একসাথে পড়াশোনা, প্রসাদ প্রস্তুতি ও সেবা।</p>

<?php if (!empty($activities)): ?>
<div class="grid grid-3" style="margin-bottom:48px;">
    <?php foreach ($activities as $a): ?>
        <div class="card activity-card">
            <?php if ($a['image']): ?><img src="<?= url($a['image']) ?>" alt="<?= e($a['title_bn']) ?>"><?php endif; ?>
            <div class="card-body">
                <?php if ($a['category']): ?><span class="tag"><?= e($a['category']) ?></span><?php endif; ?>
                <h3><?= e($a['title_bn']) ?></h3>
                <p class="text-muted" style="font-size:0.85rem;"><?= e($a['duration']) ?></p>
                <p><?= e(truncate($a['description'], 120)) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<section class="section" style="background:var(--color-surface-alt);border-radius:var(--radius-lg);">
    <h2 class="section-title text-center">৯ দিনের পরিবার চ্যালেঞ্জ</h2>
    <p class="section-subtitle">প্রতিদিন একটি ছোট, অর্থবহ কাজ — সম্পূর্ণ করুন বা এড়িয়ে যান, আপনার পছন্দমতো।</p>

    <?php if (!is_logged_in()): ?>
        <p class="text-center text-muted">অগ্রগতি সংরক্ষণ করতে <a href="<?= url('/login') ?>">লগইন করুন</a>।</p>
    <?php endif; ?>

    <ul class="checklist" style="max-width:640px;margin:0 auto;">
        <?php foreach ($challengeDays as $day => $task):
            $status = $progress[$day]['status'] ?? 'pending';
        ?>
            <li class="checklist-item <?= $status === 'completed' ? 'completed' : '' ?>">
                <span style="flex:1;"><strong>দিন <?= bn_digits($day) ?>:</strong> <?= e($task) ?></span>
                <?php if (is_logged_in()): ?>
                    <form method="POST" action="<?= url('/family/challenge') ?>" style="margin:0;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="day" value="<?= $day ?>">
                        <input type="hidden" name="status" value="<?= $status === 'completed' ? 'pending' : 'completed' ?>">
                        <button type="submit" class="btn btn-sm <?= $status === 'completed' ? 'btn-ghost' : 'btn-primary' ?>"><?= $status === 'completed' ? 'সম্পন্ন ✓' : 'সম্পন্ন করুন' ?></button>
                    </form>
                    <?php if ($status !== 'skipped'): ?>
                    <form method="POST" action="<?= url('/family/challenge') ?>" style="margin:0;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="day" value="<?= $day ?>">
                        <input type="hidden" name="status" value="skipped">
                        <button type="submit" class="btn btn-sm btn-ghost">এড়িয়ে যান</button>
                    </form>
                    <?php endif; ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
