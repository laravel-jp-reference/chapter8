<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ViewServiceProvider
 *
 * 本サンプルアプリケーションでは、view composerの登録に利用しています
 */
class ViewServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        /** elements.admin.header描画時にApp\Composers\UserComposerのcomposerメソッドが実行されます */
        $this->app['view']->composer('elements.admin.header', \App\Composers\UserComposer::class);
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // any
    }
}
