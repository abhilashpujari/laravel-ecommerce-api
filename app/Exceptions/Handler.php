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

    /**
     * @param Exception $exception
     * @param Request $request
     */
    private function logExpection(Exception $exception, Request $request)
    {
        $json = $request->getContent();
        $statusCode = $exception->getCode();

        $context = [
            'Request' => rawurldecode($request->getRequestUri()),
            'Method' => $request->getMethod(),
            'Json' => $json
        ];

        if ($statusCode === 500 || $statusCode === 0) {
            $logLevel = LogLevel::ERROR;
            $statusCode = 500;
            $context = array_merge($context , [
                'Stack Trace' => "\n" . $exception->getTraceAsString(),
            ]);
        } else {
            $logLevel = LogLevel::NOTICE;
        }

        $this->log(
            $logLevel,
            "[{$statusCode}] " . $exception->getMessage(),
            $context
        );
    }

    /**
     * @param $logLevel
     * @param $message
     * @param array $context
     * @return bool
     */
    protected function log($logLevel, $message, array $context = [])
    {
        Log::$logLevel($message, $context);
        return true;
    }
}
