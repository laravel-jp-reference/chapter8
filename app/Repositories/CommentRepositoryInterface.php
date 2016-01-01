<?php

namespace App\Repositories;

/**
 * Interface CommentRepositoryInterface
 */
interface CommentRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function allByEntry($id);

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save(array $params);
}
