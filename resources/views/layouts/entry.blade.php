<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="index">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('description', config('blog.description'))">
    <meta name="keywords" content="@yield('keywords', config('blog.keywords'))"/>
    <title>@yield('title', config('blog.title', 'Blog'))</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="apple-touch-icon" href="/favicon.png">
    <link rel="icon" href="/favicon.png">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('styles')
</head>
<body>
<!-- Navbar goes here -->
@include('elements.entry.header')
<div class="container">
    <div class="row">
        @yield('content')
    </div>
</div>
@include('elements.entry.footer')
<script src="/js/jquery/jquery.min.js"></script>
<script src="/js/bootstrap/bootstrap.min.js"></script>
@yield('scripts')
</body>
</html>
