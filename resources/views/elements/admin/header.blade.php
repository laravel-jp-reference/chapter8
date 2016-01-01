<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <a class="navbar-brand navbar-left" href="/">ブログ管理</a>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li @if(Request::is('admin/entry'))class="active" @endif>
                    <a href="{{{ route('admin.entry.index') }}}">blog</a>
                </li>
                <li><a href="{{{ route('logout') }}}">logout</a></li>
                <li><a href="#">ログイン:{{{ $user->name }}}</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
