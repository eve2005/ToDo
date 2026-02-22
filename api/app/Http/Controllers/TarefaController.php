<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;

class TarefaController extends Controller
{
   public function salvar(Request $req){
        try{
            
            $userId = $req->user()->id;
            if (!$userId) {
                return response()->json(['error' => 'não autorizado']);
            }
             
            $tarefa = Tarefa::create([
                'titulo' => $req->titulo,
                'descricao' => $req->descricao ?? " ",
                'user_id' => $userId,
                'concluida' => 0,
            ]);
            return response()->json(['status' => "ok"]);
        }catch(\Throwable $e){
            return response()->json(['status' => $e->getMessage()]);
        }
         
   }

   public function listar(Request $req){
        try{
            
            $userId = $req->user()->id;
            if (!$userId) {
                return response()->json(['error' => 'não autorizado']);
            }
             
            $tarefa = Tarefa::where('user_id', $userId)->get();;
             
            return response()->json([ 'tarefas' => $tarefa]);
        }catch(\Throwable $e){
            return response()->json(['status' => $e->getMessage()]);
        }
         
   }

   public function excluir(Request $req, $id){
     
       try{
            $userId = $req->user()->id;
            $tarefa = Tarefa::where('id', $id)->where('user_id', $userId)->first();
            if (!$tarefa) {
                return response()->json(['erro' => 'erro ao buscar tarefa']);
            }
            $tarefa->delete();
            return response()->json(['status' => 'ok']);

        }catch(\Throwable $e){
            return response()->json(['status' => $e->getMessage()]);
        }
    
   }

   public function concluir(Request $req, $id){
     
       try{
            $userId = $req->user()->id;
            $tarefa = Tarefa::where('id', $id)->where('user_id', $userId)->first();
            if (!$tarefa) {
                return response()->json(['erro' => 'erro ao buscar tarefa']);
            }
            $tarefa->concluida = 1;
            $tarefa->save();
            return response()->json(['status' => 'ok']);

        }catch(\Throwable $e){
            return response()->json(['status' => $e->getMessage()]);
        }
    
   }
}
