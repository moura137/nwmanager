<?php

namespace NwManager\Http\Controllers;

use Illuminate\Http\Request;
use NwManager\Repositories\Contracts\ClientRepository;
use NwManager\Services\ClientService;

class ClientController extends Controller
{
    /**
     * @var ClientRepository
     */
    protected $repo;

    /**
     * @var ClientService
     */
    protected $service;

    public function __construct(ClientRepository $repo, ClientService $service)
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
        return $this->repo->all();
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->repo->find($id);
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
        return $this->service->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->repo->find($id)->delete();

        return response()
                ->json(['error' => null], 204);
    }
}
