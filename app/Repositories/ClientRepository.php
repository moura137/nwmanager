<?php

namespace NwManager\Repositories;

use NwManager\Entities\Client;

class ClientRepository extends AbstractRepository
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