<article>
    <header class="text-center" style="margin-bottom:24px;">
        <span class="day-badge">দিন <?= bn_digits($dayNumber) ?> / ৯</span>
        <h1><?= e($item['navadurga_name_bn']) ?></h1>
        <p class="text-muted"><?= e($item['tithi']) ?><?= $item['date'] ? ' · ' . bn_date($item['date']) : '' ?></p>
        <a href="<?= url('/navadurga/' . $item['navadurga_slug']) ?>" class="btn btn-outline btn-sm">দেবীর বিস্তারিত পরিচিতি</a>
    </header>

    <div class="card" style="margin-bottom:24px;">
        <div class="card-body">
            <h3>প্রথাগত তথ্য</h3>
            <span class="disclaimer-note" style="display:inline-block;margin-bottom:10px;">প্রচলিত বিশ্বাস অনুযায়ী</span>
            <p><?= nl2br(e($item['traditional_focus'])) ?></p>
        </div>
    </div>

    <div class="grid grid-2" style="margin-bottom:24px;">
        <?php if ($item['learning_focus']): ?>
        <div class="card"><div class="card-body">
            <h3>আজকের শেখার বিষয়</h3>
            <p><?= nl2br(e($item['learning_focus'])) ?></p>
        </div></div>
        <?php endif; ?>
        <?php if ($item['puja_focus'] || $item['spiritual_focus']): ?>
        <div class="card"><div class="card-body">
            <h3>পূজা প্রস্তুতি</h3>
            <?php if ($item['puja_focus']): ?><p><?= nl2br(e($item['puja_focus'])) ?></p><?php endif; ?>
            <?php if ($item['spiritual_focus']): ?><p class="text-muted"><?= nl2br(e($item['spiritual_focus'])) ?></p><?php endif; ?>
        </div></div>
        <?php endif; ?>
    </div>

    <?php if (!empty($pujaItems)): ?>
    <section style="margin-bottom:24px;">
        <h3>আজকের পূজা সামগ্রী</h3>
        <div class="flex gap-8" style="flex-wrap:wrap;">
            <?php foreach ($pujaItems as $pi): ?><span class="tag"><?= e($pi['name_bn']) ?></span><?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <section style="margin-bottom:24px;">
        <h3>আজকের পূজা চেকলিস্ট</h3>
        <ul class="checklist">
            <?php foreach ($checklist as $c): ?>
                <li class="checklist-item"><span><?= e($c['label_bn']) ?></span></li>
            <?php endforeach; ?>
        </ul>
        <a href="<?= url('/puja-planning') ?>" class="btn btn-outline btn-sm">সম্পূর্ণ চেকলিস্ট পরিচালনা করুন</a>
    </section>

    <section style="margin-bottom:24px;background:var(--color-surface-alt);padding:20px;border-radius:var(--radius-lg);">
        <h3>আজকের সেবা</h3>
        <span class="disclaimer-note" style="display:inline-block;margin-bottom:12px;">এই ওয়েবসাইটের প্রস্তাবিত সেবা</span>
        <div class="grid grid-3">
            <?php foreach ($sevas as $s): ?>
                <div class="card seva-card"><div class="card-body">
                    <strong><?= e($s['title_bn']) ?></strong>
                    <div class="meta"><span class="tag tag-difficulty-<?= $s['difficulty'] === 'সহজ' ? 'easy' : ($s['difficulty'] === 'মাঝারি' ? 'medium' : 'hard') ?>"><?= e($s['difficulty']) ?></span></div>
                    <a href="<?= url('/seva/' . $s['slug']) ?>" class="btn btn-outline btn-sm">বিস্তারিত</a>
                </div></div>
            <?php endforeach; ?>
        </div>
    </section>

    <div class="grid grid-3" style="margin-bottom:24px;">
        <?php if ($item['children_activity']): ?>
        <div class="card"><div class="card-body"><span class="tag">শিশু কার্যক্রম</span><p><?= nl2br(e($item['children_activity'])) ?></p></div></div>
        <?php endif; ?>
        <?php if ($item['family_activity']): ?>
        <div class="card"><div class="card-body"><span class="tag">পরিবার কার্যক্রম</span><p><?= nl2br(e($item['family_activity'])) ?></p></div></div>
        <?php endif; ?>
        <?php if ($item['environment_activity']): ?>
        <div class="card"><div class="card-body"><span class="tag">পরিবেশ কার্যক্রম</span><p><?= nl2br(e($item['environment_activity'])) ?></p></div></div>
        <?php endif; ?>
    </div>

    <?php if (!empty($mantras) || $item['daily_mantra']): ?>
    <section style="margin-bottom:24px;">
        <h3>আজকের মন্ত্র</h3>
        <div class="card"><div class="card-body text-center">
            <p style="font-family:var(--font-heading);font-size:1.2rem;"><?= e($item['daily_mantra']) ?></p>
        </div></div>
    </section>
    <?php endif; ?>

    <?php if ($item['daily_message']): ?>
    <section style="margin-bottom:24px;">
        <h3>আজকের বার্তা</h3>
        <p><?= nl2br(e($item['daily_message'])) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['avoid_note']): ?>
    <p class="disclaimer-note" style="margin-bottom:24px;"><?= e($item['avoid_note']) ?></p>
    <?php endif; ?>

    <section style="margin-bottom:24px;">
        <h3>আজকের প্রতিফলন</h3>
        <?php if (is_logged_in()): ?>
            <form method="POST" action="<?= url('/daily-guide/reflection') ?>" class="card">
                <div class="card-body">
                    <input type="hidden" name="day_number" value="<?= (int) $dayNumber ?>">
                    <?= csrf_field() ?>
                    <div class="form-group"><label>আজ আমি কী শিখলাম?</label><textarea class="form-control" name="learned_text"></textarea></div>
                    <div class="form-group"><label>আজ আমি কাকে সাহায্য করলাম?</label><textarea class="form-control" name="helped_text"></textarea></div>
                    <div class="form-group"><label>আজ আমি কী পরিবর্তন করতে পারি?</label><textarea class="form-control" name="change_text"></textarea></div>
                    <button type="submit" class="btn btn-primary btn-sm">সংরক্ষণ করুন</button>
                </div>
            </form>
        <?php else: ?>
            <p class="text-muted">ব্যক্তিগত প্রতিফলন সংরক্ষণ করতে <a href="<?= url('/login') ?>">লগইন করুন</a>।</p>
        <?php endif; ?>
    </section>

    <nav class="flex justify-between" style="border-top:1px solid var(--color-border);padding-top:20px;">
        <?php if ($prevDayNumber): ?><a href="<?= url('/navaratri/day/' . $prevDayNumber) ?>">← দিন <?= bn_digits($prevDayNumber) ?></a><?php else: ?><span></span><?php endif; ?>
        <?php if ($nextDayNumber && $nextDay): ?>
            <a href="<?= url('/navaratri/day/' . $nextDayNumber) ?>">আগামীকাল: <?= e($nextDay['navadurga_name_bn']) ?> →</a>
        <?php endif; ?>
    </nav>
</article>
