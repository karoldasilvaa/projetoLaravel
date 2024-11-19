<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TaskController extends Controller
{
    public function index() {
        $search = request('search');

        if($search) {
            $tasks = Task::where([
                ['title', 'like', '%' .$search. '%']
            ])->get();
        }else {
            $tasks = Task::all();
        }

        return view('welcome', ['tasks' => $tasks, 'search' => $search]);
    }

    public function create($id = null) {

        if($id == null){
            return view('tasks.create');
        }

        $task = Task::findOrFail($id);
        return view('tasks.create', ['task' => $task ]);
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

            if($request->hasFile('image') && $request->file('image')->isValid()) {

                $requestImage = $request->image;

                $extension = $requestImage->extension();

                $imageName = md5($requestImage->getClientOriginalName() . Strtotime("now")) . "." . $extension;

                $request->image->move(public_path('img/tarefas'), $imageName);

                $task->image = $imageName;
            }   

            $task->save();

            return redirect('/')->with('msg-success', 'Tarefa criada com sucesso!');
        } catch (Exception $e) {
            return redirect('/')->with('msg-error', 'Erro ao criar tarefa. Favor tentar novamente mais tarde.');
        }
    }
}
