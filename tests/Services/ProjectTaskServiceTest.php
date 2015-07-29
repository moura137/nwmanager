<?php

namespace Tests\Services;

use Tests\TestCase;
use Mockery as m;
use NwManager\Services\ProjectTaskService;

class ProjectTaskServiceTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $repo = m::mock('NwManager\Repositories\Contracts\ProjectTaskRepository');
        $validator = m::mock('NwManager\Validators\ProjectTaskValidator');

        $serv = new ProjectTaskService($repo, $validator);

        $this->assertInstanceOf('NwManager\Services\AbstractService', $serv);
        
        $this->assertAttributeEquals($repo, 'repository', $serv);
        $this->assertAttributeEquals($validator, 'validator', $serv);
    }
}