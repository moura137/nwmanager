<?php

namespace NwManager\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use GuzzleHttp\Client;

class ApiRequest
{
    /**
     * Construct AppController
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->remoteClient = $client;
    }

    /**
     * Remote client for http request.
     *
     * @return Client
     */
    public function getRemoteClient()
    {
        return $this->remoteClient;
    }

    /**
     * Call Request
     *
     * @param string $uri
     * @param string $method
     *
     * @return mixed
     */
    
    public function call($uri, $method = 'GET', $parameters = [], $server = [])
    {
        $cookies = array();
        $files = array();
        $content = null;

        $request = Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);

        $route = app('router')->getRoutes()->match($request);

        $response = $route->run($request);

        return $this->parseResult($response);
    }

    /**
     * Invoke with remote uri.
     *
     * @param  string $uri
     * @param  string $method
     * @param  array  $parameters
     * @return mixed
     */
    public function callRemote($uri, $method = 'GET', $parameters = [], $server = [])
    {
        try {
            $remoteClient = $this->getRemoteClient();

            // Make request.
            $options = [
                'headers' => $server, 
                'body'    => http_build_query($parameters),
            ];

            $response = call_user_func_array(array($remoteClient, $method), array($uri, $options));

            $code = $response->getStatusCode();
            $contentType = $response->getHeaderLine('content-type');
            $data = (string) $response->getBody()->getContents();

            // Decode json content.
            if (preg_match('/application\/json/', $contentType)) {
                if (function_exists('json_decode') and is_string($data)) {
                    $data = json_decode($data, true);
                }
            }

        } catch (\Exception $e) {
            $data = ['error' => $e->getMessage()];
            $code = $e->getCode();
        }

        return compact('data', 'code');
    }

    /**
     * Parse Result
     *
     * @param mixed $data
     *
     * @return mixed
     */
    protected function parseResult($data)
    {
        if ($data instanceof JsonResponse) {
            $data = (array) $data->getData();

        } elseif ($data instanceof Response) {
            $data = $data->getOriginalContent();
        }

        return $data;
    }

    /**
     * Alias call method.
     *
     * @return mixed
     */
    public function __call($method, $parameters = array())
    {
        $method = strtolower($method);

        if (in_array($method, array('get', 'patch', 'post', 'put', 'delete')))
        {
            $uri = array_shift($parameters);
            array_unshift($parameters, $uri, $method);

            if (preg_match('/^http(s)?/', $uri)){
                return call_user_func_array([$this, 'callRemote'], $parameters);
            }

            return call_user_func_array([$this, 'call'], $parameters);
        }

        $className = get_class($this);
        throw new BadMethodCallException("Call to undefined method {$className}::{$method}()");
    }
}