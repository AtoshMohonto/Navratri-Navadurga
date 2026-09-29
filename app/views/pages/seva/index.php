<h1 class="text-center">সেবা</h1>
<p class="section-subtitle">নিজের সামর্থ্য অনুযায়ী মানুষের পাশে দাঁড়ানো, জ্ঞান ভাগ করে নেওয়া, প্রকৃতির যত্ন নেওয়া ও সমাজে ইতিবাচক কাজ করার প্রস্তাব।</p>
<p class="disclaimer-note text-center" style="max-width:720px;margin:0 auto 32px;">এই ওয়েবসাইটের প্রস্তাবিত সেবা — এগুলো শাস্ত্রীয় অবশ্যকরণীয় আচার নয়, বরং আধুনিক ও মূল্যবোধভিত্তিক প্রস্তাবনা।</p>

<div class="today-widget" style="max-width:820px;margin:0 auto 40px;">
    <h2 class="text-center" style="margin-bottom:6px;">আজ আমি কী করতে পারি?</h2>
    <p class="text-muted text-center">আপনার বাজেট ও সময় অনুযায়ী উপযুক্ত সেবা খুঁজুন</p>
    <form method="GET" action="<?= url('/seva') ?>">
        <div class="form-row">
            <div class="form-group">
                <label>বাজেট</label>
                <select name="budget" class="form-control">
                    <option value="">যেকোনো বাজেট</option>
                    <option value="0-100" <?= ($filters['budget'] ?? '') === '0-100' ? 'selected' : '' ?>>৳০ – ১০০ (টাকা না থাকলেও সময় দিয়ে)</option>
                    <option value="100-500" <?= ($filters['budget'] ?? '') === '100-500' ? 'selected' : '' ?>>৳১০০ – ৫০০</option>
                    <option value="500-1000" <?= ($filters['budget'] ?? '') === '500-1000' ? 'selected' : '' ?>>৳৫০০ – ১০০০</option>
                    <option value="1000+" <?= ($filters['budget'] ?? '') === '1000+' ? 'selected' : '' ?>>৳১০০০+</option>
                </select>
            </div>
            <div class="form-group">
                <label>সময়</label>
                <select name="time" class="form-control">
                    <option value="">যেকোনো সময়</option>
                    <option value="15min" <?= ($filters['time'] ?? '') === '15min' ? 'selected' : '' ?>>১৫ মিনিট</option>
                    <option value="30min" <?= ($filters['time'] ?? '') === '30min' ? 'selected' : '' ?>>৩০ মিনিট</option>
                    <option value="1hour" <?= ($filters['time'] ?? '') === '1hour' ? 'selected' : '' ?>>১ ঘণ্টা</option>
                    <option value="half_day" <?= ($filters['time'] ?? '') === 'half_day' ? 'selected' : '' ?>>অর্ধ দিন</option>
                    <option value="full_day" <?= ($filters['time'] ?? '') === 'full_day' ? 'selected' : '' ?>>পুরো দিন</option>
                </select>
            </div>
            <div class="form-group">
                <label>কাদের জন্য</label>
                <select name="category" class="form-control">
                    <option value="">যেকোনো ক্যাটাগরি</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= e($c) ?>" <?= ($filters['category'] ?? '') === $c ? 'selected' : '' ?>><?= e($c) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;">
                <button type="submit" class="btn btn-primary w-full">খুঁজুন</button>
            </div>
        </div>
    </form>
    <p class="text-muted text-center" style="font-size:0.85rem;margin-top:8px;">উদাহরণ: "আমার কাছে টাকা নেই, কিন্তু সময় আছে" — বাজেট ৳০ বেছে নিন, নিচে শেখানো, প্রবীণের সঙ্গে সময় কাটানো বা স্বেচ্ছাসেবার মতো সেবা দেখতে পাবেন।</p>
</div>

<form method="GET" action="<?= url('/seva') ?>" class="filter-panel">
    <div class="form-row">
        <div class="form-group mb-0">
            <label>কঠিনতা</label>
            <select name="difficulty" class="form-control" onchange="this.form.submit()">
                <option value="">সব</option>
                <?php foreach (['সহজ', 'মাঝারি', 'কঠিন'] as $d): ?>
                    <option value="<?= e($d) ?>" <?= ($filters['difficulty'] ?? '') === $d ? 'selected' : '' ?>><?= e($d) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mb-0">
            <label>নবরাত্রি দিন</label>
            <select name="day" class="form-control" onchange="this.form.submit()">
                <option value="">সব দিন</option>
                <?php for ($d = 1; $d <= 9; $d++): ?>
                    <option value="<?= $d ?>" <?= ($filters['day'] ?? '') === (string) $d ? 'selected' : '' ?>>দিন <?= bn_digits($d) ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
</form>

<?php if (empty($sevas)): ?>
    <div class="empty-state"><div class="icon">🤝</div><p>এই ফিল্টারে কোনো সেবা পাওয়া যায়নি। ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন।</p></div>
<?php else: ?>
<div class="grid grid-3">
    <?php foreach ($sevas as $s): ?>
        <div class="card seva-card"><div class="card-body">
            <span class="tag"><?= e($s['category']) ?></span>
            <h3><?= e($s['title_bn']) ?></h3>
            <p class="text-muted" style="font-size:0.9rem;"><?= e(truncate($s['description'], 90)) ?></p>
            <div class="meta">
                <span class="tag tag-difficulty-<?= $s['difficulty'] === 'সহজ' ? 'easy' : ($s['difficulty'] === 'মাঝারি' ? 'medium' : 'hard') ?>"><?= e($s['difficulty']) ?></span>
                <?php if ($s['estimated_cost']): ?><span class="tag"><?= e($s['estimated_cost']) ?></span><?php endif; ?>
                <?php if ($s['time_required']): ?><span class="tag"><?= e($s['time_required']) ?></span><?php endif; ?>
            </div>
            <a href="<?= url('/seva/' . $s['slug']) ?>" class="btn btn-outline btn-sm" style="margin-top:auto;">বিস্তারিত</a>
        </div></div>
    <?php endforeach; ?>
</div>

<?php if ($pagination['last_page'] > 1): ?>
<div class="pagination">
    <?php
    $qs = $filters;
    for ($p = 1; $p <= $pagination['last_page']; $p++):
        $qs['page'] = $p;
        $query = http_build_query(array_filter($qs, fn($v) => $v !== null && $v !== ''));
    ?>
        <a href="<?= url('/seva?' . $query) ?>" class="<?= $p === $pagination['page'] ? 'current' : '' ?>"><?= bn_digits($p) ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>
