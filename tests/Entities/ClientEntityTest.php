<?php

namespace Tests\Entities;

use Tests\TestCase;
use Mockery as m;
use NwManager\Entities\Client;

class ClientEntityTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $client = new Client;

        $this->assertInstanceOf('NwManager\Entities\AbstractEntity', $client);
        
        $fillable = ['name','responsible','email','phone','address', 'obs'];
        $this->assertAttributeEquals($fillable, 'fillable', $client);
    }

    public function testProjects()
    {
        $relation = m::mock('Illuminate\Database\Eloquent\Relations\HasMany');

        $client = m::mock('NwManager\Entities\Client[hasMany]');
        $client->shouldReceive('hasMany')->once()->with('NwManager\Entities\Project')->andReturn($relation);

        $this->assertEquals($relation, $client->projects());
    }
}

