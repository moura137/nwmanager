<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ClientRepository;
use NwManager\Entities\Client;
use NwManager\Presenters\ClientPresenter;

/**
 * Class ClientEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ClientEloquentRepository extends AbstractEloquentRepository implements ClientRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Client::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ClientPresenter::class;
    }
}