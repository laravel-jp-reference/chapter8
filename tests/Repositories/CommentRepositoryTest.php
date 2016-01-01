<?php

use Mockery as m;

/**
 * Class CommentRepositoryTest
 *
 * ここでは例として実際にデータベースを使ってリポジトリを通してデータベースアクセスを行っています
 * データベースを利用せずに、
 * \App\DataAccess\Eloquent\Commentクラスをモックしてテストを行うことも可能です
 *
 * @see \App\Repositories\CommentRepository
 */
class CommentRepositoryTest extends \TestCase
{
    const CACHE_SECTION_KEY = 'testing';

    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    /**
     * @return \App\Repositories\CommentRepository
     */
    protected function getRepositoryNoMockInstance()
    {
        $cache = new \App\DataAccess\Cache\DataCache(
            new \Illuminate\Cache\CacheManager($this->app),
            self::CACHE_SECTION_KEY
        );
        return new \App\Repositories\CommentRepository(
            new \App\DataAccess\Eloquent\Comment,
            $cache
        );
    }

    /**
     * 指定した値が取得されるか
     * （キャッシュ利用せず）
     */
    public function testRecordInsertAndReadWithOutCache()
    {
        $repository = $this->getRepositoryNoMockInstance();
        $this->assertSame(0, $repository->allByEntry(1)->count());
        $repository->save([
            'comment' => 'testing',
            'name' => 'testing',
            'entry_id' => 1
        ]);
        $result = $repository->allByEntry(1)->find(1);
        $this->assertSame('testing', $result->comment);
        $this->assertSame('testing', $result->name);
        $this->assertSame('1', $result->entry_id);
    }

    /**
     * 指定した値が取得されるか
     * （キャッシュ利用）
     */
    public function testRecordInsertAndReadWithCache()
    {
        $cache = new \App\DataAccess\Cache\DataCache(
            new \Illuminate\Cache\CacheManager($this->app),
            self::CACHE_SECTION_KEY
        );
        // キャッシュの動作をモック
        $cacheMock = m::mock($cache);
        $cacheMock->shouldReceive('has')->once()->andReturn(true);
        $cacheMock->shouldReceive('get')->with("comments:1")->once()->andReturn('testing');
        $repository = new \App\Repositories\CommentRepository(
            new \App\DataAccess\Eloquent\Comment,
            $cacheMock
        );
        $this->assertSame('testing', $repository->allByEntry(1));
    }
}
