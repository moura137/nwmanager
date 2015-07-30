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

    /**
     * Example:
     */ 
        // $criteira = new InputCriteria($request->all());
        // $query = $project->members()->getQuery();
        // $query = $criteira->apply($query, $this->repo);
        // return $query->get();
    
    // public function testActionMembersWithInputCriteria()
    // {
    //     $return = ['user1', 'user2'];
        
    //     $model = m::mock('Model');
    //     $model->shouldReceive('columns')->once();

    //     $query = m::mock('QueryBuilder');
    //     $query->shouldReceive('get')->once()->andReturn($return);
    //     $query->shouldReceive('getModel')->once()->andReturn($model);

    //     $relation = m::mock('Relation');
    //     $relation->shouldReceive('getQuery')
    //         ->once()
    //         ->andReturn($query);

    //     $project = m::mock('ProjectEntity');
    //     $project->shouldReceive('members')
    //         ->once()
    //         ->andReturn($relation);

    //     $this->repo
    //         ->shouldReceive('find')
    //         ->once()
    //         ->with( 3 )
    //         ->andReturn($project);

    //     $this->visit($this->resource.'/3/members')
    //         ->seeJsonEquals($return);
    // }
}
