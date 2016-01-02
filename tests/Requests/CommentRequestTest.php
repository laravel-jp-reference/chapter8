<?php

class CommentRequestTest extends \TestCase
{
    /** @var \App\Http\Requests\CommentRequest */
    protected $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new \App\Http\Requests\CommentRequest;
        $this->request->setContainer($this->app)
            ->setRedirector($this->app['Illuminate\Routing\Redirector']);
    }

    /**
     * バリデートに失敗することをテストします
     * @expectedException \Illuminate\Http\Exception\HttpResponseException
     */
    public function testValidateError()
    {
        $this->request['comment'] = null;
        $this->request->validate();
    }

    /**
     * バリデーションが正しく通ることをテストします
     */
    public function testValidationSuccess()
    {
        $this->request['comment'] = 'testing';
        $this->request['entry_id'] = 1;
        $this->assertNull($this->request->validate());
    }
}
