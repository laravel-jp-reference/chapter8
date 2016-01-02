<?php

namespace App\Repositories;

/**
 * Interface EntryRepositoryInterface
 */
interface EntryRepositoryInterface
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save(array $params);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * @return mixed
     */
    public function count();

    /**
     * @param int $page
     * @param int $limit
     *
     * @return mixed
     */
    public function byPage($page = 1, $limit = 20);
}
