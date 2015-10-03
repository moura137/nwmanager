<?php

namespace NwManager\Http\Middleware;

use Closure;
use NwManager\Repositories\Contracts\ProjectFileRepository;
use Illuminate\Contracts\Auth\Guard;

class CheckProjectFileUser
{
    /**
     * The repository Project File
     *
     * @var ProjectFileRepository
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
     * @param ProjectFileRepository $repository
     */
    public function __construct(ProjectFileRepository $repository, Guard $auth)
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
        $fileId = intval($request->route('file'));
        $userId = $this->auth->id();

        $file = $this->repository->find($fileId);

        if (! ($file->project->isOwner($userId) || ($file->isUser($userId) && $file->project->hasMember($userId))))
        {
             abort(403, 'Access Forbidden');
        }
        
        return $next($request);
    }
}
