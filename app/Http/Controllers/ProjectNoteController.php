<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ProjectNoteRepository;
use NwManager\Services\ProjectNoteService;
use Illuminate\Http\Request;
use NwManager\Repositories\Criterias\InputCriteria;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProjectNoteController
 *
 * @package NwManager\Http\Controllers;
 */
class ProjectNoteController extends Controller
{
    /**
     * @var \NwManager\Repositories\Contracts\AbstractRepository
     */
    protected $repo;

    /**
     * @var \NwManager\Services\AbstractService
     */
    protected $service;

     /**
     * @var array
     */
    protected $withRelations = [];

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
        $this->withRelations = ['user', 'project'];
        $this->orderBy = 'updated_at DESC';
        $this->middleware('project.member', ['except' => ['destroy']]);
        $this->middleware('project-note.user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @param  int      $project_id
     *
     * @return Response
     */
    public function index(Request $request, $project_id)
    {
        $data = $request->all();
        $data['project_id'] = $project_id;

        return $this->repo
            ->skipPresenter(false)
            ->pushCriteria(new InputCriteria($data))
            ->with($this->withRelations)
            ->orderBy($this->orderBy)
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  int      $project_id
     * @return Response
     */
    public function store(Request $request, $project_id)
    {
        $data = $request->all();
        $data['project_id'] = $project_id;
        $data['user_id'] = Auth::id();

        $entity = $this->service->create($data);

        if (!$entity) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return response()->json($entity->presenter(), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $project_id, $id)
    {
        $data = $request->all();
        $data['project_id'] = $project_id;

        $entity = $this->service->update($id, $data);

        if (!$entity) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return response()->json($entity->presenter());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $project_id
     * @param  int  $id
     * @return Response
     */
    public function show($project_id, $id)
    {
        return $this->repo
            ->with($this->withRelations)
            ->pushCriteria(new InputCriteria(['project_id' => $project_id]))
            ->find($id)
            ->presenter();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int     $project_id
     * @param int     $id
     *
     * @return Response
     */
    public function destroy(Request $request, $project_id, $id)
    {
        $data = $request->all();
        $data['project_id'] = $project_id;

        $success = $this->service->delete($id, $data);

        if (!$success) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return response()
                ->json(['error' => null], 204);
    }
}
