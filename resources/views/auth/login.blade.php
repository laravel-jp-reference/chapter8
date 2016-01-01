@extends('layouts.default')
@section('content')
    @if(session('message'))
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        {{{ session('message') }}}
    </div>
    @endif
    <form class="form-signin" method="post" action="{{{ route('post.login') }}}">
        <h2 class="form-signin-heading">ログイン</h2>
        {!! csrf_field() !!}
        <label for="inputEmail" class="sr-only">メールアドレス {{{ $errors->first('email') }}}</label>
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="メールアドレスを入力してください"
               value="{{{ old('email') }}}" required autofocus>
        <label for="inputPassword" class="sr-only">パスワード {{{ $errors->first('password') }}}</label>
        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="パスワードを入力してください"
               required>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" value="1">ログイン状態を保存
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
        <a href="{{{ route('get.register') }}}">アカウント作成はこちら</a>
    </form>
@stop
