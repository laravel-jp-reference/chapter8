<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Guard;

/**
 * Class EntryStoreRequest
 *
 * $ php artisan make:request EntryStoreRequest として作成したフォームリクエストクラスです
 */
class EntryStoreRequest extends Request
{
    /**
     * @param Guard $auth
     *
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        if ($auth->user()) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255|unique:entries',
            'body' => 'required'
        ];
    }
}
