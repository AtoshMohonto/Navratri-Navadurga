<h1>আমার সেবা</h1>
<p class="text-muted">আপনার সম্পন্ন করা সেবার তালিকা।</p>

<?php if (empty($logs)): ?>
    <div class="empty-state"><div class="icon">🤝</div><p>এখনও কোনো সেবা সম্পন্ন করা হয়নি।</p>
    <a href="<?= url('/seva') ?>" class="btn btn-outline btn-sm">সেবা খুঁজুন</a></div>
<?php else: ?>
<div class="table-responsive">
<table class="data-table stack-mobile">
    <thead><tr><th>সেবা</th><th>মন্তব্য</th><th>তারিখ</th></tr></thead>
    <tbody>
    <?php foreach ($logs as $log): ?>
        <tr>
            <td data-label="সেবা"><?= e($log['seva_title'] ?: ($log['custom_title'] ?: '—')) ?></td>
            <td data-label="মন্তব্য"><?= e($log['note'] ?: '—') ?></td>
            <td data-label="তারিখ"><?= bn_date($log['completed_at']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<div class="text-center" style="margin-top:20px;"><button class="btn btn-outline btn-sm" data-print>প্রিন্ট করুন</button></div>
<?php endif; ?>
