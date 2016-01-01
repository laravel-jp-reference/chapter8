<?php

/**
 * Class FunctionalUserLoginTest
 * このテストではMockeryを利用して、ログイン成功・失敗時の動作をテストします。
 * データベースを利用せずにテストする方法について、学習することができます
 */
class FunctionalUserLoginTest extends \TestCase
{
    /**
     * ユーザー認証に失敗することをテスト
     * databaseを利用せずに、失敗時の機能テストを行います
     */
    public function testFailedUserLogin()
    {
        // モッククラスへ差し替え、必ずログインに失敗するようにfalseを返却させます
        $this->app->bind(
            \Illuminate\Contracts\Auth\Guard::class,
            \MockGuard::class
        );
        $this->visit('/auth/login')
            ->type('laravel5@testing.co.jp', 'email')
            ->type('testing', 'password')
            ->press('ログイン')
            ->seePageIs('/auth/login')
            ->see('ユーザー認証に失敗しました');
    }

    /**
     * ユーザー認証成功時の動作をテスト
     * 失敗時のテストと同様にデータベースを利用しません
     */
    public function testSuccessUserLogin()
    {
        $this->app->bind(
            \App\Repositories\EntryRepositoryInterface::class,
            \StubLoginEntry::class
        );
        $this->app->bind(\MockGuard::class, function () {
            return new MockGuard(true);
        });
        // モッククラスへ差し替え、必ずログインでtrueを返却させます
        $this->app->bind(
            \Illuminate\Contracts\Auth\Guard::class,
            \MockGuard::class
        );
        $this->visit('/auth/login')
            ->type('laravel5@testing.co.jp', 'email')
            ->type('testing', 'password')
            ->press('ログイン')
            ->seePageIs('/admin/entry')
            ->see('ユーザー認証に失敗しました', true);
    }

}

class MockGuard implements \Illuminate\Contracts\Auth\Guard
{

    public function __construct($bool = false)
    {
        $this->bool = $bool;
    }

    public function check()
    {

    }

    public function guest()
    {

    }

    public function user()
    {
        return factory(\App\DataAccess\Eloquent\User::class)->make();
    }

    public function once(array $credentials = [])
    {

    }

    public function attempt(array $credentials = [], $remember = false, $login = true)
    {
        return $this->bool;
    }

    public function basic($field = 'email')
    {

    }

    public function onceBasic($field = 'email')
    {

    }

    public function validate(array $credentials = [])
    {

    }

    public function login(\Illuminate\Contracts\Auth\Authenticatable $user, $remember = false)
    {

    }

    public function loginUsingId($id, $remember = false)
    {

    }

    public function viaRemember()
    {

    }

    public function logout()
    {

    }

}

class StubLoginEntry implements \App\Repositories\EntryRepositoryInterface
{

    public function save(array $params)
    {
        return false;
    }

    public function find($id)
    {
        return [];
    }

    public function count()
    {
        return 0;
    }

    public function byPage($page = 1, $limit = 5)
    {
        $object = new \StdClass;
        $object->currentPage = $page;
        $object->items = [];
        $object->total = 1;
        $object->perPage = $limit;
        return $object;
    }
}
