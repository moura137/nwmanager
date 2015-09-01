<?php

namespace NwManager\Http\Middleware;

use Closure;
use NwManager\Repositories\Contracts\ProjectFileRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class CheckProjectFileUser
{
    protected $repository;

    /**
     * Construct
     *
     * @param ProjectFileRepository $repository
     */
    public function __construct(ProjectFileRepository $repository)
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
        $fileId = intval($request->file);
        $userId = Authorizer::getResourceOwnerId();

        $file = $this->repository->find($fileId);

        if (!$file->isUser($userId) && !$file->project->isOwner($userId)) {
             abort(403, 'Access Forbidden');
        }
        
        return $next($request);
    }
}
