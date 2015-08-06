<?php

namespace NwManager\Http\Middleware;

use Closure;
use NwManager\Repositories\Contracts\ProjectRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class CheckProjectMember
{
    protected $repository;

    /**
     * Construct
     *
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
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
        $userId = Authorizer::getResourceOwnerId();

        $project = $this->repository->find($projectId);

        if (!$project->isOwner($userId) && !$project->hasMember($userId)) {
             abort(403, 'Access Forbidden');
        }

        return $next($request);
    }
}
