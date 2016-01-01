<?php

namespace App\Providers;

use App\Authenticate\UserCacheProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class DriverServiceProvider
 *
 * 書籍内では各機能ごとにサービスプロバイダクラスを作成して解説していますが、
 * AuthServiceProviderクラスを用いて記述しても構いません
 */
class DriverServiceProvider extends ServiceProvider
{
    /**
     * boot register
     */
    public function boot()
    {
        $this->app['auth']->extend('auth_cache', function () {
            $model = $this->app['config']['auth.model'];
            return new UserCacheProvider(
                $this->app['hash'], $model, $this->app['cache.store']
            );
        });
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // このサービスプロバイダでは利用しません
    }
}
