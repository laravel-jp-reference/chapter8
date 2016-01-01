<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class LocalServiceProvider
 *
 * 開発などで環境をlocalとして実行する場合にのみ登録するサービスプロバイダがまとまっています
 */
class LocalServiceProvider extends ServiceProvider
{
    /** @var array */
    protected $providers = [
        // ideヘルパー
        'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider'
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->registerServiceProviders();
        }
    }

    /**
     * register local service providers
     */
    protected function registerServiceProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}
