<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookies extends BaseEncrypter
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        /**
         * ここではアプリケーションで利用するCookieについての設定が行えます
         *
         * Laravelでは、アプリケーションで利用するCookie全てを暗号化、複合して利用しますが
         * アプリケーションで発行されていないCookieを利用する場合は、複合できないため利用できません。
         * そういったCookieを利用する場合は、利用するCookie名をここに記述します
         */
    ];
}
