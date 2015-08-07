<?php

namespace NwManager\Http\Middleware;

use Closure;
use NwManager\Repositories\Contracts\ProjectRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class CheckProjectOwner
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

        $isOwner = $this->repository->isOwner($projectId, $userId);

        if (!$isOwner) {
             abort(403, 'Access Forbidden');
        }
        
        return $next($request);
    }
}