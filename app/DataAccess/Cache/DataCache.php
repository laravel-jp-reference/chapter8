<?php

namespace App\DataAccess\Cache;

use Illuminate\Cache\CacheManager;

/**
 * Class DataCache
 */
class DataCache implements Cacheable
{
    /** @var CacheManager */
    protected $cache;

    /** @var string */
    protected $cacheKey;

    /** @var null */
    protected $minutes;

    /**
     * @param CacheManager $cache
     * @param              $cacheKey
     * @param null         $minutes
     */
    public function __construct(CacheManager $cache, $cacheKey, $minutes = null)
    {
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->minutes = $minutes;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->cache->tags($this->cacheKey)->get($key);
    }

    /**
     * @param      $key
     * @param      $value
     * @param null $minutes
     *
     * @return mixed
     */
    public function put($key, $value, $minutes = null)
    {
        if (is_null($minutes)) {
            $minutes = $this->minutes;
        }
        return $this->cache->tags($this->cacheKey)->put($key, $value, $minutes);
    }

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
    ) {
        $cached = new \StdClass;
        $cached->currentPage = $currentPage;
        $cached->items = $items;
        $cached->total = $total;
        $cached->perPage = $perPage;
        $this->put($key, $cached, $minutes);
        return $cached;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function has($key)
    {
        return $this->cache->tags($this->cacheKey)->has($key);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function forget($key)
    {
        return $this->cache->tags($this->cacheKey)->forget($key);
    }

    /**
     * @return void
     */
    public function flush()
    {
        $this->cache->tags($this->cacheKey)->flush();
    }
}
