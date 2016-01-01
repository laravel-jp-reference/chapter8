<?php

namespace App\Http\Requests;

/**
 * Class CommentRequest
 */
class CommentRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'entry_id' => 'required',
            'comment'  => 'required',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();

        return $url->route('entry.show', [$this->request->get('entry_id')]);
    }
}
