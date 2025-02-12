<?php   

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function store(array $data){
        //fazer validacoes e criacoes de mensagem de erro
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        Auth::login($user);
        return $user;
    }   
}