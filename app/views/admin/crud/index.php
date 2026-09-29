<?php
$fieldMap = [];
foreach ($fields as $f) { $fieldMap[$f['key']] = $f; }

if (!function_exists('admin_display_value')) {
function admin_display_value($field, $value) {
    if ($value === null || $value === '') return '—';
    if (($field['type'] ?? '') === 'select' && isset($field['options'][$value])) {
        return $field['options'][$value];
    }
    if (($field['type'] ?? '') === 'checkbox') {
        return $value ? 'হ্যাঁ' : 'না';
    }
    if (($field['type'] ?? '') === 'image') {
        return '<img src="' . e(url($value)) . '" alt="" style="width:44px;height:44px;object-fit:cover;border-radius:6px;">';
    }
    return e(truncate((string) $value, 60));
}
}
?>
<div class="admin-toolbar">
    <h1 class="mb-0"><?= e($title) ?> ব্যবস্থাপনা</h1>
    <a href="<?= url("/{$routeBase}/create") ?>" class="btn btn-primary">+ নতুন <?= e($title) ?></a>
</div>

<form method="GET" class="admin-search" style="margin-bottom:18px;">
    <input type="text" name="q" value="<?= e($q) ?>" class="form-control" placeholder="অনুসন্ধান করুন...">
    <button type="submit" class="btn btn-ghost">খুঁজুন</button>
</form>

<?php if (empty($items)): ?>
    <div class="empty-state">
        <div class="icon">🔍</div>
        <p>কোনো তথ্য পাওয়া যায়নি।</p>
    </div>
<?php else: ?>
<div class="table-responsive">
    <table class="data-table stack-mobile">
        <thead>
            <tr>
                <?php foreach ($listColumns as $col): ?>
                    <th><?= e($fieldMap[$col]['label'] ?? $col) ?></th>
                <?php endforeach; ?>
                <th>কার্যক্রম</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <?php foreach ($listColumns as $col): ?>
                        <td data-label="<?= e($fieldMap[$col]['label'] ?? $col) ?>"><?= admin_display_value($fieldMap[$col] ?? [], $item[$col] ?? null) ?></td>
                    <?php endforeach; ?>
                    <td data-label="কার্যক্রম">
                        <div class="table-actions">
                            <a class="btn btn-ghost btn-sm" href="<?= url("/{$routeBase}/{$item['id']}/edit") ?>">সম্পাদনা</a>
                            <form method="POST" action="<?= url("/{$routeBase}/{$item['id']}/delete") ?>" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এটি মুছে ফেলতে চান?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger btn-sm">মুছুন</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if ($pagination['last_page'] > 1): ?>
<div class="pagination">
    <?php for ($p = 1; $p <= $pagination['last_page']; $p++): ?>
        <a href="<?= url("/{$routeBase}?q=" . urlencode($q) . "&page={$p}") ?>" class="<?= $p === $pagination['page'] ? 'current' : '' ?>"><?= bn_digits($p) ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php endif; ?>
