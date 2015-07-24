<?php

namespace NwManager\Http\Controllers;

use Illuminate\Http\Request;
use NwManager\Repositories\Contracts\ProjectRepository;
use NwManager\Services\ProjectService;

/**
 * Class ProjectController
 *
 * @package NwManager\Http\Controllers;
 */
class ProjectController extends Controller
{
    /**
     * @var ProjectRepository
     */
    protected $repo;

    /**
     * @var ProjectService
     */
    protected $service;

    /**
     * @var array
     */
    protected $withRelations = ['client', 'owner'];

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->repo
            ->with($this->withRelations)
            ->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $entity = $this->service->create($request->all());

        if (!$entity) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        $entity = $entity->fresh($this->withRelations);

        return response()->json($entity, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->repo
            ->with($this->withRelations)
            ->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $entity = $this->service->update($id, $request->all());

        if (!$entity) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        $entity = $entity->fresh($this->withRelations);
        
        return response()->json($entity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $success = $this->service->delete($id);

        if (!$success) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return response()
                ->json(['error' => null], 204);
    }
}
