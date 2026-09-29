<?php
$old = flash('old') ?? [];
function fval($item, $old, $key) {
    return $old[$key] ?? $item[$key] ?? '';
}
$action = $isEdit ? url("/{$routeBase}/{$item['id']}/update") : url("/{$routeBase}");
?>
<h1><?= $isEdit ? 'সম্পাদনা করুন' : 'নতুন যোগ করুন' ?> — <?= e($title) ?></h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <ul style="margin:0;padding-left:18px;">
        <?php foreach ($errors as $fieldErrors): foreach ($fieldErrors as $err): ?>
            <li><?= e($err) ?></li>
        <?php endforeach; endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST" action="<?= $action ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php foreach ($fields as $field): $val = fval($item, $old, $field['key']); ?>
        <div class="form-group">
            <label for="f_<?= e($field['key']) ?>"><?= e($field['label']) ?><?= !empty($field['required']) ? ' *' : '' ?></label>

            <?php if ($field['type'] === 'textarea'): ?>
                <textarea class="form-control" id="f_<?= e($field['key']) ?>" name="<?= e($field['key']) ?>"><?= e($val) ?></textarea>

            <?php elseif ($field['type'] === 'select'): ?>
                <select class="form-control" id="f_<?= e($field['key']) ?>" name="<?= e($field['key']) ?>">
                    <option value="">— নির্বাচন করুন —</option>
                    <?php foreach ($field['options'] as $optValue => $optLabel): ?>
                        <option value="<?= e($optValue) ?>" <?= (string) $val === (string) $optValue ? 'selected' : '' ?>><?= e($optLabel) ?></option>
                    <?php endforeach; ?>
                </select>

            <?php elseif ($field['type'] === 'checkbox'): ?>
                <div class="checkbox-row">
                    <input type="checkbox" id="f_<?= e($field['key']) ?>" name="<?= e($field['key']) ?>" value="1" <?= $val ? 'checked' : '' ?>>
                    <label for="f_<?= e($field['key']) ?>" style="margin:0;">সক্রিয়</label>
                </div>

            <?php elseif ($field['type'] === 'image'): ?>
                <?php if (!empty($item[$field['key']])): ?>
                    <img src="<?= e(url($item[$field['key']])) ?>" alt="" style="width:90px;height:90px;object-fit:cover;border-radius:8px;margin-bottom:8px;">
                <?php endif; ?>
                <input type="file" class="form-control" id="f_<?= e($field['key']) ?>" name="<?= e($field['key']) ?>" accept="image/*">

            <?php elseif ($field['type'] === 'number'): ?>
                <input type="number" class="form-control" id="f_<?= e($field['key']) ?>" name="<?= e($field['key']) ?>" value="<?= e($val) ?>">

            <?php elseif ($field['type'] === 'date'): ?>
                <input type="date" class="form-control" id="f_<?= e($field['key']) ?>" name="<?= e($field['key']) ?>" value="<?= e($val) ?>">

            <?php else: ?>
                <input type="text" class="form-control" id="f_<?= e($field['key']) ?>" name="<?= e($field['key']) ?>" value="<?= e($val) ?>">
            <?php endif; ?>

            <?php if (!empty($field['hint'])): ?><div class="form-hint"><?= e($field['hint']) ?></div><?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="flex gap-12">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'আপডেট করুন' : 'সংরক্ষণ করুন' ?></button>
        <a href="<?= url("/{$routeBase}") ?>" class="btn btn-ghost">বাতিল</a>
    </div>
</form>
</div>
</div>
