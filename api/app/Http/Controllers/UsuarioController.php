<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
class UsuarioController extends Controller
{
    public function cadastrar(Request $req){
        try{
            $req->validate(['email' => 'required|email|unique:usuarios,email'],
            ['email.unique' => 'este email já está cadastrado']
        );
            $user = Usuario::create([
                'nome' => $req->nome,
                'email' => $req->email,
                'senha' => bcrypt($req->senha),
            ]);
            return response()->json(['status' => "ok", 'token' => $user->createToken('token')->plainTextToken, "user" => $user]);
        }catch(\Throwable $e){
            return response()->json(['error' => true,'message' => $e->getMessage()], 422);
        }
    }

    public function login(Request $req){
        try{
            $user = Usuario::where('email', $req->email)->first();
            
            if(!$user || !Hash::check($req->senha, $user->senha))
            {
                return response()->json(['error' => "credencial inválida"]);
            }
           
            $user->tokens()->delete();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json(['status' => "ok", 'token' => $token, "user" => $user]);
        }catch(\Throwable $e){
            return response()->json(['status' => $e->getMessage()]);
        }
    }


    public function logout(Request $req){
        try{
            $req->user()->currentAccessToken()->delete();
            return response()->json(['status' => "ok"]);
        }catch(\Throwable $e){
            return response()->json(['status' => $e->getMessage()]);
        }
    }
}
