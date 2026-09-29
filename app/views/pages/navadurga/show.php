<article>
    <header class="text-center" style="margin-bottom:28px;">
        <span class="day-badge">দিন <?= bn_digits($item['day_number']) ?></span>
        <h1><?= e($item['name_bn']) ?></h1>
        <p class="text-muted">
            <?= e($item['sanskrit_name']) ?><?= $item['name_en'] ? ' · ' . e($item['name_en']) : '' ?>
            <?php if (!empty($item['alternative_names'])): ?> · <?= e($item['alternative_names']) ?><?php endif; ?>
        </p>
        <?php if (!empty($item['image'])): ?>
            <img src="<?= url($item['image']) ?>" alt="<?= e($item['name_bn']) ?>" style="max-width:280px;margin:16px auto 0;border-radius:var(--radius-lg);">
        <?php endif; ?>
    </header>

    <div class="grid grid-2" style="margin-bottom:28px;">
        <div class="card"><div class="card-body">
            <h3>পরিচিতি</h3>
            <p><?= nl2br(e($item['short_description'])) ?></p>
            <?php if ($item['name_meaning']): ?><p><strong>নামের অর্থ:</strong> <?= e($item['name_meaning']) ?></p><?php endif; ?>
        </div></div>
        <div class="card"><div class="card-body">
            <h3>দ্রুত তথ্য</h3>
            <table style="width:100%;font-size:0.92rem;">
                <?php $facts = [
                    'বাহন' => $item['vehicle'], 'হাত' => $item['hands'], 'অস্ত্র' => $item['weapons'],
                    'ধারণকৃত বস্তু' => $item['objects'], 'রং' => $item['colour'], 'সম্পর্কিত গুণ' => $item['associated_quality'],
                    'সম্পর্কিত চক্র' => $item['associated_chakra'], 'প্রথাগত ভোগ' => $item['traditional_food'],
                ]; ?>
                <?php foreach ($facts as $label => $val): if (!$val) continue; ?>
                    <tr><td class="text-muted" style="padding:4px 0;width:45%;"><?= e($label) ?></td><td style="padding:4px 0;"><?= e($val) ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div></div>
    </div>

    <?php if ($item['detailed_description']): ?>
    <section class="section" style="padding:0 0 28px;">
        <h2>বিস্তারিত বিবরণ</h2>
        <p><?= nl2br(e($item['detailed_description'])) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['iconography'] || $item['traditional_symbolism']): ?>
    <section class="section" style="padding:0 0 28px;">
        <h2>মূর্তিতত্ত্ব ও প্রতীকতত্ত্ব</h2>
        <span class="disclaimer-note" style="display:block;margin-bottom:12px;">শাস্ত্রীয় বর্ণনায়</span>
        <?php if ($item['iconography']): ?><p><?= nl2br(e($item['iconography'])) ?></p><?php endif; ?>
        <?php if ($item['traditional_symbolism']): ?><p><?= nl2br(e($item['traditional_symbolism'])) ?></p><?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if ($item['traditional_association'] || $item['puja_significance']): ?>
    <section class="section" style="padding:0 0 28px;">
        <h2>প্রথাগত সংযোগ ও পূজার তাৎপর্য</h2>
        <span class="disclaimer-note" style="display:block;margin-bottom:12px;">প্রচলিত বিশ্বাস অনুযায়ী</span>
        <?php if ($item['traditional_association']): ?><p><?= nl2br(e($item['traditional_association'])) ?></p><?php endif; ?>
        <?php if ($item['puja_significance']): ?><p><?= nl2br(e($item['puja_significance'])) ?></p><?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if ($item['story']): ?>
    <section class="section" style="padding:0 0 28px;">
        <h2>কাহিনী</h2>
        <p><?= nl2br(e($item['story'])) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['mantra'] || $item['stotra']): ?>
    <section class="section" style="padding:0 0 28px;">
        <h2>মন্ত্র</h2>
        <div class="card"><div class="card-body text-center">
            <?php if ($item['mantra']): ?><p style="font-family:var(--font-heading);font-size:1.3rem;"><?= e($item['mantra']) ?></p><?php endif; ?>
            <?php if ($item['stotra']): ?><p class="text-muted"><?= nl2br(e($item['stotra'])) ?></p><?php endif; ?>
        </div></div>
    </section>
    <?php endif; ?>

    <?php if ($item['regional_variations']): ?>
    <section class="section" style="padding:0 0 28px;">
        <h2>আঞ্চলিক ভিন্নতা</h2>
        <span class="disclaimer-note" style="display:block;margin-bottom:12px;">আঞ্চলিক রীতিতে</span>
        <p><?= nl2br(e($item['regional_variations'])) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['modern_interpretation']): ?>
    <section class="section" style="padding:0 0 28px;">
        <h2>আধুনিক ব্যাখ্যা</h2>
        <span class="disclaimer-note" style="display:block;margin-bottom:12px;">আধুনিক ব্যাখ্যায়</span>
        <p><?= nl2br(e($item['modern_interpretation'])) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['scriptural_sources']): ?>
    <section class="section" style="padding:0 0 28px;">
        <h3>উৎস</h3>
        <p class="text-muted" style="font-size:0.85rem;"><?= e($item['scriptural_sources']) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['seva_note'] || !empty($sevas)): ?>
    <section class="section" style="padding:0 0 28px;background:var(--color-surface-alt);border-radius:var(--radius-lg);">
        <h2>আজকের প্রস্তাবিত সেবা</h2>
        <span class="disclaimer-note" style="display:block;margin-bottom:16px;">এই ওয়েবসাইটের প্রস্তাবিত সেবা — এগুলো শাস্ত্রীয় অবশ্যকরণীয় আচার নয়</span>
        <div class="grid grid-3">
            <?php foreach ($sevas as $s): ?>
                <div class="card seva-card"><div class="card-body">
                    <strong><?= e($s['title_bn']) ?></strong>
                    <div class="meta">
                        <span class="tag tag-difficulty-<?= $s['difficulty'] === 'সহজ' ? 'easy' : ($s['difficulty'] === 'মাঝারি' ? 'medium' : 'hard') ?>"><?= e($s['difficulty']) ?></span>
                    </div>
                    <a href="<?= url('/seva/' . $s['slug']) ?>" class="btn btn-outline btn-sm">বিস্তারিত</a>
                </div></div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($childrenActivities) || !empty($familyActivities)): ?>
    <section class="section" style="padding:0 0 28px;">
        <div class="grid grid-2">
            <?php if (!empty($childrenActivities)): ?>
            <div><h3>শিশু কার্যক্রম</h3>
                <?php foreach ($childrenActivities as $c): ?><p>• <?= e($c['title']) ?></p><?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($familyActivities)): ?>
            <div><h3>পরিবার কার্যক্রম</h3>
                <?php foreach ($familyActivities as $f): ?><p>• <?= e($f['title_bn']) ?></p><?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($relatedArticles)): ?>
    <section class="section" style="padding:0 0 28px;">
        <h2>সম্পর্কিত নিবন্ধ</h2>
        <div class="grid grid-3">
            <?php foreach ($relatedArticles as $a): ?>
                <a href="<?= url('/articles/' . $a['slug']) ?>" class="card article-card">
                    <div class="card-body"><strong><?= e($a['title_bn']) ?></strong></div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <nav class="flex justify-between" style="border-top:1px solid var(--color-border);padding-top:20px;">
        <?php if ($prev): ?>
            <a href="<?= url('/navadurga/' . $prev['slug']) ?>">← <?= e($prev['name_bn']) ?></a>
        <?php else: ?><span></span><?php endif; ?>
        <?php if ($next): ?>
            <a href="<?= url('/navadurga/' . $next['slug']) ?>"><?= e($next['name_bn']) ?> →</a>
        <?php endif; ?>
    </nav>
</article>
