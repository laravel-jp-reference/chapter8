@extends('layouts.entry')
@section('content')
    <div class="blog-header">
        <h1 class="blog-title">サンプルアプリケーションについて</h1>
        <p class="lead blog-description">Laravelリファレンス / サンプルアプリケーション</p>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">MailCatcher</h3>
        </div>
        <div class="panel-body">
            本アプリケーションのHomestead(Vagrant)にはMailCatcherが同梱しています。<br />
            MailCatcherがSMTPサーバーとして動作し、実際にはメールは送信されません。<br />
            メール送信の確認については<a href="http://homestead.app:1080/" target="_blank">こちらから確認いただけます</a>
        </div>
    </div>
    <h2>URIガイド</h2>
    <table class="table table-striped">
        <tr>
            <th>HTTPメソッド</th>
            <th>URI</th>
            <th>Description</th>
        </tr>
        @foreach($list as $row)
            <tr>
                <td>{{{ $row['method'] }}}</td>
                <td>{{{ $row['uri'] }}}</td>
                <td>{{{ $row['action'] }}}</td>
            </tr>
        @endforeach
    </table>
@stop
