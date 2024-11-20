@extends('layouts.main')

@section('title',  'Tarefas - Cadastro e consulta de tarefas')

@section('content')

<div id="search-container" class="col-md-12">
    <h1>Busque uma Tarefa</h1>
    <form action="/" method="GET">
        <div class="input-group">
            <input type="text" id="search" name="search" class="form-control" placeholder="Buscar..." />
            <div class="input-group-append">
                <input class="btn btn-primary" type="submit" value="Buscar">
            </div>
        </div>
    </form>
</div>
<div id="tarefas-container" class="col-md-12">

    <div class="row">
        <div class="col-6">
            @if($search) 
            <h2>Buscando por: {{ $search }}</h2>
            @else
            <h2>Próximas Tarefas</h2>
            @endif

            @if (count($tasks) > 0)
                <p class="subtitle">Veja as tarefas dos próximos dias</p>
            @endif
        </div>    
        <div class="col-3">
            <form action="/" method="GET">
                <label for="sort_date">Ordenação:</label>
                <select class="form-control" name="sort_date" id="sort_date" onchange="this.form.submit()">
                    <option value="1" {{ request('sort_date') == 1 ? 'selected' : '' }}>Mais Recente</option>
                    <option value="2" {{ request('sort_date') == 2 ? 'selected' : '' }}>Mais Antigo</option>
                </select>
            </form>
        </div>  
        
        <div class="col-3">
            <form action="/" method="GET">
                <label for="status">Status:</label>
                <select class="form-control" name="status_id" id="status_id" onchange="this.form.submit()">
                    <option value="0" {{ request('status_id') == 0 ? 'selected' : '' }}>Todos</option>
                    <option value="1" {{ request('status_id') == 1 ? 'selected' : '' }}>Concluído</option>
                    <option value="2" {{ request('status_id') == 2 ? 'selected' : '' }}>Em andamento</option>
                    <option value="3" {{ request('status_id') == 3 ? 'selected' : '' }}>Pendente</option>
                </select>
            </form> 
        </div>          
    </div>  
    
    <div id="cards-container" class="row">
        @foreach($tasks as $task)
            <div class="col-3">
                <div class="card">
                    <img src="/img/tarefas/{{$task->image}}" alt="{{$task->title}}">
                    <div class="card-body">
                        <p>{{ $task->date->format('d/m/Y') }}</p>

                        <h5 class="card-title">
                            {{$task->title}}
                        </h5>

                        <p class="card-descriptions">
                            {{$task->description}}
                        </p>

                        <p>
                            <strong>Criado por:</strong> {{$task->user->name}}
                        </p>

                        <p>
                            {{$task->status->name}}
                        </p>

                    </div>

                    <a href="/tasks/create/{{$task->id}}" class="btn btn-primary">Editar</a>
                    <form action="/tasks/{{$task->id}}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
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