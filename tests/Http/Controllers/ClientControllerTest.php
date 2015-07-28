<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use Traits\TraitTestRestFull;

    protected $resource = '/client';

    protected $nameRepo = 'NwManager\Repositories\Contracts\ClientRepository';

    protected $nameServ = 'NwManager\Services\ClientService';

    protected $withRelations = [];
}
