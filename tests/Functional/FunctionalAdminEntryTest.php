<?php

/**
 * Class FunctionalAdminEntryTest
 *
 * 管理画面のファンクショナルテスト
 * ここでは例としてサービスコンテナを用いて実装クラスの入れ替えや、データベースを使ったテストを併用しています
 * 一つのテストクラス内で併用することができます
 */
class FunctionalAdminEntryTest extends \TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        // ユーザーログイン状態にするため、Fakerを利用します
        $user = factory(\App\DataAccess\Eloquent\User::class)
            ->make(['id' => 1, 'name' => 'testing']);
        // テスト時にログイン状態にするメソッドです
        $this->be($user);
    }

    /**
     * 管理画面のトップページの表示内容をテストします
     */
    public function testEntryPaginate()
    {
        $this->app->bind(
            \App\Repositories\EntryRepositoryInterface::class,
            \StubAdminEntryRepository::class
        );
        $this->visit('admin/entry')
            ->see('ブログエントリ')
            ->see('ログイン:testing')
            ->click('ブログを投稿する')
            ->seePageIs('admin/entry/create');
    }

    /**
     * 重複したタイトルを利用して、バリデーションエラーが起こることをテストします
     */
    public function testCreateEntryFailed()
    {
        // ブログエントリタイトル重複のバリデーションで、SQLが発行されるため
        // ここで一度レコードを鍾乳して、バリデーションエラーの動作をテストします
        factory(\App\DataAccess\Eloquent\Entry::class)->create([
            'id' => 1,
            'title' => 'testing',
            'user_id' => 1
        ]);
        $this->visit('admin/entry/create')
            ->type('testing', 'title')
            ->type('testing', 'body')
            ->press('記事を作成')
            ->seePageIs('admin/entry/create')
            ->see('タイトルの値は既に存在しています');
    }

    /**
     * ブログエントリが正しく登録されることをテストします
     */
    public function testCreateEntry()
    {
        // ブログエントリタイトル重複のバリデーションで、SQLが発行されるため
        // ここで一度レコードを挿入して、バリデーションエラーの動作をテストします
        $this->visit('admin/entry/create')
            ->type('testing', 'title')
            ->type('testing', 'body')
            ->press('記事を作成')
            ->seePageIs('admin/entry')
            ->see('testing')
            ->see('ブログエントリ');
    }

    /**
     * 存在しないブログエントリidを使ってアクセスして、
     * 管理画面トップに戻されることをテストします
     */
    public function testNotExistEntryAccess()
    {
        $this->visit('admin/entry/1/edit')
            ->seePageIs('admin/entry')
            ->see('ブログエントリ');
    }

    /**
     * ブログエントリの更新をテストします
     */
    public function testEntryUpdate()
    {
        factory(\App\DataAccess\Eloquent\Entry::class)->create([
            'id' => 1,
            'title' => 'testing',
            'user_id' => 1
        ]);
        $this->visit('admin/entry/1/edit')
            ->type('testing_update', 'title')
            ->press('記事を編集')
            ->seePageIs('admin/entry')
            ->see('testing_update')
            ->see('ブログエントリ');
    }

    /**
     * ログインユーザーが他のユーザーのブログ記事を操作できないことをテストします
     */
    public function testEntryUpdateOtherUser()
    {
        // 現在アクセスしているのはuser_id = 1のユーザーです。
        // 他のユーザーとして記事を挿入して編集フォームにアクセスします。
        factory(\App\DataAccess\Eloquent\Entry::class)->create([
            'id' => 1,
            'title' => 'testing',
            'user_id' => 2
        ]);
        // 編集させずにリダイレクトすることをテストします。
        $this->visit('admin/entry/1/edit')
            ->seePageIs('admin/entry');
    }
}


class StubAdminEntryRepository implements \App\Repositories\EntryRepositoryInterface
{

    public function save(array $params)
    {
        return false;
    }

    public function find($id)
    {
        return factory(\App\DataAccess\Eloquent\Entry::class)->make([
            'title' => 'testing'
        ]);
    }

    public function count()
    {
        return 0;
    }

    public function byPage($page = 1, $limit = 5)
    {
        $entryFaker = factory(\App\DataAccess\Eloquent\Entry::class, 10)->make(['id' => 1]);
        $object = new \StdClass;
        $object->currentPage = $page;
        $object->items = $entryFaker;
        $object->total = $entryFaker->count();
        $object->perPage = $limit;
        return $object;
    }
}
