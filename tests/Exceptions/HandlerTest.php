<?php

class HandlerTest extends \TestCase
{
    /** @var \App\Exceptions\Handler  */
    protected $handler;
    public function setUp()
    {
        parent::setUp();
        $this->registerTestLogger();
        $this->handler = new \App\Exceptions\Handler($this->app['log']);
    }

    public function testQueryErrorRender()
    {
        /** @var \Illuminate\Http\Response $render */
        $response = $this->handler->render(
            $this->app['request'],
            new \Illuminate\Database\QueryException('SHOW TABLES', [], new \Exception)
        );
        /** @var \Illuminate\View\View $view */
        $view = $response->getOriginalContent();
        $this->assertSame('errors.occurred', $view->getName());
    }

    public function testErrorRender()
    {
        /** @var \Illuminate\Http\Response $render */
        $response = $this->handler->render(
            $this->app['request'],
            new \ErrorException
        );
        /** @var \Illuminate\View\View $view */
        $view = $response->getOriginalContent();
        $this->assertSame('errors.occurred', $view->getName());
    }

    public function testDefaultRender()
    {
        $response = $this->handler->render(
            $this->app['request'],
            new \LogicException
        );
        $this->assertInternalType('string', $response->getOriginalContent());
    }

    public function testReport()
    {
        $path = base_path('tests/storage/logs/report.log');
        \Log::useFiles($path);
        $this->handler->report(new \ErrorException('testing error'));
        $this->assertFileExists($path);
        $content = file_get_contents($path);
        $this->assertNotFalse(strpos($content, 'testing error'));
        $this->beforeApplicationDestroyed(function () use ($path) {
            \File::delete($path);
        });
    }

    public function testNotFoundRender()
    {
        $path = base_path('tests/storage/logs/report.log');
        \Log::useFiles($path);
        $exception = new \Illuminate\Database\Eloquent\ModelNotFoundException();
        $exception->setModel('Testing');
        $response = $this->handler->render(
            $this->app['request'],
            $exception
        );
        $this->assertSame(404, $response->getStatusCode());
        $this->beforeApplicationDestroyed(function () use ($path) {
            \File::delete($path);
        });
    }
}
