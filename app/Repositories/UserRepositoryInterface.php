<?php

namespace App\Repositories;

/**
 * Interface UserRepositoryInterface
 */
interface UserRepositoryInterface
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save(array $params);
}
