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
        $this->middleware('project.owner');
    }

    /**
     * Members
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function members($id)
    {
        $project = $this->repo->find($id);

        return $project->members()->get();
    }

    /**
     * Notes
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function notes($id)
    {
        $project = $this->repo->find($id);

        return $project->notes()->get();
    }

    /**
     * Tasks
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function tasks($id)
    {
        $project = $this->repo->find($id);

        return $project->tasks()->get();
    }
}
