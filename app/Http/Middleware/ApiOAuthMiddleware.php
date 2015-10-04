<?php

namespace NwManager\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use League\OAuth2\Server\Exception\InvalidScopeException;
use LucaDegasperi\OAuth2Server\Authorizer;

class ApiOAuthMiddleware
{
    /**
     * The guard instance.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * The Authorizer instance.
     *
     * @var \LucaDegasperi\OAuth2Server\Authorizer
     */
    protected $authorizer;

    /**
     * Whether or not to check the http headers only for an access token.
     *
     * @var bool
     */
    protected $httpHeadersOnly = false;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth, Authorizer $authorizer, $httpHeadersOnly = false)
    {
        $this->auth = $auth;
        $this->authorizer = $authorizer;
        $this->httpHeadersOnly = $httpHeadersOnly;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure  $next
     * @param string|null $scopesString
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $scopesString = null)
    {
        // Auth Basic
        if ($this->validateAuthBasic($request)) {
            $this->auth->onceBasic();
        }

        // Auth Token
        /**
         * @todo  Criar Autenticação via token interno
         * Como o GitHub: https://developer.github.com/v3/#authentication
         * ex: curl -H "Authorization: token TOKEN" https://nwmanager.localhost/oauth/user
         */
        // if (!$this->auth->check()) {
        //     // Code
        // }

        // League OAuth
        if (! $this->auth->check()) {
            $scopes = [];

            if (!is_null($scopesString)) {
                $scopes = explode('+', $scopesString);
            }

            $this->authorizer->validateAccessToken($this->httpHeadersOnly);
            $this->validateScopes($scopes);

            $this->auth->onceUsingId($this->authorizer->getResourceOwnerId());
        }

        return $next($request);
    }

    /**
     * Validate Auth Basic
     *
     * @param  Request $request
     * @return bool
     */
    protected function validateAuthBasic($request)
    {
        return ($request->headers->get('PHP_AUTH_USER') && $request->headers->get('PHP_AUTH_PW'));
    }

    /**
     * Validate the scopes.
     *
     * @param $scopes
     *
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     */
    public function validateScopes($scopes)
    {
        if (!empty($scopes) && !$this->authorizer->hasScope($scopes)) {
            throw new InvalidScopeException(implode(',', $scopes));
        }
    }
}
