<?php if (!empty($breadcrumbs)): ?>
<nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="<?= url('/') ?>">হোম</a>
    <?php foreach ($breadcrumbs as $i => $crumb): ?>
        <span class="sep">/</span>
        <?php if (!empty($crumb['url']) && $i < count($breadcrumbs) - 1): ?>
            <a href="<?= url($crumb['url']) ?>"><?= e($crumb['label']) ?></a>
        <?php else: ?>
            <span><?= e($crumb['label']) ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
<?php endif; ?>
