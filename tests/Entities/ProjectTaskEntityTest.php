<?php

namespace Tests\Entities;

use Tests\TestCase;
use Mockery as m;
use NwManager\Entities\ProjectTask;

class ProjectTaskEntityTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $client = new ProjectTask;

        $this->assertInstanceOf('NwManager\Entities\AbstractEntity', $client);
        
        $fillable = ['project_id','name','start_date', 'due_date', 'status'];
        $this->assertAttributeEquals($fillable, 'fillable', $client);
    }

    public function testProject()
    {
        $relation = m::mock('Illuminate\Database\Eloquent\Relations\BelongsTo');

        $client = m::mock('NwManager\Entities\ProjectTask[belongsTo]');
        $client->shouldReceive('belongsTo')->once()->with('NwManager\Entities\Project')->andReturn($relation);

        $this->assertEquals($relation, $client->project());
    }
}

