<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ProjectTaskRepository;
use NwManager\Services\ProjectTaskService;
use Illuminate\Http\Request;
use NwManager\Repositories\Criterias\InputCriteria;

/**
 * Class ProjectTaskController
 *
 * @package NwManager\Http\Controllers;
 */
class ProjectTaskController extends Controller
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
        $this->middleware('project.member', ['except' => ['destroy']]);
        $this->middleware('project.owner', ['only' => ['destroy']]);
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
            ->with($this->withRelations)
            ->pushCriteria(new InputCriteria($data))
            ->all();
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
        
        $entity = $this->service->create($data);

        if (!$entity) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return response()->json($entity->presenter(), 201);
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $project_id
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