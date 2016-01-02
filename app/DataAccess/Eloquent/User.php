<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * Class User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $auth_token
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\User whereAuthToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\User whereUpdatedAt($value)
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    // 認証で利用するために、Illuminate\Contracts\Auth\Authenticatableトレイトを記述します
    use Authenticatable;

    // トランザクション利用のため、saveメソッドをオーバライドします
    use SaveTransactionalTrait;

    // 5.1.11で追加されたAuthorizationを利用します
    use Authorizable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'auth_token'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     *
     * @param  string $value
     *
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
