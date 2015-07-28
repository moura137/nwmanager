<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use Traits\TraitTestRestFull;

    protected $resource = '/project';

    protected $nameRepo = 'NwManager\Repositories\Contracts\ProjectRepository';

    protected $nameServ = 'NwManager\Services\ProjectService';

    protected $withRelations = ['client', 'owner'];
}
