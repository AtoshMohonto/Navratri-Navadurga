<h1>আমার বুকমার্ক</h1>

<?php if (empty($items)): ?>
    <div class="empty-state"><div class="icon">🔖</div><p>এখনও কোনো বুকমার্ক নেই।</p></div>
<?php else: ?>
<ul class="checklist">
    <?php foreach ($items as $item): ?>
        <li class="checklist-item"><a href="<?= url($item['url']) ?>"><?= e($item['title']) ?></a></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
