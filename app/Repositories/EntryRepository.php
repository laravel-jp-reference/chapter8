<?php

namespace App\Repositories;

use App\DataAccess\Eloquent\Entry;
use App\DataAccess\Cache\Cacheable;

/**
 * Class EntryRepository
 */
class EntryRepository implements EntryRepositoryInterface
{
    /** @var Cacheable */
    protected $cache;

    /** @var Entry */
    protected $eloquent;

    /**
     * @param Entry     $eloquent
     * @param Cacheable $cache
     */
    public function __construct(Entry $eloquent, Cacheable $cache)
    {
        $this->cache = $cache;
        $this->eloquent = $eloquent;
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save(array $params)
    {
        $attributes = [];
        $attributes['id'] = (isset($params['id'])) ? $params['id'] : null;
        $result = $this->eloquent->updateOrCreate($attributes, $params);
        if ($result) {
            $this->cache->flush();
        }
        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        $cacheKey = "entry:{$id}";
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        $result = $this->eloquent->find($id);
        if ($result) {
            $this->cache->put($cacheKey, $result);
        }

        return $result;
    }

    /**
     * @return int
     */
    public function count()
    {
        $key = 'entry_count';
        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }
        $result = $this->eloquent->count();
        $this->cache->put($key, $result);

        return $result;
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return mixed|\StdClass
     */
    public function byPage($page = 1, $limit = 20)
    {
        // ページごとにキャッシュさせるように変更し、高速に動作させます
        $key = "entry_page:{$page}:{$limit}";
        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }
        return $this->cache->putPaginateCache(
            $page,
            $limit,
            $this->count(),
            $this->eloquent->byPage($limit, $page),
            $key
        );
    }
}
