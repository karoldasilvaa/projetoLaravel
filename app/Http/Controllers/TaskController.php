<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

use App\Models\User;

use App\Models\Status;

class TaskController extends Controller
{
    public function index() {
        $search = request('search');
        $status_id = request('status_id');
        $sort_date = request('sort_date');
        $user = auth()->user();   

        if($user != null){
            //Administrador
            if($user->access == 1) {
                if ($status_id != null) {

                    $tasks = Task::where([
                        ['status_id', $status_id]
                    ])->get();
                }
                elseif($search) {
                    $tasks = Task::where([
                        ['title', 'like', '%' .$search. '%']
                    ])->get();
                }else {
                    $tasks = Task::all();
                } 

            } else {
                if ($status_id != null) {

                    $tasks = Task::where([
                        ['status_id', $status_id],
                        ['user_id', $user->id]
                    ])->get();
                }
                elseif($search != null) {
                    $tasks = Task::where([
                        ['title', 'like', '%' .$search. '%'],
                        ['user_id', $user->id]
                    ])->get();
                }else {
                    $tasks = Task::where([
                        ['user_id', $user->id]
                    ])->get();
                } 
            }

            if ($sort_date == 1) {
                $tasks = $tasks->sortByDesc('date');
            }elseif ($sort_date == 2){
                $tasks = $tasks->sortBy('date');
            }
            else {
                $tasks = $tasks->sortByDesc('date');
            }

            foreach ($tasks as $task) {
                $task->user = User::where('id', $task->user_id)->first();
                $task->status = Status::where('id', $task->status_id)->first();
            }

            return view('welcome', ['tasks' => $tasks, 'search' => $search]);
        } else {
            return redirect('/login');
        }        
    }

    public function create($id = null) {

        if($id == null){
            return view('tasks.create');
        }

        $task = Task::findOrFail($id);
        
        return view('tasks.create', ['task' => $task ]);
    }

    public function delete($id) {
        try {
            $task = Task::find($id);
            $task->delete();

            return redirect('/')->with('msg-success', 'Tarefa excluída com sucesso!');
        } catch (Exception $e) {
            return redirect('/')->with('msg-error', 'Erro ao excluir tarefa. Favor tentar novamente mais tarde.');
        }
    }

    public function store(Request $request) {

        try {
            if($request->id > 0){
                $task = Task::findOrFail($request->id);
            } else {
                $task = new Task;
            }
            
            $task->title = $request->title;
            $task->date = $request->date;
            $task->description = $request->description;
            $task->status_id = $request->status_id;

            if($request->hasFile('image') && $request->file('image')->isValid()) {

                $requestImage = $request->image;

                $extension = $requestImage->extension();

                $imageName = md5($requestImage->getClientOriginalName() . Strtotime("now")) . "." . $extension;

                $request->image->move(public_path('img/tarefas'), $imageName);

                $task->image = $imageName;
            }

            $user = auth()->user();
            $task -> user_id = $user->id;

            $task->save();

            return redirect('/')->with('msg-success', 'Tarefa criada com sucesso!');

        } catch (Exception $e) {
            return redirect('/')->with('msg-error', 'Erro ao criar tarefa. Favor tentar novamente mais tarde.');
        }
    }
}
