<?php

namespace NwManager\Http\Controllers\Traits;

use Illuminate\Http\Request;
use NwManager\Repositories\Criterias\InputCriteria;

/**
 * Trait RestFull
 *
 * @package NwManager\Http\Controllers\Traits;
 */
trait RestFullTrait
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
     * @var string
     */
    protected $orderBy = "";

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
            ->with($this->withRelations)
            ->orderBy($this->orderBy)
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $entity = $this->service->create($request->all());

        if (!$entity) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return response()->json($entity->presenter(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->repo
            ->with($this->withRelations)
            ->find($id)
            ->presenter();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $entity = $this->service->update($id, $request->all());

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
     * @param int     $id
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $success = $this->service->delete($id, $request->all());

        if (!$success) {
            $errors = $this->service->errors();
            return response()->json($errors, 422);
        }

        return response()
                ->json(['error' => null], 204);
    }
}
