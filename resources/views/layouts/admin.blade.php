<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,noarchive,nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Laravel リファレンス / ブログ管理')</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/admin.css" rel="stylesheet">
    <link rel="apple-touch-icon" href="/favicon.png">
    <link rel="icon" href="/favicon.png">
    @yield('styles')
</head>
<body>
<!-- Navbar goes here -->
@include('elements.admin.header')
<div class="container">
    <div class="row">
        @yield('content')
    </div>
</div>
@include('elements.admin.footer')
@yield('scripts')
</body>
</html>
