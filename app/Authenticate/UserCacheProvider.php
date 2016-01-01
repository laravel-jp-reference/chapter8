<?php

namespace App\Authenticate;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Cache\Repository as CacheContract;

/**
 * Class UserCacheProvider
 * データベースとキャッシュを併用して認証を行います
 *
 * このクラスは、Laravelで利用されているEloquentORMを利用する認証ドライバを継承しています
 */
class UserCacheProvider extends EloquentUserProvider
{
    /** @var CacheContract */
    protected $cache;

    /**
     * @param HasherContract $hasher
     * @param string         $model
     * @param CacheContract  $cache
     */
    public function __construct(
        HasherContract $hasher,
        $model,
        CacheContract $cache
    ) {
        parent::__construct($hasher, $model);
        $this->cache = $cache;
    }

    /**
     * Authコンポーネントのuser()メソッドなどを利用した場合に実行されるメソッドです
     * デフォルトの場合、user()メソッドコール時に都度SQLが発行されますので、cacheを利用します。
     * ユーザー情報更新時などにcacheを再生成するように実装します。
     *
     * @param  mixed $identifier
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        /**
         * user:$identifier(user_id) としてキャッシュを検索し、
         * 見つからない場合は作成してデータベースから取得したデータを保持します
         * 以降はデータベースへアクセスしません
         */
        $cacheKey = "user:{$identifier}";
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        $result = $this->createModel()->newQuery()->find($identifier);
        if (is_null($result)) {
            return null;
        }
        $this->cache->add($cacheKey, $result, 120);

        return $result;
    }
}
