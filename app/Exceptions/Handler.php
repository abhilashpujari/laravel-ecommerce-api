<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param \Exception $exception
     * @return Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        $this->logExpection($exception, $request);

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();

            return response()->json(
                [
                    'code' => $statusCode,
                    'message' => $exception->getMessage()
                ],
                $statusCode
            );
        }

        return parent::render($request, $exception);
    }

    private function logExpection(Exception $exception, Request $request)
    {
        $json = $request->getContent();
        $statusCode = $exception->getStatusCode();

        switch ($statusCode) {
            case 400:
                // Bad Request
                $this->log(
                    LogLevel::NOTICE,
                    '[400] ' . $exception->getMessage(),
                    [
                        'Request' => rawurldecode($request->getRequestUri()),
                        'Method' => $request->getMethod(),
                        'Json' => $json,
                    ]
                );
                break;
            case 401:
                // Unauthorized
                $this->log(
                    LogLevel::NOTICE,
                    '[401] ' . $exception->getMessage(),
                    [
                        'Request' => rawurldecode($request->getRequestUri()),
                        'Method' => $request->getMethod(),
                        'Json' => $json,
                    ]
                );
                break;
            case 403:
                // Forbidden
                $this->log(
                    LogLevel::NOTICE,
                    '[403] ' . $exception->getMessage(),
                    [
                        'Request' => rawurldecode($request->getRequestUri()),
                        'Method' => $request->getMethod(),
                    ]
                );
                break;
            case 404:
                // Not Found
                $this->log(
                    LogLevel::NOTICE,
                    '[404] ' . $exception->getMessage(),
                    [
                        'Request' => rawurldecode($request->getRequestUri()),
                    ]
                );
                break;
            case 405:
                // Method not allowed
                $this->log(
                    LogLevel::NOTICE,
                    '[405] ' . $exception->getMessage(),
                    [
                        'Request' => rawurldecode($request->getRequestUri()),
                        'Method' => $request->getMethod(),
                    ]
                );
                break;
            case 409:
                // Conflict
                $this->log(
                    LogLevel::NOTICE,
                    '[409] ' . $exception->getMessage(),
                    [
                        'Request' => rawurldecode($request->getRequestUri()),
                        'Method' => $request->getMethod(),
                        'Json' => $json,
                    ]
                );
                break;
            case 412:
                // Precondition Failed
                $this->log(
                    LogLevel::NOTICE,
                    '[412] ' . $exception->getMessage(),
                    [
                        'Request' => rawurldecode($request->getRequestUri()),
                        'Method' => $request->getMethod(),
                    ]
                );
                break;
            default:
                // Internal Server Error
                $this->log(
                    LogLevel::ERROR,
                    '[500] ' . $exception->getMessage(),
                    [
                        'Request' => rawurldecode($request->getRequestUri()),
                        'Method' => $request->getMethod(),
                        'Json' => $json,
                        'Stack Trace' => "\n" . $exception->getTraceAsString()
                    ]
                );
        }
    }

    protected function log($logLevel, $message, array $context = [])
    {
        Log::$logLevel($message, $context);
        return true;
    }
}
