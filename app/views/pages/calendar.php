<h1 class="text-center">নবরাত্রি পঞ্জিকা</h1>
<p class="section-subtitle">তিথি অনুযায়ী তারিখে হ্রাস-বৃদ্ধি হতে পারে। সঠিক স্থানীয় পঞ্জিকা যাচাই করে নেওয়ার পরামর্শ দেওয়া হলো।</p>

<?php if (count($years) > 1): ?>
<form method="GET" class="flex gap-8 justify-between" style="max-width:220px;margin:0 auto 24px;">
    <select name="year" class="form-control" onchange="this.form.submit()">
        <?php foreach ($years as $y): ?>
            <option value="<?= $y ?>" <?= $y === $year ? 'selected' : '' ?>><?= bn_digits($y) ?></option>
        <?php endforeach; ?>
    </select>
</form>
<?php endif; ?>

<?php if (empty($entries)): ?>
    <div class="empty-state"><div class="icon">🗓️</div><p><?= bn_digits($year) ?> সালের পঞ্জিকা এখনও যোগ করা হয়নি।</p></div>
<?php else: ?>
<div class="table-responsive">
    <table class="data-table stack-mobile">
        <thead><tr><th>তারিখ</th><th>তিথি</th><th>দিন</th><th>অনুষ্ঠান</th></tr></thead>
        <tbody>
        <?php foreach ($entries as $e): ?>
            <tr>
                <td data-label="তারিখ"><?= bn_date($e['gregorian_date']) ?></td>
                <td data-label="তিথি"><?= e($e['tithi']) ?></td>
                <td data-label="দিন"><?= $e['day_number'] ? bn_digits($e['day_number']) : '—' ?></td>
                <td data-label="অনুষ্ঠান">
                    <?php if ($e['day_number']): ?>
                        <a href="<?= url('/navaratri/day/' . $e['day_number']) ?>"><?= e($e['event_label']) ?></a>
                    <?php else: ?>
                        <?= e($e['event_label']) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="text-center" style="margin-top:20px;">
    <button class="btn btn-outline btn-sm" data-print>প্রিন্ট করুন</button>
</div>
<?php endif; ?>
