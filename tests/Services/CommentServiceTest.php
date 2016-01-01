<?php

class CommentServiceTest extends \TestCase
{
    /** @var \App\Services\CommentService */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new \App\Services\CommentService(
            new StubCommentRepository
        );
        $this->app->bind(
            \App\Repositories\EntryRepositoryInterface::class,
            \StubCommentEntryRepository::class
        );
    }

    public function testCommentResult()
    {
        $result = $this->service->getCommentsByEntry(1);
        $this->assertSame(20, $result->count());
        $result = $this->service->getCommentsByEntry(10);
        $this->assertSame(0, $result->count());
    }
}

class StubCommentRepository implements \App\Repositories\CommentRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function allByEntry($id)
    {
        /** @var \Illuminate\Database\Eloquent\Collection $factory */
        $factory = factory(App\DataAccess\Eloquent\Comment::class, 20)
            ->make(['entry_id' => 1]);
        return $factory->where('entry_id', $id);
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save(array $params)
    {
        return factory(App\DataAccess\Eloquent\Comment::class)
            ->make($params);
    }
}

class StubCommentEntryRepository implements \App\Repositories\EntryRepositoryInterface
{

    public function save(array $params)
    {
        // TODO: Implement save() method.
    }

    public function find($id)
    {
        return factory(App\DataAccess\Eloquent\Entry::class)
            ->make(['title' => 'testing']);
    }

    public function count()
    {
        // TODO: Implement count() method.
    }

    public function byPage($page = 1, $limit = 20)
    {
        // TODO: Implement byPage() method.
    }
}
