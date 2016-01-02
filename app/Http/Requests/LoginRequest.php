<?php

namespace App\Http\Requests;

/**
 * Class LoginRequest
 *
 * $ php artisan make:request LoginRequest コマンドで作成したクラスです
 */
class LoginRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
