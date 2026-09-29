<h1 class="text-center">প্রশ্নোত্তর</h1>
<p class="section-subtitle">নবদুর্গা, নবরাত্রি, পূজা ও সেবা সম্পর্কে সাধারণ প্রশ্নের উত্তর।</p>

<div style="max-width:760px;margin:0 auto;">
<?php foreach ($grouped as $category => $items): ?>
    <h2 style="margin-top:32px;"><?= e($category) ?></h2>
    <?php foreach ($items as $faq): ?>
        <details class="card" style="margin-bottom:10px;">
            <summary style="padding:16px 20px;cursor:pointer;font-weight:600;"><?= e($faq['question_bn']) ?></summary>
            <div class="card-body" style="padding-top:0;">
                <p class="mb-0"><?= nl2br(e($faq['answer_bn'])) ?></p>
            </div>
        </details>
    <?php endforeach; ?>
<?php endforeach; ?>
</div>
