<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\AbstractRepository;
use NwManager\Repositories\Contracts\ClientRepository;
use NwManager\Entities\Client;

class ClientEloquentRepository extends AbstractRepository implements ClientRepository
{
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