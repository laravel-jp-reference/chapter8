<?php

class UserServiceTest extends \TestCase
{
    /** @var \App\Services\UserService */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->registerTestLogger();
        $this->service = new \App\Services\UserService(
            new StubUserServiceRepository,
            $this->app['mailer']
        );
    }

    public function testUserRegister()
    {
        $path = base_path('tests/storage/logs/user_register.log');
        \Log::useFiles($path);
        $user = $this->service->registerUser([]);
        $this->assertFileExists($path);
        $content = file_get_contents($path);
        $this->assertNotFalse(strpos($content, 'laravel-reference@example.com'));
        $this->assertNotFalse(strpos($content, 'ユーザー登録が完了しました'));
        $this->assertNotFalse(strpos($content, 'testing'));
        $this->beforeApplicationDestroyed(function () use ($path) {
            \File::delete($path);
        });
    }
}

class StubUserServiceRepository implements \App\Repositories\UserRepositoryInterface
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save(array $params)
    {
        return factory(\App\DataAccess\Eloquent\User::class)
            ->make([
                'id' => 1,
                'name' => 'testing'
            ]);
    }

}
