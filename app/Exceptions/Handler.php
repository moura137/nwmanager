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
        if ($request->headers->get('Accept') == 'application/json') {
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
        $data = ['error' => $e->getMessage()];

        if (config('app.debug')) {
            $data['trace'] = $e->getTrace();
        }

        $statusCode = $this->getStatusCode($e);
        
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
}
