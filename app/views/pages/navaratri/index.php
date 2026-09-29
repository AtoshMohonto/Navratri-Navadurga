<h1 class="text-center">নবরাত্রি — ৯ দিনের পরিকল্পনা</h1>
<p class="section-subtitle">নয় দিনের প্রতিটি দিনের জন্য দেবীর রূপ, পূজা প্রস্তুতি, শেখার বিষয়, সেবা ও পারিবারিক কার্যক্রমের পরিকল্পনা।</p>

<div class="grid grid-3">
    <?php foreach ($days as $d): ?>
        <a href="<?= url('/navaratri/day/' . $d['day_number']) ?>" class="card day-card">
            <div class="card-body">
                <span class="day-badge">
                    দিন <?= bn_digits($d['day_number']) ?>
                    <?php if ($currentDayNumber && (int) $d['day_number'] === $currentDayNumber): ?> · আজ<?php endif; ?>
                </span>
                <h3><?= e($d['navadurga_name_bn']) ?></h3>
                <p class="text-muted" style="font-size:0.9rem;"><?= e($d['theme']) ?></p>
                <span class="text-muted" style="font-size:0.85rem;">পরিকল্পনা দেখুন →</span>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<section class="section">
    <h2 class="section-title text-center">৯ দিনের সেবা-ফোকাস সারণি</h2>
    <div class="table-responsive">
        <table class="data-table stack-mobile">
            <thead>
                <tr>
                    <th>দিন</th><th>দেবীর রূপ</th><th>আধুনিক সেবা-ফোকাস</th>
                    <th>সহজ সেবা</th><th>মাঝারি সেবা</th><th>কঠিন সেবা</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($days as $d): ?>
                <tr>
                    <td data-label="দিন"><?= bn_digits($d['day_number']) ?></td>
                    <td data-label="দেবীর রূপ"><?= e($d['navadurga_name_bn']) ?></td>
                    <td data-label="আধুনিক সেবা-ফোকাস"><?= e($d['theme']) ?></td>
                    <td data-label="সহজ সেবা"><?= e(truncate($d['seva_easy'], 60)) ?></td>
                    <td data-label="মাঝারি সেবা"><?= e(truncate($d['seva_moderate'], 60)) ?></td>
                    <td data-label="কঠিন সেবা"><?= e(truncate($d['seva_challenging'], 60)) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="disclaimer-note" style="margin-top:16px;">
        উপরের সেবা-ফোকাসগুলো এই ওয়েবসাইটের আধুনিক ও মূল্যবোধভিত্তিক প্রস্তাবনা। এগুলোকে নির্দিষ্ট শাস্ত্রবিধি হিসেবে বিবেচনা করা উচিত নয়।
    </p>
</section>
