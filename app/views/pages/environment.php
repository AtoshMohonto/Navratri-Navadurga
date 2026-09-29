<h1 class="text-center">পরিবেশ কার্যক্রম</h1>
<p class="section-subtitle">নবরাত্রিতে প্রকৃতির যত্ন নেওয়ার মতো সহজ কার্যক্রম।</p>

<?php if (empty($activities)): ?>
    <div class="empty-state"><div class="icon">🌱</div><p>এখনও কোনো কার্যক্রম যোগ করা হয়নি।</p></div>
<?php else: ?>
<div class="grid grid-2">
    <?php foreach ($activities as $a): ?>
        <div class="card">
            <?php if ($a['image']): ?><img src="<?= url($a['image']) ?>" alt="<?= e($a['title_bn']) ?>" style="width:100%;aspect-ratio:16/9;object-fit:cover;"><?php endif; ?>
            <div class="card-body">
                <h3><?= e($a['title_bn']) ?></h3>
                <?php if ($a['why_text']): ?><p><strong>কেন?</strong> <?= e($a['why_text']) ?></p><?php endif; ?>
                <?php if ($a['how_text']): ?><p><strong>কীভাবে?</strong> <?= e($a['how_text']) ?></p><?php endif; ?>
                <?php if ($a['materials_needed']): ?><p><strong>প্রয়োজনীয়:</strong> <?= e($a['materials_needed']) ?></p><?php endif; ?>
                <div class="meta">
                    <span class="tag tag-difficulty-<?= $a['difficulty'] === 'সহজ' ? 'easy' : ($a['difficulty'] === 'মাঝারি' ? 'medium' : 'hard') ?>"><?= e($a['difficulty']) ?></span>
                    <?php if ($a['estimated_cost']): ?><span class="tag"><?= e($a['estimated_cost']) ?></span><?php endif; ?>
                    <?php if ($a['time_required']): ?><span class="tag"><?= e($a['time_required']) ?></span><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
