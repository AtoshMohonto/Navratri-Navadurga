<h1>যোগাযোগ বার্তা</h1>

<?php if (empty($messages)): ?>
    <div class="empty-state"><div class="icon">✉️</div><p>কোনো বার্তা নেই।</p></div>
<?php else: ?>
<div class="table-responsive">
<table class="data-table stack-mobile">
    <thead><tr><th>নাম</th><th>ইমেইল</th><th>বার্তা</th><th>অবস্থা</th><th>তারিখ</th><th>কার্যক্রম</th></tr></thead>
    <tbody>
    <?php foreach ($messages as $m): ?>
        <tr>
            <td data-label="নাম"><?= e($m['name']) ?></td>
            <td data-label="ইমেইল"><?= e($m['email']) ?></td>
            <td data-label="বার্তা"><?= e(truncate($m['message'], 80)) ?></td>
            <td data-label="অবস্থা"><span class="badge <?= $m['status'] === 'new' ? 'badge-inactive' : 'badge-active' ?>"><?= $m['status'] === 'new' ? 'নতুন' : 'পঠিত' ?></span></td>
            <td data-label="তারিখ"><?= bn_date($m['created_at']) ?></td>
            <td data-label="কার্যক্রম">
                <div class="table-actions">
                    <?php if ($m['status'] === 'new'): ?>
                    <form method="POST" action="<?= url("/admin/messages/{$m['id']}/read") ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-ghost btn-sm">পঠিত করুন</button>
                    </form>
                    <?php endif; ?>
                    <form method="POST" action="<?= url("/admin/messages/{$m['id']}/delete") ?>" onsubmit="return confirm('মুছে ফেলবেন?');">
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
<?php endif; ?>
