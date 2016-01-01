<?php

namespace App\Http\Validators;

use Illuminate\Validation\Validator;

/**
 * Class CustomValidator
 *
 * カスタムバリデートクラス
 */
class CustomValidator extends Validator
{
    /**
     * 画像キャプチャ認証によるバリデーションルール
     * @param $attribute
     * @param $value
     *
     * @return bool
     */
    protected function validateCaptcha($attribute, $value)
    {
        $this->after(function () {
            // 認証利用後セッションから指定のキーを削除します
            session()->forget('captcha.phrase');
        });
        return $value === session('captcha.phrase');
    }
}
