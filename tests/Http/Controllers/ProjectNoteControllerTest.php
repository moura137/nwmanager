<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;

class ProjectNoteControllerTest extends TestCase
{
    use Traits\TraitTestRestFull;

    protected $resource = '/project/note';

    protected $nameRepo = 'NwManager\Repositories\Contracts\ProjectNoteRepository';

    protected $nameServ = 'NwManager\Services\ProjectNoteService';

    protected $withRelations = ['project'];
}
