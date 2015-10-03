<?php

namespace NwManager\Http\Middleware;

use Closure;
use NwManager\Repositories\Contracts\ProjectNoteRepository;
use Illuminate\Contracts\Auth\Guard;

class CheckProjectNoteUser
{
    /**
     * The repository Project Note
     *
     * @var ProjectNoteRepository
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
     * @param ProjectNoteRepository $repository
     */
    public function __construct(ProjectNoteRepository $repository, Guard $auth)
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
        $noteId = intval($request->route('note'));
        $userId = $this->auth->id();

        $note = $this->repository->find($noteId);

        if (! ($note->project->isOwner($userId) || ($note->isUser($userId) && $note->project->hasMember($userId))))
        {
             abort(403, 'Access Forbidden');
        }

        return $next($request);
    }
}
