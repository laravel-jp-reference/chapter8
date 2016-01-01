<?php

use App\Composers\UserComposer;

/**
 * Class UserComposerTest
 * @see \App\Composers\UserComposer
 */
class UserComposerTest extends \TestCase
{

    /**
     * ユーザーがログイン中はテンプレートにユーザー情報がアサインされることをテストします
     */
    public function testLoginUserComposer()
    {
        $user = factory(App\DataAccess\Eloquent\User::class)->make();
        $this->be($user);
        $response = $this->getResponse();
        $assign = $response->original->getData();
        $this->assertArrayHasKey('user', $assign);
        $this->assertNotNull($assign['user']);
        $this->assertSame($assign['user']->name, $user->name);
    }

    /**
     * 未ログインの場合はユーザー情報をテンプレートにアサインされていないことをテストします
     */
    public function testNoLoginUserComposer()
    {
        $response = $this->getResponse();
        $assign = $response->original->getData();
        $this->assertArrayHasKey('user', $assign);
        $this->assertNull($assign['user']);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    protected function getResponse()
    {
        $factory = app('Illuminate\Contracts\View\Factory');
        $factory->addLocation(base_path('tests/resources/views'));
        $factory->composer('composer.user', UserComposer::class);
        return new \Illuminate\Http\Response($factory->make('composer.user'));
    }

}
