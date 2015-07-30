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

    public function testAddMember()
    {
        $relation = m::mock('Relation');
        $relation->shouldReceive('attach')->once()->with([5])->andReturn(null);

        $project = m::mock('NwManager\Entities\Project[members]');
        $project->shouldReceive('members')->once()->andReturn($relation);

        $repo = m::mock('NwManager\Repositories\Contracts\ProjectRepository');
        $repo->shouldReceive('find')->once()->with(3)->andReturn($project);

        $validator = m::mock('NwManager\Validators\ProjectValidator');
        $serv = new ProjectService($repo, $validator);

        $this->assertTrue($serv->addMember(3, 5));
    }

    public function testRemoveMember()
    {
        $relation = m::mock('Relation');
        $relation->shouldReceive('detach')->once()->with([5,7,9])->andReturn(3);

        $project = m::mock('NwManager\Entities\Project[members]');
        $project->shouldReceive('members')->once()->andReturn($relation);

        $repo = m::mock('NwManager\Repositories\Contracts\ProjectRepository');
        $repo->shouldReceive('find')->once()->with(3)->andReturn($project);

        $validator = m::mock('NwManager\Validators\ProjectValidator');
        $serv = new ProjectService($repo, $validator);

        $this->assertEquals(3, $serv->removeMember(3, [5,7,9]));
    }

    public function testIsMember()
    {
        $relation = m::mock('Relation');
        $relation->shouldReceive('find')->once()->with(7)->andReturn(1);

        $project = m::mock('NwManager\Entities\Project[members]');
        $project->shouldReceive('members')->once()->andReturn($relation);

        $repo = m::mock('NwManager\Repositories\Contracts\ProjectRepository');
        $repo->shouldReceive('find')->once()->with(3)->andReturn($project);

        $validator = m::mock('NwManager\Validators\ProjectValidator');
        $serv = new ProjectService($repo, $validator);

        $this->assertTrue($serv->isMember(3, 7));
    }
}