<?php

/**
 * Class FunctionalUserRegisterTest
 *
 * ここでは例としてデータベースを利用する方法でテストします。
 * テスト時はDB_CONNECTION=testingが利用されます
 * sqliteのインメモリデータベースが利用されますので、プロジェクト内には残りません
 *
 * データベースを使わずにテストしているFunctionalEntryTestとの違いに着目してみましょう
 */
class FunctionalUserRegisterTest extends \TestCase
{
    // マイグレーションを実行するため、トレイトを利用します
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    /**
     * ユーザー登録に必要な項目を入力せずに、バリデーションエラーが実行されることをテストします
     */
    public function testPostFailedUserRegister()
    {
        $this->visit('/auth/register')
            ->type('laravel5', 'name')
            ->press('アカウント作成')
            ->seePageIs('/auth/register')
            ->see('画像認証を入力してください。')
            ->see('パスワードを入力してください。')
            ->see('メールアドレスを入力してください。');
    }

    /**
     * ユーザー作成が行われることをテストします
     * ユーザー作成時に送信されるメールは、テストではログに出力されるように設定しています
     * 'phpunit.xml内の<env name="MAIL_DRIVER" value="log" />'
     */
    public function testPostUserRegister()
    {
        $this->registerTestLogger();
        $mailLog = base_path('/tests/storage/logs/mail.log');
        // ログで利用するファイルをtests配下に変更します
        \Log::useFiles($mailLog);

        $this->visit('/auth/register')
            ->type('laravel5', 'name')
            ->type('laravel-reference@example.com', 'email')
            ->type('testing', 'password')
            ->type('testing', 'password_confirmation')
            ->type(session('captcha.phrase'), 'captcha_code')
            ->press('アカウント作成');
        // ファイルが出力されたかどうかを確認します
        $this->assertFileExists($mailLog);
        // メールに記載されている内容をテストできます
        $this->assertNotFalse(
            strpos(file_get_contents($mailLog), 'laravel-reference@example.com')
        );
        // テスト終了時に行う処理を記述します
        $this->beforeApplicationDestroyed(function() use ($mailLog) {
            // ログファイルの削除を行います
            \File::delete($mailLog);
        });
    }
}
