<?php

use Mockery as m;

/**
 * Class UserCacheProviderTest
 *
 * @see \App\Authenticate\UserCacheProvider
 */
class UserCacheProviderTest extends \TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    /** @var \App\Authenticate\UserCacheProvider */
    protected $authProvider;

    public function setUp()
    {
        parent::setUp();
        $this->authProvider = new \App\Authenticate\UserCacheProvider(
            $this->app['hash'],
            $this->app['config']['auth.model'],
            $this->app['cache.store']
        );
    }

    public function testRetrieveCacheFailed()
    {
        $this->assertNull($this->authProvider->retrieveById(1));
        $this->assertFalse(\Cache::has("user:1"));
    }

    public function testRetrieveWithCache()
    {
        $identifier = 1;
        $model = factory(App\DataAccess\Eloquent\User::class)->create(['id' => 1]);
        $this->assertNotNull($this->authProvider->retrieveById($identifier));
        $this->assertTrue(\Cache::has("user:{$identifier}"));
        $cache = \Cache::get("user:{$identifier}");
        $this->assertInstanceOf(get_class($model), $cache);
        $this->assertEquals($model->id, $cache->id);
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
