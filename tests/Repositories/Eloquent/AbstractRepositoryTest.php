<?php

namespace Tests\Repositories\Eloquent;

use Tests\TestCase;
use Mockery as m;
use NwManager\Repositories\Eloquent\AbstractEloquentRepository;

class AbstractRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->model = m::mock('NwManager\Entities\AbstractEntity');
        $this->app->instance('NwManager\Entities\AbstractEntity', $this->model);

    }

    public function testImplementsInstanceOf()
    {
        $repo = new StubAbstract($this->app);

        $this->assertInstanceOf('NwManager\Repositories\Contracts\AbstractRepository', $repo);
        $this->assertInstanceOf('NwManager\Repositories\Eloquent\AbstractEloquentRepository', $repo);
        $this->assertInstanceOf('Prettus\Repository\Eloquent\BaseRepository', $repo);
    }

    public function testLists()
    {
        $lists = ['1' => 'Foo', '2' => 'Bar'];

        $this->model
            ->shouldReceive('lists')
            ->once()
            ->with('name', 'id')
            ->andReturn($lists);

        $repo = new StubAbstract($this->app);

        $this->assertEquals($lists, $repo->lists('name', 'id'));

    }
}

class StubAbstract extends \NwManager\Repositories\Eloquent\AbstractEloquentRepository
{
    public function model()
    {
        return 'NwManager\Entities\AbstractEntity';
    }
}

