<?php

namespace App\Policies;

use App\DataAccess\Eloquent\User;
use App\DataAccess\Eloquent\Entry;

/**
 * Class EntryPolicy
 *
 * `$ php artisan make:policy EntryPolicy`コマンドで作成したクラスです。
 * このクラスはブログ記事編集時に、作成ユーザー以外に許可を与えないように制御を行います
 */
class EntryPolicy
{
    /**
     * @param User  $user
     * @param Entry $entry
     *
     * @return bool
     */
    public function update(User $user, Entry $entry)
    {
        return $user->id === (int)$entry->user_id;
    }
}
