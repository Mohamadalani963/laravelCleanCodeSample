<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

use Illuminate\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected function LogException(\Exception $ex)
    {
        Log::error("Message : " . $ex->getMessage());
        if ($ex instanceof ApiException) {
            Log::error("System message: " . $ex->systemMessage);
        }
        Log::error("Line : " . $ex->getLine());
        Log::error("File : " . $ex->getFile());
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (\Exception $exception) {
            if (Request::header('Accept') == 'application/json') {
                $this->LogException($exception);
                $response = match (true) {
                    $exception instanceof AuthenticationException => response()->json([
                        'status' => 'failed',
                        'error' => 'NOT_AUTHENTICATED',
                        'message' => 'You are not authenticated',
                    ])->setStatusCode(403),
                    $exception instanceof ApiException => $exception->response(),
                    $exception instanceof ValidationException => response()->json(
                        array_merge(['status' => 'fail'], $exception->errors())
                    )->setStatusCode(422),
                    default => response()->json([
                        'status' => 'fail',
                        'error' => 'INTERNAL_SERVER_ERROR',
                        'message' => 'Something went wrong',
                    ])->setStatusCode(500)
                };

                return $response;
            }
        });
    }
}
