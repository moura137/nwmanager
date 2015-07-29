<?php

namespace Tests\Entities;

use Tests\TestCase;
use Mockery as m;
use NwManager\Entities\ProjectNote;

class ProjectNoteEntityTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $client = new ProjectNote;

        $this->assertInstanceOf('NwManager\Entities\AbstractEntity', $client);
        
        $fillable = ['project_id','title','note'];
        $this->assertAttributeEquals($fillable, 'fillable', $client);
    }

    public function testProject()
    {
        $relation = m::mock('Illuminate\Database\Eloquent\Relations\BelongsTo');

        $client = m::mock('NwManager\Entities\ProjectNote[belongsTo]');
        $client->shouldReceive('belongsTo')->once()->with('NwManager\Entities\Project')->andReturn($relation);

        $this->assertEquals($relation, $client->project());
    }
}

