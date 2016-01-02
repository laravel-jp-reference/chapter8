<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

/**
 * Class VerifyCsrfToken
 */
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * CSRFトークンによる検証から除外するURIを指定します
     * @var array
     */
    protected $except = [
        // 'api/v1/entry*'
    ];
}
