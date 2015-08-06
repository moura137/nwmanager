<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\UserRepository;
use NwManager\Entities\User;
use NwManager\Presenters\UserPresenter;

/**
 * Class UserEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class UserEloquentRepository extends AbstractEloquentRepository implements UserRepository
{
    /**
     * @var array
     */
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

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return UserPresenter::class;
    }
}