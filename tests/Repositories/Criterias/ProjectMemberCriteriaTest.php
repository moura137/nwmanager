<?php

namespace Tests\Repositories\Criterias;

use Tests\TestCase;
use Mockery as m;
use NwManager\Repositories\Criterias\ProjectMemberCriteria;

class ProjectMemberCriteriaTest extends TestCase
{
    public function testApply()
    {
        \Authorizer::shouldReceive('getResourceOwnerId')->once()->andReturn(4);

        $closure = function(){};
        
        $newQuery = m::mock('Illuminate\Database\Query\Builder');
        $newQuery->shouldReceive('orWhere')->once()->ordered()->with('projects.owner_id', 4)->andReturn($newQuery);
        $newQuery->shouldReceive('orWhere')->once()->ordered()->with('project_members.user_id', 4)->andReturn($newQuery);

        $query = m::mock('Illuminate\Database\Eloquent\Builder');
        $query->shouldReceive('leftJoin')->once()->ordered()
            ->with('project_members', 'projects.id', '=', 'project_members.project_id')
            ->andReturn($query);
        $query->shouldReceive('select')->once()->ordered()
            ->with('projects.*')
            ->andReturn($query);
        $query->shouldReceive('groupBy')->once()->ordered()
            ->with('projects.id')
            ->andReturn($query);
        
        $query->shouldReceive('where')
            ->once()
            ->ordered()
            ->andReturnUsing(function($test) use ($newQuery, $query) {
                $test($newQuery);
                return $query;
            });
        
        $repo = m::mock('Prettus\Repository\Contracts\RepositoryInterface');
        
        $criteria = new ProjectMemberCriteria;
        $this->assertEquals($query, $criteria->apply($query, $repo));
    }
}