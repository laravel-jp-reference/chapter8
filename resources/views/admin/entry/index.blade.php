@extends('layouts.admin')
@section('content')
    <h1>ブログエントリ</h1>
    <div>
        <a href="{{{ route('admin.entry.create') }}}" class="btn btn-primary">ブログを投稿する</a>
    </div>
    @if(session('message'))
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            {{{ session('message') }}}
        </div>
    @endif
    <table class="table">
        <tr>
            <th>タイトル</th>
            <th>本文</th>
            <th></th>
        </tr>
        @forelse($page as $row)
        <tr>
            <td>{{{ $row->title }}}</td>
            <td>{{{ mb_strimwidth(strip_tags($row->body), 0, 30, "...") }}}</td>
            <td><a href="{{{ route('admin.entry.edit', [$row->id]) }}}">編集</a></td>
        </tr>
        @empty
        <tr>
            <td colspan="3">ブログ記事がありません</td>
        </tr>
        @endforelse
    </table>
    {!! $page->render() !!}
@stop
