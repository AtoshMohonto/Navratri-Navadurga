<div style="max-width:420px;margin:0 auto;">
    <h1 class="text-center">লগইন</h1>
    <div class="card"><div class="card-body">
        <form method="POST" action="<?= url('/login') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="email">ইমেইল</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">পাসওয়ার্ড</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-full">লগইন করুন</button>
        </form>
        <p class="text-center text-muted" style="margin-top:16px;">অ্যাকাউন্ট নেই? <a href="<?= url('/register') ?>">নিবন্ধন করুন</a></p>
    </div></div>
</div>
