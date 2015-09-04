<?php

namespace NwManager\Http\Middleware;

use Closure;
use NwManager\Repositories\Contracts\ProjectRepository;
use Illuminate\Contracts\Auth\Guard;

class CheckProjectOwner
{
    /**
     * The repository Project
     *
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * The guard instance.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Construct
     *
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectRepository $repository, Guard $auth)
    {
        $this->repository = $repository;
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $projectId = intval($request->project);
        $userId = $this->auth->id();

        $isOwner = $this->repository->isOwner($projectId, $userId);

        if (!$isOwner) {
             abort(403, 'Access Forbidden');
        }
        
        return $next($request);
    }
}
