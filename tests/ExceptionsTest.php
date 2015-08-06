<?php

namespace Tests;

use Tests\TestCase;
use Mockery as m;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionsTest extends TestCase
{
    public function setup()
    {
        parent::setUp();
        $authorizer = m::mock('LucaDegasperi\OAuth2Server\Authorizer');
        $authorizer->shouldReceive('validateAccessToken')->andReturn(true);
        $authorizer->shouldReceive('hasScope')->andReturn(true);
        
        $this->app->instance('oauth2-server.authorizer', $authorizer);
    }

    public function testPageNotFound()
    {
        $this->get('/not-found')
            ->seeStatusCode(404);
    }

    public function testPageThrowException()
    {
        $repo = m::mock('NwManager\Repositories\Contracts\UserRepository');
        $this->app->instance('NwManager\Repositories\Contracts\UserRepository', $repo);

        $repo->shouldReceive('skipPresenter')
            ->once()
            ->with(false)
            ->andReturn($repo)
            ->getMock()

            ->shouldReceive('pushCriteria')
            ->once()
            ->andThrow(new \Exception);

        $this->get('/user')
            ->seeStatusCode(500);
    }

    public function testPageThrowModelNotFoundException()
    {
        $repo = m::mock('NwManager\Repositories\Contracts\UserRepository');
        $this->app->instance('NwManager\Repositories\Contracts\UserRepository', $repo);

        $repo->shouldReceive('skipPresenter')
            ->once()
            ->with(false)
            ->andReturn($repo)
            ->getMock()

            ->shouldReceive('pushCriteria')
            ->once()
            ->andThrow(new ModelNotFoundException);

        $this->get('/user')
            ->seeStatusCode(404);
    }

    public function testPageThrowHttpException()
    {
        $repo = m::mock('NwManager\Repositories\Contracts\UserRepository');
        $this->app->instance('NwManager\Repositories\Contracts\UserRepository', $repo);

        $repo->shouldReceive('skipPresenter')
            ->once()
            ->with(false)
            ->andReturn($repo)
            ->getMock()

            ->shouldReceive('pushCriteria')
            ->once()
            ->andThrow(new HttpException(403));

        $this->get('/user')
            ->seeStatusCode(403);
    }
}