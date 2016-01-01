<?php

namespace App\DataAccess\Cache;

/**
 * Interface Cacheable
 */
interface Cacheable
{
    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param      $key
     * @param      $value
     * @param null $minutes
     *
     * @return mixed
     */
    public function put($key, $value, $minutes = null);

    /**
     * @param     $currentPage
     * @param     $perPage
     * @param     $total
     * @param     $items
     * @param     $key
     * @param int $minutes
     *
     * @return \StdClass
     */
    public function putPaginateCache(
        $currentPage,
        $perPage,
        $total,
        $items,
        $key,
        $minutes = 10
    );

    /**
     * @param $key
     *
     * @return mixed
     */
    public function has($key);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function forget($key);

    /**
     * @return void
     */
    public function flush();
}
