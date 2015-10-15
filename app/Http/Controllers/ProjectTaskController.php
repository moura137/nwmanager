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
            ->orderBy('status', 'ASC')
            ->orderBy('due_date', 'ASC')
            ->orderBy('id', 'DESC')
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

        $entity = $this->service->create($data);

        if (!$entity) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        activity('Criou nova tarefa', $entity);

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

        $criterias = ['project_id' => $project_id];

        $entity = $this->service->update($id, $data, $criterias);

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

        $criterias = ['project_id' => $project_id];

        $success = $this->service->delete($id, $data, $criterias);

        if (!$success) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return response()
                ->json(['error' => null], 204);
    }

    /**
     * Update for finish Task
     *
     * @param Request $request
     * @param int     $project_id
     * @param int     $id
     *
     * @return Response
     */
    public function finish(Request $request, $project_id, $id)
    {
        $task = $this->repo
            ->with($this->withRelations)
            ->pushCriteria(new InputCriteria(['project_id' => $project_id]))
            ->find($id);

        $success = $this->service->finishTask($task);

        $data = ['success' => $success, 'task' => $task->presenter()['data']];

        if (!$success) {
            return response()->json($data, 422);
        }

        return response()->json($data);
    }
}
