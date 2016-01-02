<?php

use Mockery as m;

/**
 * Class EntryServiceTest
 *
 * @see \App\Services\EntryService
 */
class EntryServiceTest extends \TestCase
{
    /**
     * 作成者と編集者が異なる場合に編集を実行できないことをテスト
     */
    public function testUpdateEntryWithOtherUser()
    {
        // 認可でfalseを返却したものとして、Gateクラスのcheckメソッドの返却値をモックします
        $gateMock = m::mock('Illuminate\Auth\Access\Gate');
        $gateMock->shouldReceive('check')->andReturn(false);

        $this->registerTestLogger();
        $entryService = new \App\Services\EntryService(
            // インターフェースを実装したスタブクラスへ差し替えます
            new \StubEntryRepository(),
            $gateMock
        );
        $result = $entryService->addEntry([
            'title' => 'testing',
            'body' => 'testing content',
            'user_id' => '2',
            'id' => 1
        ]);
        $this->assertFalse($result);
    }

    /**
     * 作成者と編集者が同一の場合に編集できることをテスト
     */
    public function testUpdateEntryWithAuthor()
    {
        // 認可でfalseを返却したものとして、Gateクラスのcheckメソッドの返却値をモックします
        $gateMock = m::mock('Illuminate\Auth\Access\Gate');
        $gateMock->shouldReceive('check')->andReturn(true);

        $this->registerTestLogger();
        $entryService = new \App\Services\EntryService(
            new \StubEntryRepository(),
            $gateMock
        );
        $result = $entryService->addEntry([
            'title' => 'testing',
            'body' => 'testing content',
            'user_id' => '2',
            'id' => 1
        ]);
        $this->assertInstanceOf('App\DataAccess\Eloquent\Entry', $result);
    }
}

class StubEntryRepository implements \App\Repositories\EntryRepositoryInterface
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save(array $params)
    {
        return factory(\App\DataAccess\Eloquent\Entry::class)->make($params);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @return mixed
     */
    public function count()
    {
        // TODO: Implement count() method.
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return mixed
     */
    public function byPage($page = 1, $limit = 20)
    {
        // TODO: Implement byPage() method.
    }
}
