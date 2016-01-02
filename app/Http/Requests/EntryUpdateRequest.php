<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Guard;

/**
 * Class EntryUpdateRequest
 */
class EntryUpdateRequest extends Request
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
        $id = $this->route()->getParameter('entry');
        return [
            'title' => 'required|max:255|unique:entries,title,' . $id,
            'body' => 'required'
        ];
    }
}
