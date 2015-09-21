<?php

namespace NwManager\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
     * Get Reset
     *
     * @return ResponseJson
     */
    public function token(PasswordService $service, Request $request)
    {
        $user = $service->passwordToken($request);

        if (!$user) {
            $errors = $service->errors();
            return response()->json($errors, 422);
        }

        return response()->json($user->presenter(), 200);
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
        return response()->json(Auth::user()->presenter());
    }
}
