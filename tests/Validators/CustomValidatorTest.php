<?php

/**
 * CustomValidatorのテストです
 * @see \App\Http\Validators\CustomValidator
 */
class CustomValidatorTest extends \TestCase
{

    public function setUp()
    {
        parent::setUp();
        captcha();
    }

    /**
     * バリデーションエラーが発生することをテスト
     */
    public function testValidationCaptcha()
    {
        $validator = \Validator::make(
            ['code' => 'something wrong'],
            ['code' => 'captcha']
        );
        $this->asserttrue($validator->fails());
    }

    /**
     * バリデーション実行後、セッションからキャプチャフレーズが削除されていること
     */
    public function testValidatedCaptcha()
    {
        $phrase = session('captcha.phrase');
        $validator = \Validator::make(['code' => $phrase], ['code' => 'captcha']);
        $this->assertFalse($validator->fails());
        $this->assertNull(session('captcha.phrase'));
    }

}
