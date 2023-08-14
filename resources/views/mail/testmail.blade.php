<!DOCTYPE html>
<html>
<head>
    <title>Sample Mail</title>
</head>
<body>
    <h1>Sample Mail</h1>
    <!--<h1><p>User Mail Format: {{ $userMailFormat }}</p></h1>-->
    <p>{{ $userMailFormat }}</p>
    <p>以下のリンクをクリックしてください:</p>
    <a href="{{ $url_link }}">{{ $url_link }}</a>
</body>
</html>