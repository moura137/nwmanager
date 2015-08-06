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
        $this->assertEquals('NwManager\Presenters\ProjectPresenter', $repo->presenter());
    }

    public function testIsOwner()
    {
        $project = m::mock('ProjectEntitity');
        $project->shouldReceive('isOwner')->once()->with(3)->ordered()->andReturn(true);
        $project->shouldReceive('isOwner')->once()->with(1)->ordered()->andReturn(false);

        $repo = m::mock('NwManager\Repositories\Eloquent\ProjectEloquentRepository[find]', [$this->app]);
        $repo->shouldReceive('find')->once()->ordered()->with(2)->andReturn($project);
        $repo->shouldReceive('find')->once()->ordered()->with(4)->andReturn($project);

        $this->assertTrue($repo->isOwner(2,3));
        $this->assertFalse($repo->isOwner(4,1));
    }

    public function testHasMember()
    {
        $project = m::mock('ProjectEntitity');
        $project->shouldReceive('hasMember')->once()->with(3)->ordered()->andReturn(true);
        $project->shouldReceive('hasMember')->once()->with(1)->ordered()->andReturn(false);

        $repo = m::mock('NwManager\Repositories\Eloquent\ProjectEloquentRepository[find]', [$this->app]);
        $repo->shouldReceive('find')->once()->ordered()->with(2)->andReturn($project);
        $repo->shouldReceive('find')->once()->ordered()->with(4)->andReturn($project);

        $this->assertTrue($repo->hasMember(2,3));
        $this->assertFalse($repo->hasMember(4,1));
    }
}

