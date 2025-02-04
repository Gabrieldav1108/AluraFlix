<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
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

        return response()
            ->json($this->userRepository->store($validator->validated()));
    }
}
