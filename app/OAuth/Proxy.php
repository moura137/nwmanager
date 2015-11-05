<?php

namespace NwManager\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use NwManager\Entities\OAuthClient;

class Proxy
{
    protected $oauth_client;

    /**
     * Construct
     *
     * @param OAuthClient $oauth_client
     */
    public function __construct(OAuthClient $oauth_client)
    {
        $this->oauth_client = $oauth_client;
    }

    /**
     * Attempt Login Password
     *
     * @param string $client_id
     * @param array  $credentials
     *
     * @return Response
     */
    public function attemptLogin($client_id, $credentials)
    {
        return $this->proxy('password', $client_id, $credentials);
    }

    /**
     * Attempt Refresh Token
     *
     * @param string $client_id
     * @param array  $credentials
     *
     * @return Response
     */
    public function attemptRefresh($client_id, $credentials)
    {
        return $this->proxy('refresh_token', $client_id, $credentials);
    }

    /**
     * Proxy
     *
     * @param string $grantType
     * @param string $client_id
     * @param array  $data
     *
     * @return Response
     */
    private function proxy($grantType, $client_id, array $data = [])
    {
        try {
            $data = array_merge([
                'client_id'     => $client_id,
                'client_secret' => $this->getClientSecret($client_id),
                'grant_type'    => $grantType
            ], $data);

            $client = new Client();
            $guzzleResponse = $client->post(sprintf('%s/oauth/access-token', config('app.url')), [
                'form_params' => $data
            ]);
        } catch(BadResponseException $e) {
            $guzzleResponse = $e->getResponse();
        }

        return $this->parseResponse($guzzleResponse);
    }

    private function getClientSecret($client_id)
    {
        $client_secret = '';
        $client = $this->oauth_client->where('id', $client_id)->first();
        if ($client) {
            $client_secret = $client->secret;
        }

        return $client_secret;
    }

    private function parseResponse($guzzleResponse)
    {
        $response = json_decode($guzzleResponse->getBody());

        // if (property_exists($response, "access_token")) {
        //     $cookie = app()->make('cookie');
        //     $crypt  = app()->make('encrypter');

        //     $encryptedToken = $crypt->encrypt($response->refresh_token);

        //     // Set the refresh token as an encrypted HttpOnly cookie
        //     $cookie->queue('refreshToken',
        //         $crypt->encrypt($encryptedToken),
        //         604800, // expiration, should be moved to a config file
        //         null,
        //         null,
        //         false,
        //         true // HttpOnly
        //     );

        //     $response = [
        //         'accessToken'            => $response->access_token,
        //         'accessTokenExpiration'  => $response->expires_in
        //     ];
        // }

        $response = response()->json($response);
        $response->setStatusCode($guzzleResponse->getStatusCode());

        $headers = $guzzleResponse->getHeaders();
        foreach($headers as $headerType => $headerValue) {
            $response->header($headerType, $headerValue);
        }

        return $response;
    }
}