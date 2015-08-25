<?php

namespace NwManager\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($request->ajax() || $request->headers->get('Accept') == 'application/json') {
            return $this->renderJson($e);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->view("errors.404", ['exception' => $e], 404);
        }

        return parent::render($request, $e);
    }

    /**
     * Render an exception return Json.
     *
     * @param \Exception $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJson(Exception $e)
    {
        $statusCode = $this->getStatusCode($e);

        $data = [
            'error' => $this->getMessageError($statusCode),
            'error_description' => $e->getMessage(),
        ];

        if (config('app.debug')) {
            $data['exception'] = sprintf("%s in %s:(%s)", get_class($e), $e->getFile(), $e->getLine());
        }
                
        return response()->json($data, $statusCode);
    }

    /**
     * Get Status Code
     *
     * @param Exception $e
     *
     * @return int
     */
    private function getStatusCode(Exception $e)
    {
        if ($this->isHttpException($e)) {
            $statusCode = $e->getStatusCode();

        } elseif ($e instanceof ModelNotFoundException) {
            $statusCode = 404;

        } else {
            $statusCode = 500;
        }
        
        return $statusCode;
    }

    /**
     * Get Message Http
     *
     * @param int $code
     *
     * @return string
     */
    private function getMessageError($code)
    {
        $errors = [
            '400' => 'BAD REQUEST',
            '401' => 'UNAUTHORIZED',
            '402' => 'PAYMENT REQUIRED',
            '403' => 'FORBIDDEN',
            '404' => 'NOT FOUND',
            '405' => 'METHOD NOT ALLOWED',
            '406' => 'NOT ACCEPTABLE',
            '407' => 'PROXY AUTHENTICATION REQUIRED',
            '408' => 'REQUEST TIMEOUT',
            '409' => 'CONFLICT',
            '410' => 'GONE',
            '411' => 'LENGTH REQUIRED',
            '412' => 'PRECONDITION FAILED',
            '413' => 'REQUEST ENTITY TOO LARGE',
            '414' => 'REQUEST URI TOO LONG',
            '415' => 'UNSUPPORTED MEDIA TYPE',
            '416' => 'REQUESTED RANGE NOT SATISFIABLE',
            '417' => 'EXPECTATION FAILED',
            '418' => 'I AM A TEAPOT',
            '422' => 'UNPROCESSABLE ENTITY',
            '423' => 'LOCKED',
            '424' => 'FAILED DEPENDENCY',
            '425' => 'RESERVED FOR WEBDAV ADVANCED COLLECTIONS EXPIRED PROPOSAL',
            '426' => 'UPGRADE REQUIRED',
            '428' => 'PRECONDITION REQUIRED',
            '429' => 'TOO MANY REQUESTS',
            '431' => 'REQUEST HEADER FIELDS TOO LARGE',
            '500' => 'INTERNAL SERVER ERROR',
            '501' => 'NOT IMPLEMENTED',
            '502' => 'BAD GATEWAY',
            '503' => 'SERVICE UNAVAILABLE',
            '504' => 'GATEWAY TIMEOUT',
            '505' => 'VERSION NOT SUPPORTED',
            '506' => 'VARIANT ALSO NEGOTIATES EXPERIMENTAL',
            '507' => 'INSUFFICIENT STORAGE',
            '508' => 'LOOP DETECTED',
            '510' => 'NOT EXTENDED',
            '511' => 'NETWORK AUTHENTICATION REQUIRED',
        ];

        if (array_key_exists($code, $errors)) {
            return $errors[$code];
        }

        return $errors['500'];
    }
}
