<?php

namespace Tests\Services;

use Tests\TestCase;
use Mockery as m;
use NwManager\Repositories\Contracts\AbstractRepository;
use NwManager\Validators\AbstractValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\MessageBag;

class AbstractServiceTest extends TestCase
{
    public function testCreateSuccess()
    {
        $data = ['foo' => 'bar'];

        $repo = m::mock('NwManager\Repositories\Contracts\AbstractRepository');
        $repo->shouldReceive('create')->once()->with($data)->andReturn(true);

        $validator = m::mock('NwManager\Validators\AbstractValidator');
        $validator->shouldReceive('with')->once()->with($data)->andReturn($validator);
        $validator->shouldReceive('passesOrFail')->once()->with('create')->andReturn(true);

        $serv = new StubAbstract($repo, $validator);
        
        $this->assertTrue($serv->create($data));
    }

    public function testCreateValidatorException()
    {
        $data = ['foo' => 'bar'];

        $repo = m::mock('NwManager\Repositories\Contracts\AbstractRepository');
        $repo->shouldReceive('create')->never();

        $messageBag = new MessageBag(['error_validation']);

        $validator = m::mock('NwManager\Validators\AbstractValidator');
        $validator->shouldReceive('with')->once()->with($data)->andReturn($validator);
        $validator->shouldReceive('passesOrFail')
            ->once()
            ->with('create')
            ->andThrow(new ValidatorException($messageBag));

        $serv = new StubAbstract($repo, $validator);
        
        $this->assertFalse($serv->create($data));
        $this->assertEquals(['error' => 'validation_exception', 'error_description' => $messageBag], $serv->errors());
    }

    public function testCreateThrowException()
    {
        $data = ['foo' => 'bar'];

        $repo = m::mock('NwManager\Repositories\Contracts\AbstractRepository');
        $repo->shouldReceive('create')->never();

        $validator = m::mock('NwManager\Validators\AbstractValidator');
        $validator->shouldReceive('with')->once()->with($data)->andReturn($validator);
        $validator->shouldReceive('passesOrFail')
            ->once()
            ->with('create')
            ->andThrow(new \Exception('ErroInterno'));

        $serv = new StubAbstract($repo, $validator);
        
        $this->assertFalse($serv->create($data));
        $this->assertEquals(['error' => 'error_internal', 'error_description' => 'ErroInterno'], $serv->errors());
    }

    public function testUpdateSuccess()
    {
        $data = ['foo' => 'bar'];
        $attributes = ['baz' => 'test'];

        $entity = m::mock('AbstractEntity');
        $entity->shouldReceive('fill')->once()->with($data);
        $entity->shouldReceive('toArray')->once()->andReturn($attributes);

        $repo = m::mock('NwManager\Repositories\Contracts\AbstractRepository');
        $repo->shouldReceive('find')->once()->with(5)->andReturn($entity);
        $repo->shouldReceive('update')->once()->with($attributes, 5)->andReturn(true);

        $validator = m::mock('NwManager\Validators\AbstractValidator');
        $validator->shouldReceive('with')->once()->with($attributes)->andReturn($validator);
        $validator->shouldReceive('setId')->once()->with(5)->andReturn($validator);
        $validator->shouldReceive('passesOrFail')->once()->with('update')->andReturn(true);

        $serv = new StubAbstract($repo, $validator);
        
        $this->assertTrue($serv->update(5, $data));
    }

    public function testUpdateValidatorException()
    {
        $data = ['foo' => 'bar'];
        $attributes = ['baz' => 'test'];

        $entity = m::mock('AbstractEntity');
        $entity->shouldReceive('fill')->once()->with($data);
        $entity->shouldReceive('toArray')->once()->andReturn($attributes);

        $repo = m::mock('NwManager\Repositories\Contracts\AbstractRepository');
        $repo->shouldReceive('find')->once()->with(5)->andReturn($entity);
        $repo->shouldReceive('update')->never();

        $messageBag = new MessageBag(['error_validation']);

        $validator = m::mock('NwManager\Validators\AbstractValidator');
        $validator->shouldReceive('with')->once()->with($attributes)->andReturn($validator);
        $validator->shouldReceive('setId')->once()->with(5)->andReturn($validator);
        $validator->shouldReceive('passesOrFail')
            ->once()
            ->with('update')
            ->andThrow(new ValidatorException($messageBag));

        $serv = new StubAbstract($repo, $validator);
        
        $this->assertFalse($serv->update(5, $data));
        $this->assertEquals(['error' => 'validation_exception', 'error_description' => $messageBag], $serv->errors());
    }

    public function testUpdateThrowException()
    {
        $data = ['foo' => 'bar'];
        $attributes = ['baz' => 'test'];

        $entity = m::mock('AbstractEntity');
        $entity->shouldReceive('fill')->once()->with($data);
        $entity->shouldReceive('toArray')->once()->andReturn($attributes);

        $repo = m::mock('NwManager\Repositories\Contracts\AbstractRepository');
        $repo->shouldReceive('find')->once()->with(6)->andReturn($entity);
        $repo->shouldReceive('update')->never();

        $validator = m::mock('NwManager\Validators\AbstractValidator');
        $validator->shouldReceive('with')->once()->with($attributes)->andReturn($validator);
        $validator->shouldReceive('setId')->once()->with(6)->andReturn($validator);
        $validator->shouldReceive('passesOrFail')
            ->once()
            ->with('update')
            ->andThrow(new \Exception('ErroInterno'));

        $serv = new StubAbstract($repo, $validator);
        
        $this->assertFalse($serv->update(6, $data));
        $this->assertEquals(['error' => 'error_internal', 'error_description' => 'ErroInterno'], $serv->errors());
    }

    public function testDelete()
    {
        $repo = m::mock('NwManager\Repositories\Contracts\AbstractRepository');
        $repo->shouldReceive('delete')->once()->with(4)->andReturn(true);

        $validator = m::mock('NwManager\Validators\AbstractValidator');

        $serv = new StubAbstract($repo, $validator);
        
        $this->assertTrue($serv->delete(4));
    }
}

class StubAbstract extends \NwManager\Services\AbstractService
{
    public function __construct(AbstractRepository $repository, AbstractValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}

