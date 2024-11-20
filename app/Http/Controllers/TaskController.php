<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

use App\Models\User;

use App\Models\Status;

class TaskController extends Controller
{
    // função para mostrar o conteudo na tela
    public function index() {
        // aqui é pra pegar os parâmetros da url
        $search = request('search');
        $status_id = request('status_id');
        $sort_date = request('sort_date');
        // aqui é pra quando o usuario tiver logado
        $user = auth()->user();   


        if($user != null){
            // função para ver se o usuario é administrador
            if($user->access == 1) {
                if ($status_id != null && $status_id > 0 ) {
                    // consultar pelo status_id
                    $tasks = Task::where([
                        ['status_id', $status_id]
                    ])->get();
                }
                // função para quando o usuario pesquisar a tarefa vai trazer tarefas relacionado com oque ele digitou
                elseif($search) {
                    $tasks = Task::where([
                        ['title', 'like', '%' .$search. '%']
                    ])->get();
                }else {
                    // se não pesquisar a tarefa vai mostrar todas
                    $tasks = Task::all();
                } 

            } else {
                // se o status_id não for null e maior que zero 
                if ($status_id != null && $status_id > 0 ) {
                    // consultar pelo status_id
                    $tasks = Task::where([                        
                        ['status_id', $status_id],
                        ['user_id', $user->id]
                    ])->get();
                }
                // se quando o pesquisar não for null
                elseif($search != null) {
                    // vai pesquisar pelo titulo
                    $tasks = Task::where([
                        ['title', 'like', '%' .$search. '%'],
                        ['user_id', $user->id]
                    ])->get();
                }else {
                    // senão vai trazer todas as tarefas de um usuario pelo id
                    $tasks = Task::where([
                        ['user_id', $user->id]
                    ])->get();
                } 
            }

            // se valor do select foi 1 vai entrar nessa função e ordenar as tarefas pelas datas em ordem decrescente
            if ($sort_date == 1) {
                $tasks = $tasks->sortByDesc('date');
            }elseif ($sort_date == 2){
            //  se o valor for 2 vai ordenar em ordem crescente
                $tasks = $tasks->sortBy('date');
            }
            else {
                // se o usuario não clicar no select de ordenar vai trazer em ordem decrescente por padrão
                $tasks = $tasks->sortByDesc('date');
            }

            foreach ($tasks as $task) {
                // aqui vai fazer um laço e preencher o usuário e o status
                $task->user = User::where('id', $task->user_id)->first();
                $task->status = Status::where('id', $task->status_id)->first();
            }


            return view('welcome', ['tasks' => $tasks, 'search' => $search]);
        } else {
            // se o usuario tiver desconectado vai ir pra view do login
            return redirect('/login');
        }        
    }

    // função para criar e editar a tarefas
    public function create($id = null) {

        // se o id for null irá criar uma nova tarefa
        if($id == null){            
            return view('tasks.create');
        }

        // se o id não for null irá editar uma nova tarefa
        // aqui vai encontrar a tarefa
        $task = Task::findOrFail($id);
        
        // e retornar pra view create com a tarefa preenchida para o usuario pode editar
        return view('tasks.create', ['task' => $task ]);
    }

    // função prara deletar tarefa pelo id da tarefa
    public function delete($id) {
        try {
            // encontrar a tarefa pelo id
            $task = Task::find($id);
            // deletar a tarefa
            $task->delete();

            // retornar para a view principal e mostrar a mensagem 
            return redirect('/')->with('msg-success', 'Tarefa excluída com sucesso!');
        } catch (Exception $e) {
            return redirect('/')->with('msg-error', 'Erro ao excluir tarefa. Favor tentar novamente mais tarde.');
        }
    }

    // função para salvar tarefa
    public function store(Request $request) {

        try {
            if($request->id > 0){
                // buscar a tarefa e se encontrar o usuario vai poder editar a tarefa
                $task = Task::findOrFail($request->id);
            } else {
                // senão vai criar uma nova tarefa
                $task = new Task;
            }
            
            $task->title = $request->title;
            $task->date = $request->date;
            $task->description = $request->description;
            $task->status_id = $request->status_id;

            // aqui vai verificar se o arquivo é valido 
            if($request->hasFile('image') && $request->file('image')->isValid()) {

                // obter a imagem
                $requestImage = $request->image;

                // obter a extensão png, jpg etc...
                $extension = $requestImage->extension();

                // criar um nome para imagem
                $imageName = md5($requestImage->getClientOriginalName() . Strtotime("now")) . "." . $extension;

                // colocar a imagem na pasta tarefas onde a imagem fica no servidor
                $request->image->move(public_path('img/tarefas'), $imageName);

                // atualiza o campo image no banco de dados
                $task->image = $imageName;
            }

            // usuario logado
            $user = auth()->user();

            // a coluna user_id  recebe o id da tabela user
            $task -> user_id = $user->id;

            $task->save();

            // quando salvar retorna a view principal e mostra a mensagem na view
            return redirect('/')->with('msg-success', 'Tarefa criada com sucesso!');

        } catch (Exception $e) {
            return redirect('/')->with('msg-error', 'Erro ao criar tarefa. Favor tentar novamente mais tarde.');
        }
    }
}
