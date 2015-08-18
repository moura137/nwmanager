<?php

namespace NwManager\Http\Controllers;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use NwManager\Repositories\Contracts\UserRepository;

/**
 * Class OAuthController
 *
 * @package NwManager\Http\Controllers;
 */
class OAuthController extends Controller
{
    /**
     * Construct
     *
     * @param UserRepository $repoUser
     */
    public function __construct(UserRepository $repoUser)
    {
        $this->repoUser = $repoUser;
    }

    /**
     * Access
     *
     * @return Response
     */
    public function access()
    {
        return response()->json(Authorizer::issueAccessToken());
    }

    /**
     * User Auth
     *
     * @return array
     */
    public function user()
    {
        $user = $this->repoUser->find(Authorizer::getResourceOwnerId());
        return response()->json($user->presenter());
    }
}
