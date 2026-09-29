<div style="max-width:720px;margin:0 auto;">
    <h1 class="text-center">অনুসন্ধান</h1>
    <form method="GET" action="<?= url('/search') ?>" style="margin-bottom:32px;">
        <div class="flex gap-8">
            <input type="text" name="q" value="<?= e($q) ?>" class="form-control" placeholder="নবদুর্গা, নিবন্ধ, সেবা, মন্ত্র খুঁজুন..." autofocus>
            <button type="submit" class="btn btn-primary">খুঁজুন</button>
        </div>
    </form>

    <?php if ($q === ''): ?>
        <p class="text-muted text-center">অনুসন্ধান করতে উপরে কিছু লিখুন।</p>
    <?php elseif ($total === 0): ?>
        <div class="empty-state"><div class="icon">🔍</div><p>"<?= e($q) ?>" এর জন্য কোনো ফলাফল পাওয়া যায়নি।</p></div>
    <?php else: ?>
        <?php
        $sections = [
            'navadurga' => ['label' => 'নবদুর্গা', 'url' => '/navadurga/', 'field' => 'name_bn', 'slugField' => 'slug'],
            'articles' => ['label' => 'নিবন্ধ', 'url' => '/articles/', 'field' => 'title_bn', 'slugField' => 'slug'],
            'seva' => ['label' => 'সেবা', 'url' => '/seva/', 'field' => 'title_bn', 'slugField' => 'slug'],
            'mantras' => ['label' => 'মন্ত্র', 'url' => '/mantras/', 'field' => 'title_bn', 'slugField' => 'slug'],
            'puja_items' => ['label' => 'পূজা সামগ্রী', 'url' => '/puja-items', 'field' => 'name_bn', 'slugField' => null],
            'faq' => ['label' => 'প্রশ্নোত্তর', 'url' => '/faq', 'field' => 'question_bn', 'slugField' => null],
        ];
        ?>
        <?php foreach ($sections as $key => $meta): if (empty($results[$key])) continue; ?>
            <section style="margin-bottom:28px;">
                <h3><?= e($meta['label']) ?></h3>
                <ul style="list-style:none;padding:0;">
                    <?php foreach ($results[$key] as $row): ?>
                        <li style="padding:8px 0;border-bottom:1px solid var(--color-border);">
                            <?php if ($meta['slugField']): ?>
                                <a href="<?= url($meta['url'] . $row[$meta['slugField']]) ?>"><?= e($row[$meta['field']]) ?></a>
                            <?php else: ?>
                                <a href="<?= url($meta['url']) ?>"><?= e($row[$meta['field']]) ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
