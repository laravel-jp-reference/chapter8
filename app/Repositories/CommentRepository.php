<?php

namespace App\Repositories;

use App\DataAccess\Cache\Cacheable;
use App\DataAccess\Eloquent\Comment;

/**
 * Class CommentRepository
 */
class CommentRepository implements CommentRepositoryInterface
{
    /** @var Cacheable */
    protected $cache;

    /** @var Comment */
    protected $eloquent;

    /**
     * @param Comment   $eloquent
     * @param Cacheable $cache
     */
    public function __construct(Comment $eloquent, Cacheable $cache)
    {
        $this->eloquent = $eloquent;
        $this->cache = $cache;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function allByEntry($id)
    {
        $cacheKey = "comments:{$id}";
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        $result = $this->eloquent->getAllByEntryId($id);
        if ($result) {
            $this->cache->put($cacheKey, $result);
        }
        return $result;
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save(array $params)
    {
        $result = $this->eloquent->fill($params)->save();
        $this->cache->flush();
        return $result;
    }
}
