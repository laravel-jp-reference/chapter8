<?php
/**
 * 本アプリケーションで利用しているルートリストは、次のコマンドで確認できます。
 * $ php artisan route:list
 */
\Route::controller('auth', 'Auth\AuthController',
    [
        'postLogin'    => 'post.login',
        'getLogin'     => 'get.login',
        'getRegister'  => 'get.register',
        'postRegister' => 'post.register',
        'getLogout'    => 'logout'
    ]
);

\Route::group(['middleware' => 'auth'], function () {
    \Route::resource('admin/entry', 'Admin\EntryController', ['except' => ['destroy', 'show']]);
});

get('/', 'ApplicationController@index');
\Route::resource('entry', 'EntryController', ['only' => ['index', 'show']]);
\Route::resource('comment', 'CommentController', ['only' => ['store']]);
