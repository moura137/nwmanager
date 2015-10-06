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
}
