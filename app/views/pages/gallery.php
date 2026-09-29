<h1 class="text-center">গ্যালারি</h1>
<p class="section-subtitle">পূজা প্রস্তুতি, কমিউনিটি সেবা, শিশু কার্যক্রম ও পরিবেশ কার্যক্রমের ছবি।</p>

<?php if (empty($images)): ?>
    <div class="empty-state"><div class="icon">🖼️</div><p>এখনও কোনো ছবি যোগ করা হয়নি।</p></div>
<?php else: ?>
<div class="grid grid-3">
    <?php foreach ($images as $img): ?>
        <figure class="card" style="margin:0;">
            <img src="<?= url($img['image']) ?>" alt="<?= e($img['alt_text'] ?: $img['title']) ?>" style="width:100%;aspect-ratio:4/3;object-fit:cover;">
            <figcaption class="card-body" style="padding:12px 16px;">
                <strong style="font-size:0.9rem;"><?= e($img['title']) ?></strong>
                <?php if ($img['caption']): ?><p class="text-muted mb-0" style="font-size:0.82rem;"><?= e($img['caption']) ?></p><?php endif; ?>
                <?php if ($img['credit_source']): ?><p class="text-muted mb-0" style="font-size:0.75rem;">ক্রেডিট: <?= e($img['credit_source']) ?></p><?php endif; ?>
            </figcaption>
        </figure>
    <?php endforeach; ?>
</div>
<?php endif; ?>
