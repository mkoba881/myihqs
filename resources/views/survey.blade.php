<!DOCTYPE html>
<html>
<head>
    <title>アンケート画面</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}"> <!-- admin.cssを外部参照 -->
</head>
<body class="home-page">
    <div class="container welcome-container">
        <h1 class="welcome-text">社内アンケートにようこそ！</h1>
        <p>楽しみながらアンケートに参加しましょう。皆様のご意見で社内システムが改善されます。</p>
        <a href="{{ route('admin.ihqs.selection') }}" class="button">アンケートを開始する</a>
    </div>
</body>
</html>
