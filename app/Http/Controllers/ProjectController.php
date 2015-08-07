<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ProjectRepository;
use NwManager\Services\ProjectService;
use Illuminate\Http\Request;
use NwManager\Repositories\Criterias\InputCriteria;
use NwManager\Repositories\Criterias\ProjectMemberCriteria;

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
        $this->withRelations = ['client', 'owner', 'members'];
        $this->middleware('project.member', ['except' => ['index', 'store', 'destroy']]);
        $this->middleware('project.owner', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->repo
            ->skipPresenter(false)
            ->pushCriteria(new InputCriteria($request->all()))
            ->pushCriteria(new ProjectMemberCriteria)
            ->with($this->withRelations)
            ->all();
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
}
