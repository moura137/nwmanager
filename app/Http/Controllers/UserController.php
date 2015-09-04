<?php

namespace NwManager\Http\Controllers;

use NwManager\Repositories\Contracts\UserRepository;
use NwManager\Services\UserService;

/**
 * Class UserController
 *
 * @package NwManager\Http\Controllers;
 */
class UserController extends Controller
{
    use Traits\RestFullTrait;

    /**
     * Construct UserController
     *
     * @param UserRepository $repo
     * @param UserService    $service
     */
    public function __construct(UserRepository $repo, UserService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
        $this->orderBy = 'name ASC';
    }
}
