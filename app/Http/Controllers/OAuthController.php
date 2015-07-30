<?php

namespace NwManager\Http\Controllers;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

/**
 * Class OAuthController
 *
 * @package NwManager\Http\Controllers;
 */
class OAuthController extends Controller
{
    public function access()
    {
        return response()->json(Authorizer::issueAccessToken());
    }
}
