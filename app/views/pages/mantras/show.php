<article style="max-width:700px;margin:0 auto;">
    <header class="text-center" style="margin-bottom:20px;">
        <?php if ($item['associated_day']): ?><span class="day-badge">দিন <?= bn_digits($item['associated_day']) ?></span><?php endif; ?>
        <h1><?= e($item['title_bn']) ?></h1>
        <?php if ($item['associated_deity']): ?><p class="text-muted">সম্পর্কিত: <?= e($item['associated_deity']) ?></p><?php endif; ?>
    </header>

    <div class="flex gap-8 justify-between" style="margin-bottom:12px;flex-wrap:wrap;">
        <div class="flex gap-8">
            <button class="btn btn-ghost btn-sm" id="font-decrease" aria-label="লেখা ছোট করুন">A−</button>
            <button class="btn btn-ghost btn-sm" id="font-increase" aria-label="লেখা বড় করুন">A+</button>
        </div>
        <div class="flex gap-8">
            <button class="btn btn-ghost btn-sm" id="copy-mantra">কপি করুন</button>
            <button class="btn btn-ghost btn-sm" data-print>প্রিন্ট করুন</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <p id="mantra-sanskrit" style="font-family:var(--font-heading);font-size:1.4rem;line-height:2;"><?= nl2br(e($item['sanskrit'])) ?></p>
        </div>
    </div>

    <?php if ($item['transliteration']): ?>
    <section style="margin-top:20px;">
        <h3>প্রতিবর্ণীকরণ</h3>
        <p class="text-muted"><?= nl2br(e($item['transliteration'])) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['pronunciation_bn']): ?>
    <section style="margin-top:20px;">
        <h3>বাংলা উচ্চারণ</h3>
        <p><?= nl2br(e($item['pronunciation_bn'])) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['meaning_bn']): ?>
    <section style="margin-top:20px;">
        <h3>অর্থ</h3>
        <p><?= nl2br(e($item['meaning_bn'])) ?></p>
    </section>
    <?php endif; ?>

    <?php if ($item['audio_url']): ?>
    <section style="margin-top:20px;">
        <h3>উচ্চারণ শুনুন</h3>
        <audio controls src="<?= e($item['audio_url']) ?>" style="width:100%;"></audio>
    </section>
    <?php endif; ?>

    <?php if ($item['source']): ?>
    <p class="text-muted" style="font-size:0.8rem;margin-top:20px;">উৎস: <?= e($item['source']) ?></p>
    <?php else: ?>
    <p class="disclaimer-note" style="margin-top:20px;">উৎস উল্লেখ যাচাইযোগ্যভাবে পাওয়া যায়নি; ঐতিহ্যভেদে পাঠের পার্থক্য থাকতে পারে।</p>
    <?php endif; ?>
</article>

<script>
(function () {
    var el = document.getElementById('mantra-sanskrit');
    var size = 1.4;
    document.getElementById('font-increase').addEventListener('click', function () { size = Math.min(size + 0.15, 2.4); el.style.fontSize = size + 'rem'; });
    document.getElementById('font-decrease').addEventListener('click', function () { size = Math.max(size - 0.15, 0.9); el.style.fontSize = size + 'rem'; });
    document.getElementById('copy-mantra').addEventListener('click', function () {
        var text = el.innerText;
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text);
            this.textContent = 'কপি হয়েছে ✓';
            var btn = this;
            setTimeout(function () { btn.textContent = 'কপি করুন'; }, 1500);
        }
    });
})();
</script>
