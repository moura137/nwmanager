<?php

namespace NwManager\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \NwManager\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'oauth' => \LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware::class,
        'oauth-owner' => \LucaDegasperi\OAuth2Server\Middleware\OAuthOwnerMiddleware::class,
        'check-authorization-params' => \LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware::class,

        'csrf' => \NwManager\Http\Middleware\VerifyCsrfToken::class,
        'auth' => \NwManager\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \NwManager\Http\Middleware\RedirectIfAuthenticated::class,
        'accept.json' => \NwManager\Http\Middleware\AcceptJson::class,
        'project.owner' => \NwManager\Http\Middleware\CheckProjectOwner::class,
        'project.member' => \NwManager\Http\Middleware\CheckProjectMember::class,
        'project-note.user' => \NwManager\Http\Middleware\CheckProjectNoteUser::class,
        'project-file.user' => \NwManager\Http\Middleware\CheckProjectFileUser::class,
    ];
}
