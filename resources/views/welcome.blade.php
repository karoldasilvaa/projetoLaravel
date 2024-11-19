@extends('layouts.main')

@section('title',  'Tarefas - Cadastro e consulta de tarefas')

@section('content')

<div id="search-container" class="col-md-12">
    <h1>Busque uma Tarefa</h1>
    <form action="/" method="GEt">
        <input type="text" id="search" name = "search" class="form-control" placeholder="Buscar..." />
    </form>
</div>
<div id="tarefas-container" class="col-md-12">
    @if($search) 
    <h2>Buscando por: {{ $search }}</h2>
    @else
    <h2>Próximas Tarefas</h2>
    @endif

    @if (count($tasks) > 0)
        <p class="subtitle">Veja as tarefas dos próximos dias</p>
    @endif
    
    <div id="cards-container" class="row">
        @foreach($tasks as $task)
            <div class="card col-md-3">
                <img src="/img/tarefas/{{$task->image}}" alt="{{$task->title}}">
                <div class="card-body">
                    <p>{{ date('d/m/Y', strtotime($task->date)) }}</p>

                    <h5 class="card-title">
                        {{$task->title}}
                    </h5>
                    <p class="card-descriptions">
                        {{$task->description}}
                    </p>
                </div>

                <a href="/tasks/create/{{$task->id}}" class="btn btn-primary">Editar</a>
            </div>
        @endforeach

        @if (count($tasks) == 0 && $search)
            <p>Não foi possovel encontrar nenhuma tarefa com {{ $search }}! <a href="/">Ver todos</a></p>
        @elseif (count ($tasks) == 0)
            <p>Não há tarefas disponíveis</p>
        @endif
    </div>
</div>

@endsection