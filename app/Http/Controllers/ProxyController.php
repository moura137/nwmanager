<?php

namespace NwManager\Http\Controllers;

use NwManager\OAuth\Proxy;
use Illuminate\Http\Request;

/**
 * Class ProxyController
 *
 * @package NwManager\Http\Controllers;
 */
class ProxyController extends Controller
{
    protected $client_id = 'ANGULAR_APP';
    /**
     * Construct
     *
     * @param Proxy $proxy
     */
    public function __construct(Proxy $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * Login Password
     *
     * @return Response
     */
    public function token(Request $request)
    {
        $credentials = $request->all();
        if (isset($credentials['refresh_token'])) {
            return $this->proxy->attemptRefresh($this->client_id, $credentials);
        }

        return $this->proxy->attemptLogin($this->client_id, $credentials);
    }

    /**
     * Refresh Token
     *
     * @return Response
     */
    public function refresh(Request $request)
    {
        return $this->proxy->attemptRefresh($this->client_id, $request->all());
    }
}
