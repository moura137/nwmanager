<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ProjectNoteRepository;
use NwManager\Services\ProjectNoteService;

/**
 * Class ProjectNoteController
 *
 * @package NwManager\Http\Controllers;
 */
class ProjectNoteController extends Controller
{
    use Traits\RestFullTrait;

    /**
     * Construct ProjectNoteController
     *
     * @param ProjectNoteRepository $repo
     * @param ProjectNoteService    $service
     */
    public function __construct(ProjectNoteRepository $repo, ProjectNoteService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
        $this->withRelations = ['project'];
    }
}
