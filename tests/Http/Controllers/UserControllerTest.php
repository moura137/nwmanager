<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use Traits\TraitTestRestFull;

    protected $resource = '/user';

    protected $nameRepo = 'NwManager\Repositories\Contracts\UserRepository';

    protected $nameServ = 'NwManager\Services\UserService';

    protected $withRelations = [];
}
