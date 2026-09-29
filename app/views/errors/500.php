<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>সার্ভার সমস্যা — ৫০০</title>
<link rel="stylesheet" href="<?= function_exists('asset') ? asset('css/app.css') : '/assets/css/app.css' ?>">
</head>
<body class="error-page">
<div class="error-box">
    <div class="error-code">৫০০</div>
    <h1>দুঃখিত, একটি সমস্যা হয়েছে</h1>
    <p>সার্ভারে সাময়িক একটি সমস্যা হয়েছে। কিছুক্ষণ পর আবার চেষ্টা করুন।</p>
    <a class="btn btn-primary" href="<?= function_exists('url') ? url('/') : '/' ?>">হোমপেজে ফিরে যান</a>
</div>
</body>
</html>
