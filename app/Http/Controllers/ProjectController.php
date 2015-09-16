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
        $this->orderBy = 'name ASC';
        $this->middleware('project.member', ['only' => ['show']]);
        $this->middleware('project.owner', ['only' => ['update', 'addMember', 'removeMember', 'syncMember', 'destroy']]);
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
            ->orderBy($this->orderBy)
            ->paginate();
    }

    /**
     * Add Members
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function addMember(Request $request, $id)
    {
        $members = $request->get('members');

        if (!$this->service->addMember($id, $members)) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return $this->repo->find($id)->members;
    }

    /**
     * Remove Members
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function removeMember(Request $request, $id)
    {
        $members = $request->get('members');

        if (!$this->service->removeMember($id, $members)) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return $this->repo->find($id)->members;
    }

    /**
     * Sync Member
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function syncMember(Request $request, $id)
    {
        $members = $request->get('members');

        if (!$this->service->syncMember($id, $members)) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return $this->repo->find($id)->members;
    }
}
