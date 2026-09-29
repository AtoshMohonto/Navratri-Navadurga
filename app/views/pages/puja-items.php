<h1 class="text-center">পূজা সামগ্রী</h1>
<p class="section-subtitle">নবরাত্রি পূজার জন্য প্রয়োজনীয় সামগ্রীর তালিকা। কেনা বা প্রস্তুত করা হয়ে গেলে চিহ্নিত করুন।</p>

<form method="GET" class="filter-panel">
    <div class="form-row">
        <div class="form-group mb-0">
            <label>ক্যাটাগরি</label>
            <select name="category" class="form-control" onchange="this.form.submit()">
                <option value="">সব ক্যাটাগরি</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= e($c) ?>" <?= $category === $c ? 'selected' : '' ?>><?= e($c) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mb-0">
            <label>দিন</label>
            <select name="day" class="form-control" onchange="this.form.submit()">
                <option value="">সব দিন</option>
                <?php for ($d = 1; $d <= 9; $d++): ?>
                    <option value="<?= $d ?>" <?= $day === (string) $d ? 'selected' : '' ?>>দিন <?= bn_digits($d) ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
</form>

<?php if (empty($items)): ?>
    <div class="empty-state"><div class="icon">🪔</div><p>কোনো সামগ্রী পাওয়া যায়নি।</p></div>
<?php else: ?>
<div class="table-responsive">
<table class="data-table stack-mobile">
    <thead><tr><th>নাম</th><th>ক্যাটাগরি</th><th>পরিমাণ</th><th>গুরুত্ব</th><th>কেনা হয়েছে</th><th>প্রস্তুত</th></tr></thead>
    <tbody>
    <?php foreach ($items as $item): $st = $statuses[$item['id']] ?? ['purchased' => 0, 'prepared' => 0]; ?>
        <tr>
            <td data-label="নাম"><strong><?= e($item['name_bn']) ?></strong><?php if ($item['alternative']): ?><div class="text-muted" style="font-size:0.8rem;">বিকল্প: <?= e($item['alternative']) ?></div><?php endif; ?></td>
            <td data-label="ক্যাটাগরি"><?= e($item['category']) ?></td>
            <td data-label="পরিমাণ"><?= e($item['quantity']) ?> <?= e($item['unit']) ?></td>
            <td data-label="গুরুত্ব"><span class="tag"><?= e($item['importance']) ?></span></td>
            <td data-label="কেনা হয়েছে">
                <input type="checkbox" class="puja-status-check" data-item-id="<?= $item['id'] ?>" data-field="purchased" <?= $st['purchased'] ? 'checked' : '' ?> <?= is_logged_in() ? '' : 'disabled' ?>>
            </td>
            <td data-label="প্রস্তুত">
                <input type="checkbox" class="puja-status-check" data-item-id="<?= $item['id'] ?>" data-field="prepared" <?= $st['prepared'] ? 'checked' : '' ?> <?= is_logged_in() ? '' : 'disabled' ?>>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php if (!is_logged_in()): ?>
    <p class="text-muted text-center" style="margin-top:12px;">কেনা/প্রস্তুত চিহ্নিত করার সুবিধা পেতে <a href="<?= url('/login') ?>">লগইন করুন</a>।</p>
<?php endif; ?>
<div class="text-center" style="margin-top:20px;">
    <button class="btn btn-outline btn-sm" data-print>প্রিন্ট করুন / কেনাকাটার তালিকা</button>
</div>
<?php endif; ?>

<script>
document.querySelectorAll('.puja-status-check').forEach(function (cb) {
    cb.addEventListener('change', function () {
        window.navadurgaPost('<?= url('/api/puja-status/toggle') ?>', {
            item_id: cb.getAttribute('data-item-id'),
            field: cb.getAttribute('data-field'),
        });
    });
});
</script>
