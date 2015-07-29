<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ProjectTaskRepository;
use NwManager\Services\ProjectTaskService;

/**
 * Class ProjectTaskController
 *
 * @package NwManager\Http\Controllers;
 */
class ProjectTaskController extends Controller
{
    use Traits\RestFullTrait;

    /**
     * Construct ProjectTaskController
     *
     * @param ProjectTaskRepository $repo
     * @param ProjectTaskService    $service
     */
    public function __construct(ProjectTaskRepository $repo, ProjectTaskService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
        $this->withRelations = ['project'];
    }
}
