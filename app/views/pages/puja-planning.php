<h1 class="text-center">পূজা পরিকল্পনা</h1>
<p class="section-subtitle">নবরাত্রি পূজার প্রস্তুতির জন্য ধাপে ধাপে চেকলিস্ট। <?= is_logged_in() ? 'আপনার অগ্রগতি স্বয়ংক্রিয়ভাবে সংরক্ষিত হচ্ছে।' : 'লগইন করলে আপনার অগ্রগতি সংরক্ষিত থাকবে; এখন এই ব্রাউজারেই সংরক্ষিত হচ্ছে।' ?></p>

<?php
$phaseLabels = ['before' => 'নবরাত্রির আগে', 'day' => 'প্রতিদিনের জন্য', 'dashami' => 'দশমীর প্রস্তুতি'];
$totalItems = count($grouped['before']) + count($grouped['day']) + count($grouped['dashami']);
?>

<div class="progress-bar"><div class="progress-bar-fill" id="checklist-progress" style="width:0%;"></div></div>
<p class="text-center text-muted" id="checklist-progress-label">অগ্রগতি লোড হচ্ছে...</p>

<?php foreach ($phaseLabels as $phase => $label): if (empty($grouped[$phase])) continue; ?>
<section class="section" style="padding-top:0;">
    <h2><?= e($label) ?></h2>
    <ul class="checklist" data-checklist-group>
        <?php foreach ($grouped[$phase] as $item):
            $completed = ($statuses[$item['id']] ?? 'not_started') === 'completed';
        ?>
            <li class="checklist-item <?= $completed ? 'completed' : '' ?>" data-item-id="<?= $item['id'] ?>">
                <input type="checkbox" <?= $completed ? 'checked' : '' ?> aria-label="<?= e($item['label_bn']) ?>">
                <span><?= e($item['label_bn']) ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php endforeach; ?>

<div class="text-center" style="margin-top:20px;">
    <button class="btn btn-outline btn-sm" data-print>প্রিন্ট করুন</button>
</div>

<script>
(function () {
    var isLoggedIn = <?= is_logged_in() ? 'true' : 'false' ?>;
    var items = document.querySelectorAll('.checklist-item[data-item-id]');
    var total = items.length;

    function updateProgress() {
        var done = document.querySelectorAll('.checklist-item.completed').length;
        var pct = total ? Math.round((done / total) * 100) : 0;
        document.getElementById('checklist-progress').style.width = pct + '%';
        document.getElementById('checklist-progress-label').textContent = done + ' / ' + total + ' সম্পন্ন (' + pct + '%)';
    }

    if (!isLoggedIn && window.navadurgaLocalChecklist) {
        var saved = window.navadurgaLocalChecklist.getAll();
        items.forEach(function (li) {
            var id = li.getAttribute('data-item-id');
            if (saved[id]) {
                li.classList.add('completed');
                li.querySelector('input').checked = true;
            }
        });
    }

    items.forEach(function (li) {
        li.addEventListener('click', function (e) {
            if (e.target.tagName !== 'INPUT') e.preventDefault();
            var id = li.getAttribute('data-item-id');
            var willComplete = !li.classList.contains('completed');
            li.classList.toggle('completed');
            li.querySelector('input').checked = willComplete;

            if (isLoggedIn) {
                window.navadurgaPost('<?= url('/api/checklist/toggle') ?>', { item_id: id });
            } else if (window.navadurgaLocalChecklist) {
                window.navadurgaLocalChecklist.toggle(id);
            }
            updateProgress();
        });
    });

    updateProgress();
})();
</script>
