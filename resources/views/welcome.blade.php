@extends('layouts.main')

@section('title',  'Tarefas - Cadastro e consulta de tarefas')

@section('content')

<div id="search-container" class="col-md-12">
    <h1>Busque uma Tarefa</h1>
    <form action="">
        <input type="text" id="search" name = "search" class="form-control" placeholder="Buscar..." />
    </form>
</div>
<div id="tarefas-container" class="col-md-12">
    <h2>Próximas Tarefas</h2>
    <p class="subtitle">Veja as tarefas dos próximos dias</p>
    <div id="cards-container" class="row">
        @foreach($tasks as $task)
            <div class="card col-md-3">
                <img src="/img/tarefa.png" alt="{{$task->title}}">
                <div class="card-body">
                    <p>17/11/2024</p>

                    <h5 class="card-title">
                        {{$task->title}}
                    </h5>
                    <p class="card-descriptions">
                        {{$task->description}}
                    </p>
                </div>

                <a href="/tasks/create" class="btn btn-primary">Editar</a>
            </div>
        @endforeach
    </div>
</div>

@endsection