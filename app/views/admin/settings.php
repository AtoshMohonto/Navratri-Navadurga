<h1>সেটিংস</h1>
<div class="card">
<div class="card-body">
<form method="POST" action="<?= url('/admin/settings') ?>">
    <?= csrf_field() ?>
    <?php foreach ($keys as $key => $label): ?>
        <div class="form-group">
            <label for="s_<?= e($key) ?>"><?= e($label) ?></label>
            <?php if (in_array($key, ['site_description', 'footer_text'])): ?>
                <textarea class="form-control" id="s_<?= e($key) ?>" name="<?= e($key) ?>"><?= e($values[$key] ?? '') ?></textarea>
            <?php else: ?>
                <input type="text" class="form-control" id="s_<?= e($key) ?>" name="<?= e($key) ?>" value="<?= e($values[$key] ?? '') ?>">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
</form>
</div>
</div>
