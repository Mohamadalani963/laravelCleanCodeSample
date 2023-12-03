<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;

class FormValidationException extends ValidationException
{
    //
    public function render()
    {
        return response()->json([
            'status' => 'fail',
            'error' => $this->errors(),
        ])->setStatusCode(422);
    }
}
