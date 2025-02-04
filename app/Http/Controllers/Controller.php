<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class Controller
{
    protected function serverSuccessResponse(string $message = null, JsonResource|array $data = null): JsonResponse{
        $response = [];
        
        if(!is_null($message)){
            $response['message'] = $message;
        }
        if(!is_null($data)){
            $response['data'] = $data;
        }
        return new JsonResponse($data);
    }

    protected function serverErrorResponse(string $message){
        return new JsonResponse([
            'message' => $message
        ], 500);
    }
}
