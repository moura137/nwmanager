<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\ActivityRepository;
use Illuminate\Http\Request;
use NwManager\Repositories\Criterias\InputCriteria;

/**
 * Class ActivityController
 *
 * @package NwManager\Http\Controllers;
 */
class ActivityController extends Controller
{
    /**
     * @var \NwManager\Repositories\Contracts\ActivityRepository
     */
    protected $repo;

    /**
     * Construct ActivityController
     *
     * @param ActivityRepository $repo
     */
    public function __construct(ActivityRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $orderBy = 'created_at DESC';
        $limit = $request->get('limit');

        return $this->repo
            ->skipPresenter(false)
            ->pushCriteria(new InputCriteria($request->all()))
            ->orderBy($orderBy)
            ->paginate($limit);
    }
}
