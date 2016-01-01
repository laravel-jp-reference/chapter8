<?php

use Mockery as m;
use App\Http\Middleware\SelfEntry;

class SelfEntryTest extends \TestCase
{

    public function testSelfEntryAccess()
    {
        $authMock = m::mock('Illuminate\Contracts\Auth\Guard')->makePartial();
        $authMock->shouldReceive('user')->andReturn(
            factory(App\DataAccess\Eloquent\User::class)->make(['id' => 1])
        );
        // Illuminate\Auth\Access\Gateをモックします
        $gateMock = m::mock('Illuminate\Auth\Access\Gate');
        $gateMock->shouldReceive('check')->andReturn(true);
        // App\Repositories\EntryRepositoryInterfaceインターフェースをモックし、
        // インターフェースを実装したオブジェクトをモックとして利用します
        $entryRepository = m::mock('App\Repositories\EntryRepositoryInterface');
        $entryRepository->shouldReceive([
            'find' => factory(App\DataAccess\Eloquent\Entry::class)->make(['user_id' => 1])
        ]);
        $entryService = new \App\Services\EntryService(
            $entryRepository,
            $gateMock
        );
        $middleware = new SelfEntry($entryService, $authMock);
        $request = m::mock(new \Illuminate\Http\Request);
        $request->shouldReceive('route->getParameter')->andReturn(1);
        /** @var \Illuminate\Http\Request $request */
        $response = $middleware->handle($request, function () { });
        $this->assertNull($response);
    }

    public function testOtherEntryAccess()
    {
        $authMock = m::mock('Illuminate\Contracts\Auth\Guard')->makePartial();
        $authMock->shouldReceive('user')->andReturn(
            factory(App\DataAccess\Eloquent\User::class)->make(['id' => 1])
        );

        $gateMock = m::mock('Illuminate\Auth\Access\Gate');
        $gateMock->shouldReceive('check')->andReturn(false);

        $entryRepository = m::mock('App\Repositories\EntryRepositoryInterface');
        $entryRepository->shouldReceive([
            'find' => factory(App\DataAccess\Eloquent\Entry::class)->make(['user_id' => 2])
        ]);

        $entryService = new \App\Services\EntryService(
            $entryRepository,
            $gateMock
        );

        $middleware = new SelfEntry($entryService, $authMock);
        $request = m::mock(new \Illuminate\Http\Request);
        $request->shouldReceive('route->getParameter')->andReturn(11);
        /** @var \Illuminate\Http\RedirectResponse $response */
        $response = $middleware->handle($request, function () { });
        $this->assertTrue($response->isRedirection());
    }
}
