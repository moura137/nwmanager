<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ProjectNoteRepository;
use NwManager\Services\ProjectNoteService;
use Illuminate\Http\Request;
use NwManager\Repositories\Criterias\InputCriteria;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

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
        $this->withRelations = ['project'];
        $this->middleware('project.member');
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
        $data['user_id'] = Authorizer::getResourceOwnerId();
        
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
}
