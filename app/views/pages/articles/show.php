<article style="max-width:760px;margin:0 auto;">
    <header style="margin-bottom:20px;">
        <?php if ($item['category_name']): ?><span class="tag"><?= e($item['category_name']) ?></span><?php endif; ?>
        <h1><?= e($item['title_bn']) ?></h1>
        <p class="text-muted"><?= e($item['author']) ?><?= $item['published_at'] ? ' · ' . bn_date($item['published_at']) : '' ?><?= $item['reading_time'] ? ' · ' . e($item['reading_time']) : '' ?></p>
        <?php if ($item['featured_image']): ?><img src="<?= url($item['featured_image']) ?>" alt="<?= e($item['title_bn']) ?>" style="border-radius:var(--radius-lg);margin-top:12px;"><?php endif; ?>
    </header>

    <div style="font-size:1.05rem;line-height:1.9;">
        <?= nl2br(e($item['content'])) ?>
    </div>

    <?php if ($item['source']): ?>
        <p class="text-muted" style="font-size:0.8rem;margin-top:24px;">উৎস: <?= e($item['source']) ?></p>
    <?php endif; ?>

    <div class="flex gap-8" style="margin-top:24px;border-top:1px solid var(--color-border);padding-top:20px;">
        <button class="btn btn-ghost btn-sm" data-print>প্রিন্ট করুন</button>
        <button class="btn btn-ghost btn-sm" id="share-btn">শেয়ার করুন</button>
    </div>

    <?php if (!empty($related)): ?>
    <section style="margin-top:40px;">
        <h2>সম্পর্কিত নিবন্ধ</h2>
        <div class="grid grid-3">
            <?php foreach ($related as $r): ?>
                <a href="<?= url('/articles/' . $r['slug']) ?>" class="card article-card"><div class="card-body"><strong><?= e($r['title_bn']) ?></strong></div></a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</article>

<script>
document.getElementById('share-btn').addEventListener('click', function () {
    if (navigator.share) {
        navigator.share({ title: document.title, url: window.location.href });
    } else if (navigator.clipboard) {
        navigator.clipboard.writeText(window.location.href);
        this.textContent = 'লিংক কপি হয়েছে ✓';
    }
});
</script>
