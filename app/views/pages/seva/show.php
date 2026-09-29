<article style="max-width:760px;margin:0 auto;">
    <header class="text-center" style="margin-bottom:24px;">
        <span class="tag"><?= e($item['category']) ?></span>
        <h1><?= e($item['title_bn']) ?></h1>
        <?php if ($item['title_en']): ?><p class="text-muted"><?= e($item['title_en']) ?></p><?php endif; ?>
    </header>

    <p><?= nl2br(e($item['description'])) ?></p>

    <div class="card" style="margin-bottom:24px;">
        <div class="card-body">
            <table style="width:100%;font-size:0.95rem;">
                <tr><td class="text-muted" style="padding:6px 0;width:40%;">সময়</td><td style="padding:6px 0;"><?= e($item['time_required'] ?: '—') ?></td></tr>
                <tr><td class="text-muted" style="padding:6px 0;">আনুমানিক খরচ</td><td style="padding:6px 0;"><?= e($item['estimated_cost'] ?: '—') ?></td></tr>
                <tr><td class="text-muted" style="padding:6px 0;">কাদের উপকার</td><td style="padding:6px 0;"><?= e($item['beneficiary'] ?: $item['category']) ?></td></tr>
                <tr><td class="text-muted" style="padding:6px 0;">কঠিনতার মাত্রা</td><td style="padding:6px 0;"><span class="tag tag-difficulty-<?= $item['difficulty'] === 'সহজ' ? 'easy' : ($item['difficulty'] === 'মাঝারি' ? 'medium' : 'hard') ?>"><?= e($item['difficulty']) ?></span></td></tr>
                <?php if ($item['materials']): ?><tr><td class="text-muted" style="padding:6px 0;">প্রয়োজনীয় সামগ্রী</td><td style="padding:6px 0;"><?= e($item['materials']) ?></td></tr><?php endif; ?>
                <?php if ($item['impact_level']): ?><tr><td class="text-muted" style="padding:6px 0;">প্রভাবের মাত্রা</td><td style="padding:6px 0;"><?= e($item['impact_level']) ?></td></tr><?php endif; ?>
            </table>
        </div>
    </div>

    <?php if ($item['how_to']): ?>
    <section style="margin-bottom:24px;">
        <h2>কীভাবে করবেন</h2>
        <p><?= nl2br(e($item['how_to'])) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['safety_note']): ?>
    <p class="disclaimer-note" style="margin-bottom:24px;"><strong>দ্রষ্টব্য:</strong> <?= e($item['safety_note']) ?></p>
    <?php endif; ?>

    <div class="card" style="background:var(--color-surface-alt);">
        <div class="card-body">
            <?php if (is_logged_in()): ?>
                <form method="POST" action="<?= url('/seva/' . $item['slug'] . '/complete') ?>">
                    <?= csrf_field() ?>
                    <div class="form-group"><label>মন্তব্য (ঐচ্ছিক)</label><textarea name="note" class="form-control" placeholder="আপনি কীভাবে এই সেবাটি করলেন..."></textarea></div>
                    <button type="submit" class="btn btn-primary">আমি এই সেবাটি সম্পন্ন করেছি</button>
                </form>
            <?php else: ?>
                <p class="mb-0">এই সেবাটি সম্পন্ন হিসেবে রেকর্ড করতে <a href="<?= url('/login') ?>">লগইন করুন</a>।</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="text-center" style="margin-top:24px;">
        <a href="<?= url('/seva') ?>" class="btn btn-ghost btn-sm">← সব সেবা দেখুন</a>
        <button class="btn btn-outline btn-sm" data-print>প্রিন্ট করুন</button>
    </div>
</article>
