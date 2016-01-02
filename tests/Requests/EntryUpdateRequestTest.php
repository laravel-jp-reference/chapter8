<?php

use Mockery as m;

class EntryUpdateRequestTest extends \TestCase
{
    /** @var \App\Http\Requests\EntryUpdateRequest */
    protected $request;
    public function setUp()
    {
        parent::setUp();
        $this->request = new \App\Http\Requests\EntryUpdateRequest();
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