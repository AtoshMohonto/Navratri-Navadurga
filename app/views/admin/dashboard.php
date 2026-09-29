<h1>ড্যাশবোর্ড</h1>
<p class="text-muted">স্বাগতম, <?= e(auth_user()['name'] ?? '') ?>। এখান থেকে পুরো সাইটের কন্টেন্ট পরিচালনা করুন।</p>

<div class="stat-grid">
    <div class="stat-card"><div class="num"><?= bn_digits($stats['users']) ?></div><div class="label">ব্যবহারকারী</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits($stats['articles']) ?></div><div class="label">নিবন্ধ</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits($stats['sevas']) ?></div><div class="label">সেবা</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits($stats['puja_items']) ?></div><div class="label">পূজা সামগ্রী</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits($stats['mantras']) ?></div><div class="label">মন্ত্র</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits($stats['navadurga']) ?></div><div class="label">নবদুর্গা রূপ</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits($stats['completed_checklists']) ?></div><div class="label">সম্পন্ন চেকলিস্ট</div></div>
    <div class="stat-card"><div class="num"><?= bn_digits($stats['completed_seva']) ?></div><div class="label">সম্পন্ন সেবা</div></div>
</div>

<?php if ($stats['new_messages'] > 0): ?>
<div class="alert alert-info">আপনার <?= bn_digits($stats['new_messages']) ?>টি নতুন বার্তা এসেছে। <a href="<?= url('/admin/messages') ?>">দেখুন</a></div>
<?php endif; ?>

<h2>দ্রুত লিংক</h2>
<div class="quicklinks">
    <a class="quicklink" href="<?= url('/admin/navadurga') ?>">নবদুর্গা পরিচালনা করুন</a>
    <a class="quicklink" href="<?= url('/admin/navaratri') ?>">৯ দিনের অনুষ্ঠানসূচি পরিচালনা করুন</a>
    <a class="quicklink" href="<?= url('/admin/seva') ?>">সেবা পরিচালনা করুন</a>
    <a class="quicklink" href="<?= url('/admin/puja-items') ?>">পূজা সামগ্রী পরিচালনা করুন</a>
    <a class="quicklink" href="<?= url('/admin/articles') ?>">নিবন্ধ পরিচালনা করুন</a>
    <a class="quicklink" href="<?= url('/admin/calendar') ?>">পঞ্জিকা হালনাগাদ করুন</a>
</div>
