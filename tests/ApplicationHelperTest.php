<?php

class ApplicationHelperTest extends \TestCase
{
    /**
     * captchaメソッドのテスト
     */
    public function testCaptchaRender()
    {
        $captcha = captcha();
        $this->assertInternalType('string', $captcha);
        $this->assertSessionHas('captcha.phrase');
    }
}
