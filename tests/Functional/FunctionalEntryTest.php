<?php

/**
 * Class FunctionalEntryTest
 *
 * \App\Http\Controllers\EntryControllerが担うurlへアクセスして、
 * Domクローラーを使って表示のテストを行います。
 * ここではデータベースを利用せずにFakerとスタブクラスを利用します
 *
 * @see \App\Http\Controllers\EntryController
 */
class FunctionalEntryTest extends \TestCase
{
    /**
     * データベースを使わずに、Fakerを利用して
     * ブログ記事一覧に表示される`続きを読む`ボタンをクリックして
     * 遷移することを確認します。
     */
    public function testVisitEntryListPage()
    {
        // fakerを利用してブログデータを返却します
        $this->app->bind(
            \App\Repositories\EntryRepositoryInterface::class,
            \StubEntry::class
        );
        // コメント取得をスタブへ置き換えます
        $this->app->bind(
            \App\Repositories\CommentRepositoryInterface::class,
            \StubEntryCommentRepository::class
        );
        $this->visit('/entry')
            ->see('ブログ')->click('続きを読む')
            ->seePageIs('/entry/1');
    }

    /**
     * データベースにつながらない状態の場合にエラーページが表示されることを確認します
     */
    public function testVisitEntryListDatabaseFail()
    {
        $result = $this->get('/entry')
            ->see('Error occurred.');
        /**
         * エラー表示に利用されるテンプレートファイルが使われているかをテストします
         * @see \App\Exceptions\Handler::render()
         */
        /** @var Illuminate\View\View $view */
        $view = $result->response->getOriginalContent();
        $this->assertSame('errors.occurred', $view->getName());
        // ステータスコード500が返却されることを確認
        $result->assertResponseStatus(500);
    }

    /**
     * ブログ記事が登録されていない状態でアクセスした場合の
     * 表示を確認します
     */
    public function testVisitEntryListForDataNone()
    {
        $this->app->bind(
            \App\Repositories\EntryRepositoryInterface::class,
            \StubNoEntry::class
        );
        $this->visit('/entry')
            ->see('ブログ')->dontSee('続きを読む')
            ->see('ブログ記事がありません');
    }
}

class StubEntry implements \App\Repositories\EntryRepositoryInterface
{
    public function save(array $params)
    {
        return false;
    }

    public function find($id)
    {
        return factory(\App\DataAccess\Eloquent\Entry::class)->make();
    }

    public function count()
    {
        return 0;
    }

    public function byPage($page = 1, $limit = 5)
    {
        $entryFaker = factory(\App\DataAccess\Eloquent\Entry::class, 10)
            ->make(['id' => 1]);
        $object = new \StdClass;
        $object->currentPage = $page;
        $object->items = $entryFaker;
        $object->total = $entryFaker->count();
        $object->perPage = $limit;
        return $object;
    }
}

class StubNoEntry extends StubEntry
{
    public function count()
    {
        return 0;
    }

    public function byPage($page = 1, $limit = 5)
    {
        $object = new \StdClass;
        $object->currentPage = $page;
        $object->items = null;
        $object->total = $this->count();
        $object->perPage = $limit;
        return $object;
    }
}

class StubEntryCommentRepository implements \App\Repositories\CommentRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function allByEntry($id)
    {
        return [];
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save(array $params)
    {
        // TODO: Implement save() method.
    }

}
