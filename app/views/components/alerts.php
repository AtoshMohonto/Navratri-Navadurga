<?php
$__success = flash('success');
$__error = flash('error');
?>
<?php if ($__success): ?>
    <div class="alert alert-success"><?= e($__success) ?></div>
<?php endif; ?>
<?php if ($__error): ?>
    <div class="alert alert-error"><?= e($__error) ?></div>
<?php endif; ?>
