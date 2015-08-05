<?php

namespace Tests\Repositories\Eloquent;

use Tests\TestCase;
use Mockery as m;
use NwManager\Repositories\Eloquent\ProjectEloquentRepository;

class ProjectRepositoryTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $repo = new ProjectEloquentRepository($this->app);

        $this->assertInstanceOf('NwManager\Repositories\Contracts\ProjectRepository', $repo);
        $this->assertInstanceOf('NwManager\Repositories\Eloquent\AbstractEloquentRepository', $repo);
        $this->assertInstanceOf('Prettus\Repository\Eloquent\BaseRepository', $repo);
        
        $fieldSearchable = ['name' => 'like',];
        $this->assertAttributeEquals($fieldSearchable, 'fieldSearchable', $repo);

        $this->assertEquals('NwManager\Entities\Project', $repo->model());
    }

    public function testIsOwner()
    {
        $project = m::mock('ProjectEntitity');
        $project->shouldReceive('isOwner')->once()->ordered()->andReturn(true);
        $project->shouldReceive('isOwner')->once()->ordered()->andReturn(false);

        $repo = m::mock('NwManager\Repositories\Eloquent\ProjectEloquentRepository[find]', [$this->app]);
        $repo->shouldReceive('find')->once()->ordered()->with(2)->andReturn($project);
        $repo->shouldReceive('find')->once()->ordered()->with(4)->andReturn($project);

        $this->assertTrue($repo->isOwner(2,3));
        $this->assertFalse($repo->isOwner(4,1));
    }
}

