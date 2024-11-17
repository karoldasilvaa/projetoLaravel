<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::all();

        return view('welcome', ['tasks' => $tasks ]);
    }

    public function create() {
        return view('tasks.create');
    }

    public function store(Request $request) {

        try {
            $task = new Task;
            $task->title = $request->title;
            $task->description = $request->description;
            $task->save();

            return redirect('/')->with('msg-success', 'Tarefa criada com sucesso!');
        } catch (Exception $e) {
            return redirect('/')->with('msg-error', 'Erro ao criar tarefa. Favor tentar novamente mais tarde.');
        }
    }
}
