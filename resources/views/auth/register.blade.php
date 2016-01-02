@extends('layouts.default')
@section('content')
    <div class="row">
        <h2 class="form-signin-heading">ユーザー登録</h2>
        <form method="post" action="{{{ route('post.register') }}}">
            {!! csrf_field() !!}
            <div class="form-group @if($errors->first('name'))has-error @endif">
                <label class="control-label" for="name">名前 {{{ $errors->first('name') }}}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="名前を入力してください"
                       value="{{ old('name') }}">
            </div>
            <div class="form-group @if($errors->first('email'))has-error @endif">
                <label class="control-label" for="email">メールアドレス {{{ $errors->first('email') }}}</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="メールアドレスを入力してください"
                       value="{{ old('email') }}">
            </div>
            <div class="form-group @if($errors->first('password'))has-error @endif">
                <label class="control-label" for="password">パスワード {{{ $errors->first('password') }}}</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="パスワードを入力してください">
            </div>
            <div class="form-group">
                <label for="password_confirmation">もう一度パスワードを入力してください</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                       placeholder="もう一度パスワードを入力してください">
            </div>
            <img src="{!! captcha() !!}"/>

            <div class="form-group @if($errors->first('captcha_code'))has-error @endif">
                <label class="control-label" for="captcha_code">画像認証 {{{ $errors->first('captcha_code') }}}</label>
                <input type="text" class="form-control" name="captcha_code" id="captcha_code"
                       placeholder="画像に表示されている文字を入力してください"/>
            </div>
            <button type="submit" class="btn btn-success" name="submit">アカウント作成</button>
        </form>
    </div>
@stop
