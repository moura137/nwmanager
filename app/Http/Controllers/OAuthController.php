<?php

namespace NwManager\Http\Controllers;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use NwManager\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;
use NwManager\Services\PasswordService;

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
     * Forgot
     *
     * @return ResponseJson
     */
    public function forgot(PasswordService $service, Request $request)
    {
        $response = $service->forgotPassword($request);

        if (!$response) {
            $errors = $service->errors();
            return response()->json($errors, 422);
        }

        $status = trans($response);
        return response()->json(compact('status'), 200);
    }

    /**
     * Reset
     *
     * @return ResponseJson
     */
    public function reset(PasswordService $service, Request $request)
    {
        $response = $service->resetPassword($request);

        if (!$response) {
            $errors = $service->errors();
            return response()->json($errors, 422);
        }

        $status = trans($response);
        return response()->json(compact('status'), 200);
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
