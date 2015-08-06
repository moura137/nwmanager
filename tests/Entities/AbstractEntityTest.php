<?php

namespace Tests\Entities;

use Tests\TestCase;
use Mockery as m;

class AbstractEntityTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $abstract = m::mock('NwManager\Entities\AbstractEntity[]');

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $abstract);
        $this->assertInstanceOf('Prettus\Repository\Contracts\Transformable', $abstract);
        $this->assertInstanceOf('Prettus\Repository\Contracts\Presentable', $abstract);
    }

    public function testColumns()
    {
        $columns = ['foo', 'Baz', 'id'];

        $conn = m::mock('Illuminate\Database\ConnectionInterface');
        $conn->shouldReceive('getSchemaBuilder')->once()->andReturn($conn);
        $conn->shouldReceive('getColumnListing')->once()->andReturn($columns);

        $abstract = m::mock('NwManager\Entities\AbstractEntity[getTable, getConnection]');
        $abstract->shouldReceive('getTable')->once()->andReturn('foobars');
        $abstract->shouldReceive('getConnection')->once()->andReturn($conn);

        $this->assertEquals(array_map('strtolower', $columns), $abstract->columns());
        $this->assertTrue($abstract->isColumn('BAZ'));
    }

    public function testSetAttribute()
    {
        $abstract = m::mock('NwManager\Entities\AbstractEntity[]');
        $abstract->foo = '';
        $abstract->bar = '0';
        $abstract->baz = 'test';
        $abstract->foz = 0;

        $this->assertSame(null, $abstract->foo);
        $this->assertSame("0", $abstract->bar);
        $this->assertSame("test", $abstract->baz);
        $this->assertSame(0, $abstract->foz);
    }
}
