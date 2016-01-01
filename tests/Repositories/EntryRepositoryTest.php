<?php

use Mockery as m;

class EntryRepositoryTest extends \TestCase
{
    const CACHE_SECTION_KEY = 'testing';

    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    /**
     * @return \App\Repositories\EntryRepository
     */
    protected function getRepositoryNoMockInstance()
    {
        return new \App\Repositories\EntryRepository(
            new \App\DataAccess\Eloquent\Entry,
            $this->newCacheInstance()
        );
    }

    /**
     * 指定した値が取得されるか
     * （キャッシュ利用せず）
     */
    public function testRecordInsertAndReadWithOutCache()
    {
        $repository = $this->getRepositoryNoMockInstance();
        $this->assertSame(0, $repository->count());
        $repository->save([
            'title' => 'testing',
            'body' => 'testing',
            'user_id' => 1
        ]);
        $this->assertSame(1, $repository->count());
        $result = $repository->find(1);
        $this->assertSame('testing', $result->title);
        $this->assertSame('testing', $result->body);
        $this->assertSame('1', $result->user_id);
    }

    public function testNoRecordPaginate()
    {
        $repository = $this->getRepositoryNoMockInstance();
        $page = $repository->byPage();
        $this->assertSame(0, $page->total);
        // default per page
        $this->assertSame(20, $page->perPage);
    }

    public function testRecordHasPaginate()
    {
        $repository = $this->getRepositoryNoMockInstance();
        $repository->save([
            'title' => 'testing',
            'body' => 'testing',
            'user_id' => 1
        ]);
        $page = $repository->byPage();
        $this->assertSame(1, $page->total);
        /** @var \Illuminate\Database\Eloquent\Collection $result */
        $result = $page->items;
        // default per page
        $this->assertSame(20, $page->perPage);
        $this->assertSame('testing', $result->all()[0]->title);
        $this->assertSame('testing', $result->all()[0]->body);
        $this->assertSame('1', $result->all()[0]->user_id);
    }

    /**
     * 指定した値が取得されるか
     * （キャッシュ利用）
     */
    public function testRecordInsertAndReadWithCache()
    {
        // キャッシュの動作をモック
        $cacheMock = m::mock($this->newCacheInstance());
        $cacheMock->shouldReceive('has')->once()->andReturn(true);
        $cacheMock->shouldReceive('get')->with("entry:1")->once()->andReturn('testing');
        $repository = new \App\Repositories\EntryRepository(
            new \App\DataAccess\Eloquent\Entry,
            $cacheMock
        );
        $result = $repository->find(1);
        $this->assertSame('testing', $result);
    }

    public function testRecordHasPaginateWithCache()
    {
        // キャッシュの動作をモック
        $cacheMock = m::mock($this->newCacheInstance());
        $cacheMock->shouldReceive('has')->once()->andReturn(true);
        $cacheMock->shouldReceive('get')->with("entry_page:1:1")->once()->andReturn('testing');
        $repository = new \App\Repositories\EntryRepository(
            new \App\DataAccess\Eloquent\Entry,
            $cacheMock
        );
        $this->assertSame('testing', $repository->byPage(1, 1));
    }

    /**
     * キャッシュコンポーネントをモックして、
     * 意図したキャッシュを使って値の返却を調べます
     */
    public function testRecordCountWithCache()
    {
        // キャッシュの動作をモック
        $cacheMock = m::mock($this->newCacheInstance());
        $cacheMock->shouldReceive('has')->once()->andReturn(true);
        $cacheMock->shouldReceive('get')->with("entry_count")->once()->andReturn(0);
        $repository = new \App\Repositories\EntryRepository(
            new \App\DataAccess\Eloquent\Entry,
            $cacheMock
        );
        $this->assertSame(0, $repository->count());
    }

    /**
     * @return \App\DataAccess\Cache\DataCache
     */
    protected function newCacheInstance()
    {
        return new \App\DataAccess\Cache\DataCache(
            new \Illuminate\Cache\CacheManager($this->app),
            self::CACHE_SECTION_KEY
        );
    }
}
