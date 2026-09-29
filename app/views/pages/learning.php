<h1 class="text-center">আধ্যাত্মিক জ্ঞান</h1>
<p class="section-subtitle">নবদুর্গা, নবরাত্রি, শক্তি সাধনা ও পূজা ঐতিহ্য সম্পর্কে জ্ঞান — যেখানে সম্ভব শাস্ত্রীয় বর্ণনা, প্রথাগত বিশ্বাস, আঞ্চলিক রীতি, পণ্ডিতি ব্যাখ্যা ও আধুনিক ব্যাখ্যা পৃথকভাবে উপস্থাপিত।</p>

<div class="disclaimer-note" style="max-width:760px;margin:0 auto 32px;">
    এই ওয়েবসাইটের বিভিন্ন অংশে তথ্য উপস্থাপনের সময় আমরা চেষ্টা করি স্পষ্টভাবে উল্লেখ করতে — "শাস্ত্রীয় বর্ণনায়", "প্রচলিত বিশ্বাস অনুযায়ী", "আঞ্চলিক রীতিতে", "আধুনিক ব্যাখ্যায়" ইত্যাদি। ঐতিহ্যভেদে তথ্যের পার্থক্য থাকলে তা উল্লেখ করার চেষ্টা করা হয়।
</div>

<div class="grid grid-3">
    <?php foreach ($topics as $t): ?>
        <a href="<?= str_starts_with($t['url'], '/about') ? url($t['url']) : url($t['url']) ?>" class="card">
            <div class="card-body">
                <h3><?= e($t['label']) ?></h3>
                <p class="text-muted mb-0"><?= e($t['desc']) ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<?php if (!empty($articles)): ?>
<section class="section">
    <h2 class="section-title text-center">সম্পর্কিত নিবন্ধ</h2>
    <div class="grid grid-3">
        <?php foreach ($articles as $a): ?>
            <a href="<?= url('/articles/' . $a['slug']) ?>" class="card article-card">
                <div class="card-body"><strong><?= e($a['title_bn']) ?></strong></div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
