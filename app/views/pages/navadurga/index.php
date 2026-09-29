<h1 class="text-center">নবদুর্গার নয়টি রূপ</h1>
<p class="section-subtitle">নবরাত্রির নয়টি দিনে পূজিতা দেবী দুর্গার নয়টি ভিন্ন রূপের পরিচিতি — প্রতিটি রূপের প্রথাগত বিবরণ, প্রতীকতত্ত্ব ও আধুনিক ব্যাখ্যাসহ।</p>

<div class="grid grid-3">
    <?php foreach ($forms as $n): ?>
        <a href="<?= url('/navadurga/' . $n['slug']) ?>" class="card navadurga-card">
            <div class="thumb">
                <?php if (!empty($n['image'])): ?>
                    <img src="<?= url($n['image']) ?>" alt="<?= e($n['name_bn']) ?>" style="width:100%;height:100%;object-fit:cover;">
                <?php else: ?>
                    <?= bn_digits($n['day_number']) ?>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <span class="day-badge">দিন <?= bn_digits($n['day_number']) ?></span>
                <h3><?= e($n['name_bn']) ?></h3>
                <div class="sanskrit"><?= e($n['sanskrit_name']) ?></div>
                <p class="text-muted" style="font-size:0.9rem;"><?= e(truncate($n['short_description'], 90)) ?></p>
                <span class="text-muted" style="font-size:0.85rem;">বিস্তারিত দেখুন →</span>
            </div>
        </a>
    <?php endforeach; ?>
</div>
