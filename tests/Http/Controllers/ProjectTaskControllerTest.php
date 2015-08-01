<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;

class ProjectTaskControllerTest extends TestCase
{
    use Traits\TraitTestRestFull;

    protected $resource = '/project/task';

    protected $nameRepo = 'NwManager\Repositories\Contracts\ProjectTaskRepository';

    protected $nameServ = 'NwManager\Services\ProjectTaskService';

    protected $withRelations = ['project'];
}
