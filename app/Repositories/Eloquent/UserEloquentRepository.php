<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\UserRepository;
use NwManager\Entities\User;

/**
 * Class UserEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class UserEloquentRepository extends AbstractEloquentRepository implements UserRepository
{
    protected $fieldSearchable = [
        'username' => 'like',
        'name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}