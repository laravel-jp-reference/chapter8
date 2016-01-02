<?php

namespace App\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Guard;

/**
 * View Composerを利用して、テンプレートへのレンダー処理を分割します
 * この機能は大規模アプリケーションや、テンプレートのコンポーネント化などに有用です
 *
 * Class UserComposer
 */
class UserComposer
{
    /** @var Guard */
    protected $guard;

    /**
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('user', $this->guard->user());
    }
}
