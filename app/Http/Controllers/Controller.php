<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonResources\PaginatedCollection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(title="My First API", version="0.1")
     */
    use AuthorizesRequests, ValidatesRequests;

    public function success($data = [], $key = "data", $statusCode = 200, $status = "success")
    {
        if ($data instanceof JsonResource) {
            return response()->json([
                "status" => "success",
                $key => $data,
            ]);
        }

        $result = array_merge(["status" => $status], $data);

        return response($result)->setStatusCode($statusCode);
    }
    public function failure($error = [], $statusCode = 500, $status = "fail")
    {
        $result = array_merge(["status" => $status], $error);

        return response($result)->setStatusCode($statusCode);
    }
}
