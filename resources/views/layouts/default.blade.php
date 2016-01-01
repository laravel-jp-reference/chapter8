<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name=”robots” content=”noindex,noarchive,nofollow”>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('description', config('blog.description'))">
    <meta name="keywords" content="@yield('keywords', config('blog.keywords'))"/>
    <title>@yield('title', config('blog.title', 'Blog'))</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/login.css" rel="stylesheet">
    <link rel="apple-touch-icon" href="/favicon.png">
    <link rel="icon" href="/favicon.png">
    @yield('styles')
</head>
<body>
<div class="container">
    <div class="row">
        @yield('content')
    </div>
</div>
@yield('scripts')
</body>
</html>
