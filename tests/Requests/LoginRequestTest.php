<?php

class LoginRequestTest extends \TestCase
{
    /** @var \App\Http\Requests\LoginRequest */
    protected $request;
    public function setUp()
    {
        parent::setUp();
        $this->request = new \App\Http\Requests\LoginRequest;
        $this->request->setContainer($this->app)
            ->setRedirector($this->app['Illuminate\Routing\Redirector']);
    }

    /**
     * バリデートに失敗することをテストします
     * @expectedException \Illuminate\Http\Exception\HttpResponseException
     */
    public function testValidateError()
    {
        $this->request['password'] = 'testing';
        $this->request['email'] = null;
        $this->request->validate();

        $this->request['password'] = 'testing';
        // email形式ではないものを指定
        $this->request['email'] = 'testing';
        $this->request->validate();
    }

    /**
     * バリデーションが正しく通ることをテストします
     */
    public function testValidationSuccess()
    {
        $this->request['password'] = 'testing';
        $this->request['email'] = 'laravel-reference@example.com';
        $this->assertNull($this->request->validate());
    }
}
