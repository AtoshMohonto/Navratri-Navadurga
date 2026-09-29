<div style="max-width:480px;margin:0 auto;">
    <h1 class="text-center">প্রোফাইল</h1>
    <div class="card"><div class="card-body">
        <form method="POST" action="<?= url('/profile') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="name">নাম</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= e($user['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">ইমেইল</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= e($user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="new_password">নতুন পাসওয়ার্ড (ঐচ্ছিক)</label>
                <input type="password" class="form-control" id="new_password" name="new_password" minlength="8">
                <div class="form-hint">পরিবর্তন না করতে চাইলে ফাঁকা রাখুন।</div>
            </div>
            <button type="submit" class="btn btn-primary w-full">হালনাগাদ করুন</button>
        </form>
    </div></div>
</div>
