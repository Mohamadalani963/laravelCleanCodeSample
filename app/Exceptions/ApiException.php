<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{
    private   $error;
    public $message;
    public $statusCode;
    public $systemMessage;

    /**
     * @param $error
     * @param $status
     * @param $message
     */
    public function __construct(string $message, string  $error = 'INTERNAL_SERVER_ERROR', $statusCode = 500, $systemMessage = "")
    {
        $this->error = $error;
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->systemMessage = $systemMessage;
    }

    public function response(): JsonResponse
    {
        return response()->json([
            'status' => 'fail',
            'error' => $this->error,
            'message' => $this->message
        ])->setStatusCode($this->statusCode);
    }
}
