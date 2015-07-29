<?php

namespace Tests\Entities;

use Tests\TestCase;
use Mockery as m;
use NwManager\Entities\Project;

class ProjectEntityTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $project = new Project;

        $this->assertInstanceOf('NwManager\Entities\AbstractEntity', $project);
        
        $fillable = ['owner_id','client_id','name','description','progress','status','due_date'];
        $this->assertAttributeEquals($fillable, 'fillable', $project);
    }

    public function testOwner()
    {
        $relation = m::mock('Illuminate\Database\Eloquent\Relations\BelongsTo');

        $project = m::mock('NwManager\Entities\Project[belongsTo]');
        $project->shouldReceive('belongsTo')->once()->with('NwManager\Entities\User')->andReturn($relation);

        $this->assertEquals($relation, $project->owner());
    }

    public function testClient()
    {
        $relation = m::mock('Illuminate\Database\Eloquent\Relations\BelongsTo');

        $project = m::mock('NwManager\Entities\Project[belongsTo]');
        $project->shouldReceive('belongsTo')->once()->with('NwManager\Entities\Client')->andReturn($relation);

        $this->assertEquals($relation, $project->client());
    }

    public function testNotes()
    {
        $relation = m::mock('Illuminate\Database\Eloquent\Relations\HasMany');

        $project = m::mock('NwManager\Entities\Project[hasMany]');
        $project->shouldReceive('hasMany')->once()->with('NwManager\Entities\ProjectNote')->andReturn($relation);

        $this->assertEquals($relation, $project->notes());
    }

    public function testTasks()
    {
        $relation = m::mock('Illuminate\Database\Eloquent\Relations\HasMany');

        $project = m::mock('NwManager\Entities\Project[hasMany]');
        $project->shouldReceive('hasMany')->once()->with('NwManager\Entities\ProjectTask')->andReturn($relation);

        $this->assertEquals($relation, $project->tasks());
    }
}

