<?php

namespace NwManager\Http\Middleware;

use Closure;
use NwManager\Repositories\Contracts\ProjectNoteRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class CheckProjectNoteUser
{
    protected $repository;

    /**
     * Construct
     *
     * @param ProjectNoteRepository $repository
     */
    public function __construct(ProjectNoteRepository $repository)
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
        $noteId = intval($request->note);
        $userId = Authorizer::getResourceOwnerId();

        $note = $this->repository->find($noteId);

        if (!$note->isUser($userId) && !$note->project->isOwner($userId)) {
             abort(403, 'Access Forbidden');
        }
        
        return $next($request);
    }
}
