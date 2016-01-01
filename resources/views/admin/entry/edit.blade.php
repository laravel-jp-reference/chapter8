@extends('layouts.admin')
@section('content')
    <form method="POST" action="{{{ route('admin.entry.update', [$id]) }}}">
        {!! method_field('put') !!}
        {!! csrf_field() !!}
        <div class="form-group @if($errors->first('title'))has-error @endif">
            <label class="control-label" for="name">タイトル {{{ $errors->first('title') }}}</label>
            <input type="text" class="form-control" id="title" name="title"
                placeholder="タイトルを入力してください" value="{{{ old('title', $entry->title) }}}">
        </div>
        <div class="form-group @if($errors->first('body'))has-error @endif">
            <label class="control-label" for="body">本文 {{{ $errors->first('body') }}}</label>
            <textarea class="form-control" name="body" id="body"
                placeholder="本文を入力してください" rows="20">{{{ old('body', $entry->body) }}}</textarea>
        </div>
        <button type="submit" class="btn btn-success">記事を編集</button>
    </form>
@stop
