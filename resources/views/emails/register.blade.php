<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="container">
    <div class="content">
        {{{ $user['name'] }}} さん<br/>
        新規ユーザー登録が完了しました。<br/>
        ログインはこちらから {{{ route('get.login') }}}<br/>
    </div>
</div>
</body>
</html>
