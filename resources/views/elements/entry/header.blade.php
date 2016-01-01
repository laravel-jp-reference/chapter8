<div class="blog-masthead">
    <div class="container">
        <nav class="blog-nav">
            <a class="blog-nav-item @if(Request::is('/'))active @endif" href="/">HOME</a>
            <a class="blog-nav-item @if(Request::is('entry*'))active @endif" href="{{{ route('entry.index') }}}">BLOG</a>
            <a class="btn btn-success" href="{{{ route('get.login') }}}">LOGIN</a>
        </nav>
    </div>
</div>
