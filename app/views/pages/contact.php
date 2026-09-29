<div style="max-width:560px;margin:0 auto;">
    <h1 class="text-center">যোগাযোগ</h1>
    <p class="section-subtitle">প্রশ্ন, পরামর্শ বা সংশোধনের জন্য আমাদের বার্তা পাঠান।</p>

    <div class="card"><div class="card-body">
        <form method="POST" action="<?= url('/contact') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="name">নাম</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
            </div>
            <div class="form-group">
                <label for="email">ইমেইল</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
            </div>
            <div class="form-group">
                <label for="message">বার্তা</label>
                <textarea class="form-control" id="message" name="message" required><?= old('message') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-full">বার্তা পাঠান</button>
        </form>
    </div></div>

    <p class="text-muted text-center" style="margin-top:20px;">অথবা সরাসরি ইমেইল করুন: <a href="mailto:<?= e(setting('contact_email', 'info@navadurga.local')) ?>"><?= e(setting('contact_email', 'info@navadurga.local')) ?></a></p>
</div>
