<?php

namespace App\Repositories;

use App\DataAccess\Eloquent\User;

/**
 * Class UserRepository
 */
class UserRepository implements UserRepositoryInterface
{
    /** @var User */
    protected $eloquent;

    /**
     * @param User $eloquent
     */
    public function __construct(User $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    /**
     * @param array $params
     *
     * @return User
     */
    public function save(array $params)
    {
        return $this->eloquent->create($params);
    }
}
