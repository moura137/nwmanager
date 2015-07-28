<?php

namespace Tests\Services;

use Tests\TestCase;
use Mockery as m;
use NwManager\Services\ProjectService;

class ProjectServiceTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $repo = m::mock('NwManager\Repositories\Contracts\ProjectRepository');
        $validator = m::mock('NwManager\Validators\ProjectValidator');

        $serv = new ProjectService($repo, $validator);

        $this->assertInstanceOf('NwManager\Services\AbstractService', $serv);
        
        $this->assertAttributeEquals($repo, 'repository', $serv);
        $this->assertAttributeEquals($validator, 'validator', $serv);
    }
}