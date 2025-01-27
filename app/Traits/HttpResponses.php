<?php 

namespace   App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;

trait HttpResponses{
     
    public function response(string $message, String|int $status, array|Model $data = [])
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data
        ]);
    }

    public function error(string $message, String|int $status, array|MessageBag $erros = [], array $data = []){
        return response()->json([
            'message' => $message,
            'status' => $status,
            'errors' => $erros,
            'data' => $data
        ]);
    }
}