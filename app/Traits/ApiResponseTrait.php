<?php

namespace App\Traits;

trait ApiResponseTrait
{
    //
    public function successApiResponse($data, $message = "Successfully. ", $status = 200){
        return response()->json([
            "data" => $data,
            "message" => $message,
        ], $status);
    }

    public function errorApiResponse($message = "Error", $status = 500){
        return response()->json([
            "message" => $message,
        ], $status);
    }
}
