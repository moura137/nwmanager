<?php

namespace Tests\Http\Controllers\Traits;

use Mockery as m;
use Illuminate\Foundation\Testing\WithoutMiddleware;

trait TraitTestRestFull
{
    use WithoutMiddleware;

    protected $repo;

    protected $serv;

    public function setUp()
    {
        parent::setUp();

        $this->repo = m::mock($this->nameRepo);
        $this->app->instance($this->nameRepo, $this->repo);

        $this->serv = m::mock($this->nameServ);
        $this->app->instance($this->nameServ, $this->serv);
    }

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
            ->shouldReceive('skipPresenter')
            ->once()
            ->with(false)
            ->andReturn($this->repo)

            ->getMock()
            ->shouldReceive('pushCriteria')
            ->once()
            ->andReturn($this->repo);

        $this->visit($this->resource)
            ->seeJsonEquals($return);
    }

    public function testActionStoreSuccess()
    {
        $presenter = ['foobar' => 'test'];

        $entity = m::mock('AbstractEntity');
        $entity->shouldReceive('presenter')->once()->andReturn($presenter);

        $input = ['foo' => 'bar'];

        $this->serv
            ->shouldReceive('create')
            ->once()
            ->with($input)
            ->andReturn($entity)

            ->getMock()
            ->shouldReceive('errors')
            ->never();

        $this->post($this->resource, $input)
            ->seeStatusCode(201)
            ->seeJsonEquals($presenter);
    }

    public function testActionStoreError()
    {
        $input = ['foo' => 'bar'];
        $errors = ['err1', 'err2'];

        $this->serv
            ->shouldReceive('create')
            ->once()
            ->with($input)
            ->andReturn(null)

            ->getMock()
            ->shouldReceive('errors')
            ->once()
            ->andReturn($errors);

        $this->post($this->resource, $input)
            ->seeStatusCode(422)
            ->seeJsonEquals($errors);
    }

    public function testActionShow()
    {
        $presenter = ['field1', 'field2'];
        
        $entity = m::mock('AbstractEntity');
        $entity->shouldReceive('presenter')->once()->andReturn($presenter);

        $query = m::mock('QueryBuilder');
        $query->shouldReceive('find')->once()->with(2)->andReturn($entity);

        $this->repo
            ->shouldReceive('with')
            ->once()
            ->with( $this->withRelations )
            ->andReturn($query);

        $this->visit($this->resource . '/2')
            ->seeJsonEquals($presenter);
    }

    public function testActionUpdateSuccess()
    {
        $presenter = ['foobar' => 'test'];

        $entity = m::mock('AbstractEntity');
        $entity->shouldReceive('presenter')->once()->andReturn($presenter);

        $input = ['foo' => 'bar'];

        $this->serv
            ->shouldReceive('update')
            ->once()
            ->with(3, $input)
            ->andReturn($entity)

            ->getMock()
            ->shouldReceive('errors')
            ->never();

        $this->put($this->resource . '/3', $input)
            ->seeStatusCode(200)
            ->seeJsonEquals($presenter);
    }

    public function testActionUpdateError()
    {
        $input = ['foo' => 'bar'];
        $errors = ['err1', 'err2'];

        $this->serv
            ->shouldReceive('update')
            ->once()
            ->with(3, $input)
            ->andReturn(null)

            ->getMock()
            ->shouldReceive('errors')
            ->once()
            ->andReturn($errors);

        $this->put($this->resource . '/3', $input)
            ->seeStatusCode(422)
            ->seeJsonEquals($errors);
    }

    public function testActionDestroySuccess()
    {
        $this->serv
            ->shouldReceive('delete')
            ->once()
            ->with(4)
            ->andReturn(true)

            ->getMock()
            ->shouldReceive('errors')
            ->never();

        $this->delete($this->resource . '/4')
            ->seeStatusCode(204)
            ->seeJson();
    }

    public function testActionDestroyError()
    {
        $errors = ['err1', 'err2'];

        $this->serv
            ->shouldReceive('delete')
            ->once()
            ->with(4)
            ->andReturn(false)

            ->getMock()
            ->shouldReceive('errors')
            ->once()
            ->andReturn($errors);

        $this->delete($this->resource . '/4')
            ->seeStatusCode(422)
            ->seeJsonEquals($errors);
    }
}
