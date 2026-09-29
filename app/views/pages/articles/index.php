<h1 class="text-center">নিবন্ধ</h1>
<p class="section-subtitle">নবদুর্গা, নবরাত্রি, পূজা, আধ্যাত্মিকতা, সংস্কৃতি ও সেবা বিষয়ক লেখা।</p>

<form method="GET" class="filter-panel">
    <div class="form-row" style="grid-template-columns:2fr 1fr;">
        <div class="form-group mb-0">
            <label>অনুসন্ধান</label>
            <input type="text" name="q" value="<?= e($q) ?>" class="form-control" placeholder="নিবন্ধ খুঁজুন...">
        </div>
        <div class="form-group mb-0">
            <label>ক্যাটাগরি</label>
            <select name="category" class="form-control" onchange="this.form.submit()">
                <option value="">সব ক্যাটাগরি</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $categoryId === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name_bn']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-outline btn-sm">খুঁজুন</button>
</form>

<?php if (empty($articles)): ?>
    <div class="empty-state"><div class="icon">📄</div><p>কোনো নিবন্ধ পাওয়া যায়নি।</p></div>
<?php else: ?>
<div class="grid grid-3">
    <?php foreach ($articles as $a): ?>
        <a href="<?= url('/articles/' . $a['slug']) ?>" class="card article-card">
            <?php if ($a['featured_image']): ?><img src="<?= url($a['featured_image']) ?>" alt="<?= e($a['title_bn']) ?>"><?php endif; ?>
            <div class="card-body">
                <?php if ($a['category_name']): ?><span class="tag"><?= e($a['category_name']) ?></span><?php endif; ?>
                <h3><?= e($a['title_bn']) ?></h3>
                <p class="text-muted" style="font-size:0.9rem;"><?= e(truncate($a['excerpt'], 90)) ?></p>
                <p class="text-muted" style="font-size:0.8rem;"><?= e($a['author']) ?><?= $a['reading_time'] ? ' · ' . e($a['reading_time']) : '' ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<?php if ($pagination['last_page'] > 1): ?>
<div class="pagination">
    <?php for ($p = 1; $p <= $pagination['last_page']; $p++): ?>
        <a href="<?= url('/articles?q=' . urlencode($q) . '&category=' . (int) $categoryId . '&page=' . $p) ?>" class="<?= $p === $pagination['page'] ? 'current' : '' ?>"><?= bn_digits($p) ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>
