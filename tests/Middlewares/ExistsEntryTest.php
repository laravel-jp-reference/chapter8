<?php

use Mockery as m;

class ExistsEntryTest extends \TestCase
{
    public function testNotExistsEntryAccess()
    {
        $middleware = new \App\Http\Middleware\ExistsEntry(
            new \App\Services\EntryService(
                new StubNotExistsEntryRepository(),
                new \Illuminate\Auth\Access\Gate($this->app, function () {
                    return $this->app['auth']->user();
                })
            )
        );
        $request = m::mock(new \Illuminate\Http\Request);
        $request->shouldReceive('route->getParameter')->andReturn(1);
        /** @var \Illuminate\Http\RedirectResponse $response */
        $response = $middleware->handle($request, function () {
        });
        $this->assertTrue($response->isRedirection());
    }

    public function testNotExistsEntryAccessForEntryIndex()
    {
        $middleware = new \App\Http\Middleware\ExistsEntry(
            new \App\Services\EntryService(
                new StubNotExistsEntryRepository(),
                new \Illuminate\Auth\Access\Gate($this->app, function () {
                    return $this->app['auth']->user();
                })
            )
        );
        $request = m::mock(new \Illuminate\Http\Request);
        $request->shouldReceive('route->getParameter')->andReturn(1);
        /** @var \Illuminate\Http\RedirectResponse $response */
        $response = $middleware->handle($request, function () {
        }, 'entry');
        $this->assertTrue($response->isRedirection());
    }

    public function testExistsEntryAccess()
    {
        $middleware = new \App\Http\Middleware\ExistsEntry(
            new \App\Services\EntryService(
                new StubExistsEntryRepository(),
                new \Illuminate\Auth\Access\Gate($this->app, function () {
                    return $this->app['auth']->user();
                })
            )
        );

        $request = m::mock(new \Illuminate\Http\Request);
        $request->shouldReceive('route->getParameter')->andReturn(1);
        /** @var \Illuminate\Http\RedirectResponse $response */
        $response = $middleware->handle($request, function () {
        });
        $this->assertNull($response);
    }
}

class StubNotExistsEntryRepository implements \App\Repositories\EntryRepositoryInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function save(array $params)
    {
        return factory(\App\DataAccess\Eloquent\Entry::class)->make($params);
    }

    /**
     * @param $id
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
     * @return mixed
     */
    public function byPage($page = 1, $limit = 20)
    {
        // TODO: Implement byPage() method.
    }

}

class StubExistsEntryRepository extends StubNotExistsEntryRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return factory(App\DataAccess\Eloquent\Entry::class)->make(['user_id' => 1]);
    }
}