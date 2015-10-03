<?php

namespace NwManager\Http\Middleware;

use Closure;
use NwManager\Repositories\Contracts\ProjectRepository;
use Illuminate\Contracts\Auth\Guard;

class CheckProjectMember
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
        $projectId = intval($request->route('project'));
        $userId = $this->auth->id();

        $project = $this->repository->find($projectId);

        if (!$project->isOwner($userId) && !$project->hasMember($userId)) {
             abort(403, 'Access Forbidden');
        }

        return $next($request);
    }
}
