<?php

namespace Tests\Http\Middleware;

use Tests\TestCase;
use Mockery as m;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use NwManager\Http\Middleware\CheckProjectMember;

class CheckProjectMemberTest extends TestCase
{
    public function testHandleValid()
    {
        $request = new \stdClass;
        $request->project = 1;
        $next = function($req) { return $req; };

        Authorizer::shouldReceive('getResourceOwnerId')->once()->andReturn(3);

        $entity = m::mock('ProjectEntity');
        $entity->shouldReceive('isOwner')->once()->with(3)->andReturn(false);
        $entity->shouldReceive('hasMember')->once()->with(3)->andReturn(true);

        $repo = m::mock('NwManager\Repositories\Contracts\ProjectRepository');
        $repo->shouldReceive('find')->once()->with(1)->andReturn($entity);

        $middleware = new CheckProjectMember($repo);
        $this->assertEquals($request, $middleware->handle($request, $next));
    }

    public function testHandleForbidden()
    {
        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\HttpException', 'Access Forbidden');

        $request = new \stdClass;
        $request->project = 1;
        $next = function($req) { return $req; };
        
        Authorizer::shouldReceive('getResourceOwnerId')->once()->andReturn(3);

        $entity = m::mock('ProjectEntity');
        $entity->shouldReceive('isOwner')->once()->with(3)->andReturn(false);
        $entity->shouldReceive('hasMember')->once()->with(3)->andReturn(false);

        $repo = m::mock('NwManager\Repositories\Contracts\ProjectRepository');
        $repo->shouldReceive('find')->once()->with(1)->andReturn($entity);

        $middleware = new CheckProjectMember($repo);
        $middleware->handle($request, $next);
    }
}
