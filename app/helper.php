<?php

if (!function_exists('captcha')) {

    /**
     * 認証画像キャプチャを出力します
     *
     * @return string
     */
    function captcha()
    {
        /** @var Gregwar\Captcha\CaptchaBuilder $captcha */
        $captcha = app('Gregwar\Captcha\CaptchaBuilderInterface');
        $captcha->build();
        // 'captcha.phrase'という名前でセッションに値を保持します
        session(['captcha.phrase' => $captcha->getPhrase()]);
        return $captcha->inline();
    }
}
