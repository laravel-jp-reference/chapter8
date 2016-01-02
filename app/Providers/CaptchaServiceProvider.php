<?php

namespace App\Providers;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\ServiceProvider;

/**
 * Class CaptchaServiceProvider
 *
 * $ php artisan make:provider CaptchaServiceProviderコマンドで作成したクラスです
 */
class CaptchaServiceProvider extends ServiceProvider
{
    /** @var bool $defer 遅延ロードを有効にします */
    protected $defer = true;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // インターフェースとのバインディングを記述します
        $this->app->singleton('Gregwar\Captcha\CaptchaBuilderInterface', function () {
            return new CaptchaBuilder();
        });
    }

    /**
     * 遅延ロードを行う場合は、サービスコンテナへの登録名を記述します
     *
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            'Gregwar\Captcha\CaptchaBuilderInterface',
        ];
    }
}
