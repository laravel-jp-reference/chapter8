<?php

use Mockery as m;

/**
 * Class UserCacheProviderTest
 *
 * UserCacheProviderTestクラスと異なり、sqliteインメモリデータベースを利用せずに
 * データベースによる返却値をモックしてテストしています
 *
 * @see \App\Authenticate\UserCacheProvider
 */
class UserCacheProviderNoDatabaseTest extends \TestCase
{
    /** @var \App\Authenticate\UserCacheProvider */
    protected $authProvider;

    public function setUp()
    {
        parent::setUp();
        $this->authProvider = m::mock('App\Authenticate\UserCacheProvider', [
            $this->app['hash'],
            $this->app['config']['auth.model'],
            $this->app['cache.store']
        ])->makePartial();
    }

    /**
     * ユーザーが見つからない場合はキャッシュを生成しないことをテスト
     */
    public function testRetrieveCacheFailed()
    {
        // メソッドチェーンは次のようにモックすることができます
        $this->authProvider->shouldReceive('createModel->newQuery->find')->andReturn(null);

        $this->assertNull($this->authProvider->retrieveById(1));
        $this->assertFalse(\Cache::has("user:1"));
    }

    public function testRetrieveWithCache()
    {
        $identifier = 1;
        $user = new stdClass;
        $user->id = $identifier;
        $this->authProvider->shouldReceive('createModel->newQuery->find')->andReturn($user);

        $this->assertNotNull($this->authProvider->retrieveById($identifier));
        $this->assertTrue(\Cache::has("user:{$identifier}"));
        $cache = \Cache::get("user:{$identifier}");
        $this->assertEquals($user->id, $cache->id);
    }

    public function testReturnWithCache()
    {
        $cacheMock = m::mock(\Illuminate\Contracts\Cache\Repository::class);
        $cacheMock->shouldReceive('has')->andReturn(true);
        $cacheMock->shouldReceive('get')->with("user:1")->andReturn('testing');
        $authProvider = new \App\Authenticate\UserCacheProvider(
            $this->app['hash'],
            $this->app['config']['auth.model'],
            $cacheMock
        );
        $this->assertSame('testing', $authProvider->retrieveById(1));
    }
}
