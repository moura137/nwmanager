<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ClientRepository;
use NwManager\Services\ClientService;
use Illuminate\Http\Request;
use NwManager\Repositories\Criterias\InputCriteria;

/**
 * Class ClientController
 *
 * @package NwManager\Http\Controllers;
 */
class ClientController extends Controller
{
    use Traits\RestFullTrait;

    /**
     * Construct ClientController
     *
     * @param ClientRepository $repo
     * @param ClientService    $service
     */
    public function __construct(ClientRepository $repo, ClientService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
        $this->orderBy = 'name ASC';
    }

    /**
     * Display a listing limitando
     *
     * @return Response
     */
    public function limit(Request $request)
    {
        $limit = $request->get('limit', 10);

        return $this->repo
            ->skipPresenter(false)
            ->pushCriteria(new InputCriteria($request->all()))
            ->with($this->withRelations)
            ->orderBy($this->orderBy)
            ->paginate($limit);
    }
}
