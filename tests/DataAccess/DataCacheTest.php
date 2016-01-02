<?php

/**
 * キャッシュクラステスト
 * Class DataCacheTest
 */
class DataCacheTest extends \TestCase
{

    const CACHE_SECTION_KEY = 'testing';
    /** @var App\DataAccess\Cache\DataCache */
    protected $cache;

    public function setUp()
    {
        parent::setUp();
        $this->cache = new \App\DataAccess\Cache\DataCache(
            new \Illuminate\Cache\CacheManager($this->app),
            self::CACHE_SECTION_KEY
        );
    }

    /**
     * キャッシュへの保存や取得などが正しく行われるかをテスト
     *
     */
    public function testCacheStore()
    {
        $key = 'test';
        $this->cache->put($key, 'laravel5.1', 120);
        $this->assertTrue($this->cache->has($key));
        $this->assertSame('laravel5.1', $this->cache->get($key));
        // 存在しないキーの場合にfalseが返却されるかをテスト
        $this->assertFalse($this->cache->has('laravel4'));
        // 有効時間を指定しない場合に保存されないかをテスト
        $this->cache->put('no_time', 'laravel3');
        $this->assertFalse($this->cache->has('no_time'));
        // 指定したキーの値が削除されているかをテスト
        $this->cache->forget($key);
        $this->assertFalse($this->cache->has($key));
        // キャッシュ全てが削除されているかをテスト
        $this->cache->put($key, 'hello', 600);
        $this->cache->flush();
        $this->assertNull($this->cache->get($key));
        $this->assertNull($this->cache->get('no_time'));
    }

    /**
     * ページネーションで利用するキャッシュ実装テスト
     */
    public function testPaginateCache()
    {
        $items = [
            'laravel1', 'laravel2', 'laravel3', 'laravel4', 'laravel5', 'laravel6'
        ];
        $pageOneOffsetTwo = array_slice($items, 0, 2);
        $this->cache->putPaginateCache(
            1, 2, count($items), $pageOneOffsetTwo, 'page:1:2'
        );
        $pageTwoOffsetTwo = array_slice($items, 2, 2);
        $this->cache->putPaginateCache(
            2, 2, count($items), $pageTwoOffsetTwo, 'page:2:2'
        );
        $cachingPageOne = $this->cache->get('page:1:2');
        $cachingPageTwo = $this->cache->get('page:2:2');
        // キャッシュがページごとに作成されていることをテスト
        $this->assertSame($pageOneOffsetTwo, $cachingPageOne->items);
        $this->assertNotSame($pageTwoOffsetTwo, $cachingPageOne->items);
        $this->assertSame($pageTwoOffsetTwo, $cachingPageTwo->items);
    }
}
