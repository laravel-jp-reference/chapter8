<?php

use Mockery as m;

class EntryStoreRequestTest extends \TestCase
{
    /** @var \App\Http\Requests\EntryStoreRequest */
    protected $request;
    public function setUp()
    {
        parent::setUp();
        $this->request = new \App\Http\Requests\EntryStoreRequest();
        $this->request->setContainer($this->app)
            ->setRedirector($this->app['Illuminate\Routing\Redirector']);
    }

    public function testAuthorize()
    {
        $authMock = m::mock(\Illuminate\Contracts\Auth\Guard::class);
        $authMock->shouldReceive('user')->andReturn(true);
        $this->assertTrue($this->request->authorize($authMock));
    }

    public function testAuthorizeFailed()
    {
        $authMock = m::mock(\Illuminate\Contracts\Auth\Guard::class);
        $authMock->shouldReceive('user')->andReturn(false);
        $this->assertFalse($this->request->authorize($authMock));
    }

}