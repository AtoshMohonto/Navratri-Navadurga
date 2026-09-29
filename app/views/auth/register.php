<div style="max-width:420px;margin:0 auto;">
    <h1 class="text-center">নিবন্ধন</h1>
    <div class="card"><div class="card-body">
        <form method="POST" action="<?= url('/register') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="name">নাম</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">ইমেইল</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
            </div>
            <div class="form-group">
                <label for="password">পাসওয়ার্ড</label>
                <input type="password" class="form-control" id="password" name="password" required minlength="8">
                <div class="form-hint">কমপক্ষে ৮ অক্ষরের হতে হবে।</div>
            </div>
            <div class="form-group">
                <label for="password_confirmation">পাসওয়ার্ড নিশ্চিত করুন</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8">
            </div>
            <button type="submit" class="btn btn-primary w-full">নিবন্ধন করুন</button>
        </form>
        <p class="text-center text-muted" style="margin-top:16px;">আগে থেকেই অ্যাকাউন্ট আছে? <a href="<?= url('/login') ?>">লগইন করুন</a></p>
    </div></div>
</div>
