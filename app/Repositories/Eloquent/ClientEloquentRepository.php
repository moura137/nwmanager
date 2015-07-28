<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ClientRepository;
use NwManager\Entities\Client;

/**
 * Class ClientEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ClientEloquentRepository extends AbstractEloquentRepository implements ClientRepository
{
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
}