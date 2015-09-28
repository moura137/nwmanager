<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ProjectFileRepository;
use NwManager\Services\ProjectFileService;
use Illuminate\Http\Request;
use NwManager\Repositories\Criterias\InputCriteria;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProjectFileController
 *
 * @package NwManager\Http\Controllers;
 */
class ProjectFileController extends Controller
{
    use Traits\RestFullTrait;

    /**
     * Construct ProjectFileController
     *
     * @param ProjectFileRepository $repo
     * @param ProjectFileService    $service
     */
    public function __construct(ProjectFileRepository $repo, ProjectFileService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
        $this->withRelations = ['user', 'project'];
        $this->orderBy = 'description ASC';
        $this->middleware('project.member', ['except' => ['destroy']]);
        $this->middleware('project-file.user', ['only' => ['destroy']]);
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

    /**
     * Remove All
     *
     * @param Request $request
     * @param int     $project_id
     * @param int     $id
     *
     * @return Response
     */
    public function destroyAll(Request $request, $project_id)
    {
        $files = $request->get('files');

        $result = $this->service->deleteAll($files, $project_id);

        if (!$result) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return response()
                ->json(['result' => $result], 200);
    }

    /**
     * Download
     *
     * @param  int  $project_id
     * @param  int  $id
     * @return Response
     */
    public function download($project_id, $id)
    {
        $data = $this->service->getFile($id, ['project_id' => $project_id]);

        return response()
                ->json(['data' => $data], 200);
    }
}
