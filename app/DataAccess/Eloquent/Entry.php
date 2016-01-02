<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Entry
 *
 * @property integer        $id
 * @property integer        $user_id
 * @property string         $title
 * @property string         $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\Entry whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\Entry whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\Entry whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\Entry whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\Entry whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DataAccess\Eloquent\Entry whereUpdatedAt($value)
 */
class Entry extends Model
{
    use SaveTransactionalTrait;

    /** @var string */
    protected $table = 'entries';

    /** @var array */
    protected $fillable = ['title', 'body', 'user_id'];

    /**
     * @param $limit
     * @param $page
     *
     * @return mixed
     */
    public function byPage($limit, $page)
    {
        return $this->query()
            ->orderBy('created_at', 'desc')
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get();
    }
}
