<?php

namespace Tests\Http\Middleware;

use Tests\TestCase;
use Mockery as m;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use NwManager\Http\Middleware\CheckProjectOwner;

class CheckProjectOwnerTest extends TestCase
{
    public function testHandleOwnerTrue()
    {
        $request = new \stdClass;
        $request->project = 1;
        $next = function($req) { return $req; };

        Authorizer::shouldReceive('getResourceOwnerId')->once()->andReturn(3);

        $repo = m::mock('NwManager\Repositories\Contracts\ProjectRepository');
        $repo->shouldReceive('isOwner')->once()->with(1, 3)->andReturn(true);

        $middleware = new CheckProjectOwner($repo);
        $this->assertEquals($request, $middleware->handle($request, $next));
    }

    public function testHandleOwnerForbidden()
    {
        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\HttpException', 'Access Forbidden');

        $request = new \stdClass;
        $request->project = 1;
        $next = function($req) { return $req; };
        
        Authorizer::shouldReceive('getResourceOwnerId')->once()->andReturn(3);

        $repo = m::mock('NwManager\Repositories\Contracts\ProjectRepository');
        $repo->shouldReceive('isOwner')->once()->with(1, 3)->andReturn(false);

        $middleware = new CheckProjectOwner($repo);
        $middleware->handle($request, $next);
    }
}
