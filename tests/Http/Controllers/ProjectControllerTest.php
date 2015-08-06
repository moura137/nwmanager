<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use Mockery as m;

class ProjectControllerTest extends TestCase
{
    use Traits\TraitTestRestFull;

    protected $resource = '/project';

    protected $nameRepo = 'NwManager\Repositories\Contracts\ProjectRepository';

    protected $nameServ = 'NwManager\Services\ProjectService';

    protected $withRelations = ['client', 'owner'];

    public function testActionIndex()
    {
        $return = ['record1', 'record2'];

        $query = m::mock('QueryBuilder');
        $query->shouldReceive('all')->once()->withNoArgs()->andReturn($return);

        $this->repo
            ->shouldReceive('with')
            ->once()
            ->with( $this->withRelations )
            ->andReturn($query)

            ->getMock()
            ->shouldReceive('pushCriteria')
            ->twice()
            ->andReturn($this->repo);

        $this->visit($this->resource)
            ->seeJsonEquals($return);
    }

    public function testActionMembers()
    {
        $return = ['user1', 'user2'];
        
        $relation = m::mock('Relation');
        $relation->shouldReceive('get')
            ->once()
            ->andReturn($return);

        $project = m::mock('ProjectEntity');
        $project->shouldReceive('members')
            ->once()
            ->andReturn($relation);

        $this->repo
            ->shouldReceive('find')
            ->once()
            ->with( 3 )
            ->andReturn($project);

        $this->visit($this->resource.'/3/members')
            ->seeJsonEquals($return);
    }

    public function testActionNotes()
    {
        $return = ['note1', 'note2'];
        
        $relation = m::mock('Relation');
        $relation->shouldReceive('get')
            ->once()
            ->andReturn($return);

        $project = m::mock('ProjectEntity');
        $project->shouldReceive('notes')
            ->once()
            ->andReturn($relation);

        $this->repo
            ->shouldReceive('find')
            ->once()
            ->with( 4 )
            ->andReturn($project);

        $this->visit($this->resource.'/4/notes')
            ->seeJsonEquals($return);
    }

    public function testActionTasks()
    {
        $return = ['task1', 'task2'];
        
        $relation = m::mock('Relation');
        $relation->shouldReceive('get')
            ->once()
            ->andReturn($return);

        $project = m::mock('ProjectEntity');
        $project->shouldReceive('tasks')
            ->once()
            ->andReturn($relation);

        $this->repo
            ->shouldReceive('find')
            ->once()
            ->with( 4 )
            ->andReturn($project);

        $this->visit($this->resource.'/4/tasks')
            ->seeJsonEquals($return);
    }
}
