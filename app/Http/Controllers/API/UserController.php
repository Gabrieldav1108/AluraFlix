<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(
        private $userRepository = new UserRepository()
    ){}

    public function store(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3|max:60',
                "email" => "email|required",
                'password' => 'required'
            ]
        );
        $validator->validate();

        $data = $validator->validated();
        try{
            $user = $this->userRepository->store($data);

            return $this->serverSuccessResponse(
                'O usuário foi criado com sucesso!',
                new UserResource($user)
            );
        } catch(Exception $e){
            dd($e);
            return $this->serverErrorResponse('Não foi possivel criar o usuário');
        }
        // return response()
        //     ->json($this->userRepository->store($validator->validated()));
    }
}
