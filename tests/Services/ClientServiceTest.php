<?php

namespace Tests\Services;

use Tests\TestCase;
use Mockery as m;
use NwManager\Services\ClientService;

class ClientServiceTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $repo = m::mock('NwManager\Repositories\Contracts\ClientRepository');
        $validator = m::mock('NwManager\Validators\ClientValidator');

        $serv = new ClientService($repo, $validator);

        $this->assertInstanceOf('NwManager\Services\AbstractService', $serv);
        
        $this->assertAttributeEquals($repo, 'repository', $serv);
        $this->assertAttributeEquals($validator, 'validator', $serv);
    }

    public function testDeleteWithProjects()
    {
        $projects = new \Illuminate\Support\Collection(['project1', 'project2']);

        $entity = m::mock('NwManager\Entities\Client[projects,delete]');
        $entity->shouldReceive('projects')->once()->andReturn($projects);
        $entity->shouldReceive('delete')->never();

        $repo = m::mock('NwManager\Repositories\Contracts\ClientRepository');
        $repo->shouldReceive('find')->once()->with(1)->andReturn($entity);
        $repo->shouldReceive('delete')->never();

        $validator = m::mock('NwManager\Validators\ClientValidator');

        $serv = new ClientService($repo, $validator);

        $this->assertFalse($serv->delete(1));

        $errors = ['error' => 'validation_exception', 'error_description' => ['projects' => [trans('services.exists_projects', ['count' => 2])]]];
        $this->assertAttributeEquals($errors, 'errors', $serv);
    }

    public function testDeleteSuccess()
    {
        $projects = new \Illuminate\Support\Collection();

        $entity = m::mock('NwManager\Entities\Client[projects,delete]');
        $entity->id = 1;
        $entity->shouldReceive('projects')->once()->andReturn($projects);
        $entity->shouldReceive('delete')->never();

        $repo = m::mock('NwManager\Repositories\Contracts\ClientRepository');
        $repo->shouldReceive('find')->once()->with(1)->andReturn($entity);
        $repo->shouldReceive('delete')->once()->with(1)->andReturn(true);

        $validator = m::mock('NwManager\Validators\ClientValidator');

        $serv = new ClientService($repo, $validator);

        $this->assertTrue($serv->delete(1));

        $this->assertAttributeEquals([], 'errors', $serv);
    }
}

