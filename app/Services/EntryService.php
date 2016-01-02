<?php

namespace App\Services;

use App\Repositories\EntryRepositoryInterface;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class EntryService
 */
class EntryService
{
    /** @var EntryRepositoryInterface */
    protected $entry;

    /** @var Gate */
    protected $gate;

    /**
     * @param EntryRepositoryInterface $entry
     * @param Gate                     $gate
     */
    public function __construct(EntryRepositoryInterface $entry, Gate $gate)
    {
        $this->entry = $entry;
        $this->gate = $gate;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function addEntry(array $attributes)
    {
        if (isset($attributes['id'])) {
            if (!$this->getEntryAbility($attributes['id'])) {
                return false;
            }
        }

        return $this->entry->save($attributes);
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return LengthAwarePaginator
     */
    public function getPage($page = 1, $limit = 20)
    {
        $result = $this->entry->byPage($page, $limit);

        return new LengthAwarePaginator(
            $result->items, $result->total, $result->perPage, $result->currentPage
        );
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getEntry($id)
    {
        return $this->entry->find($id);
    }

    /**
     * 操作権限を取得する
     *
     * @param $id
     *
     * @return bool
     */
    public function getEntryAbility($id)
    {
        return $this->gate->check('update', $this->getEntry($id));
    }
}
