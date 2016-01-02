<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Database\QueryException;

/**
 * Class SaveTransactionalTrait
 */
trait SaveTransactionalTrait
{
    /**
     * saveメソッドをオーバライドして、トランザクションを利用しています
     * 複数のEloquentクラスにまたがってトランザクションを利用する場合は、
     * オブザーバや、サービスクラスなどで記述しても構いません。
     * 実装するアプリケーションにあわせて利用してください。
     *
     * @param array $options
     *
     * @return mixed
     */
    public function save(array $options = [])
    {
        try {
            return $this->getConnection()
                ->transaction(function () use ($options) {
                    return parent::save($options);
                });
        } catch (QueryException $e) {
            throw $e;
        }
    }
}
