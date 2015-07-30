<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ProjectRepository;
use NwManager\Services\ProjectService;

/**
 * Class ProjectController
 *
 * @package NwManager\Http\Controllers;
 */
class ProjectController extends Controller
{
    use Traits\RestFullTrait;

    /**
     * Construct ProjectController
     *
     * @param ProjectRepository $repo
     * @param ProjectService    $service
     */
    public function __construct(ProjectRepository $repo, ProjectService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
        $this->withRelations = ['client', 'owner'];
    }

    /**
     * Members
     *
     * @param  int $id [description]
     *
     * @return JsonResponse
     */
    public function members($id)
    {
        $project = $this->repo->find($id);

        return $project->members()->get();
    }
}
