<?php

namespace App\Providers;

use App\DataAccess\Cache\DataCache;
use App\Http\Validators\CustomValidator;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Validatorでクラスとしてカスタムバリデータを追加します
         * Validatorファサードを用いた表記と同じです
         */
        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            return new CustomValidator($translator, $data, $rules, $messages, $customAttributes);
        });
        /**
         * Validatorファサードを利用した記述方法
        \Validator::resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            return new CustomValidator($translator, $data, $rules, $messages, $customAttributes);
        });
         **/
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        /**
         * インターフェースと具象クラスを束縛(バインド)します
         * これにより、インターフェースをタイプヒンティングするだけで具象クラスのインスタンスが取得できます。
         */
        $this->app->bind(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
        $this->app->bind(
            \App\Repositories\EntryRepositoryInterface::class,
            function ($app) {
                return new \App\Repositories\EntryRepository(
                    new \App\DataAccess\Eloquent\Entry,
                    new DataCache($app['cache'], 'entry', 120)
                );
            }
        );
        $this->app->bind(
            \App\Repositories\CommentRepositoryInterface::class,
            function ($app) {
                return new \App\Repositories\CommentRepository(
                    new \App\DataAccess\Eloquent\Comment,
                    new DataCache($app['cache'], 'comment', 120)
                );
            }
        );
    }
}
