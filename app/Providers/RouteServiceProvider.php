<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class RouteServiceProvider
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * {@inheritdoc}
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {
            // Http/routes.phpが読み込まれ、ルートが有効になります
            require app_path('Http/routes.php');
            /**
             * パッケージなどでルートを含ませる場合は、
             * パッケージのサービスプロバイダなどを用いてルートの定義を記述しておくことができます
             *
            $router->controller('auth', 'Auth\AuthController',
                [
                    'postLogin'    => 'post.login',
                    'getLogin'     => 'get.login',
                    'getRegister'  => 'get.register',
                    'postRegister' => 'post.register',
                    'getLogout'    => 'logout'
                ]
            );

            $router->group(['middleware' => 'auth'], function (Router $router) {
                $router->resource('admin/entry', 'Admin\EntryController', ['except' => ['destroy', 'show']]);
            });

            $router->get('/', 'ApplicationController@index');
            $router->resource('entry', 'EntryController', ['only' => ['index', 'show']]);
            $router->resource('comment', 'CommentController', ['only' => ['store']]);
            */
        });
    }
}
