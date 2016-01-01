<?php

/**
 * Class UserRegisterRequestTest
 * これはLaravelのフォームリクエスト、バリデーションの機能を使ったファンクショナルテストです
 *
 * @see \App\Http\Requests\UserRegisterRequest
 */
class UserRegisterRequestTest extends \TestCase
{
    /** @var \App\Http\Requests\UserRegisterRequest */
    protected $request;

    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->request = new \App\Http\Requests\UserRegisterRequest;
        $this->request->setContainer($this->app)
            ->setRedirector($this->app['Illuminate\Routing\Redirector']);
    }

    /**
     * バリデートに失敗することをテストします
     * @expectedException \Illuminate\Http\Exception\HttpResponseException
     */
    public function testValidateError()
    {
        captcha();
        $phrase = session('captcha.phrase');
        $this->request['name'] = 'testing';
        $this->request['email'] = 'testing@example.com';
        $this->request['password'] = 'testing';
        $this->request['captcha_code'] = $phrase;
        $this->request->validate();
    }

    /**
     * バリデーションが正しく通ることをテストします
     */
    public function testValidationSuccess()
    {
        captcha();
        $phrase = session('captcha.phrase');
        $this->request['name'] = 'testing';
        $this->request['email'] = 'testing@example.com';
        $this->request['password'] = 'testing';
        $this->request['password_confirmation'] = 'testing';
        $this->request['captcha_code'] = $phrase;
        $this->assertNull($this->request->validate());
    }
}