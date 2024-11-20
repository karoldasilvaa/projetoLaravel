@extends('layouts.main')

@section('title',  'Criar Tarefa')

@section('content')

<div id="tarefa-create-container" class="col-md-6 offset-md-3">
    <h1 class="text-center mb-4">Cadastro de Tarefa</h1>
    <form action="/tasks" method="POST" enctype="multipart/form-data">
        @csrf

        @if(!empty($task->image))
            <div class="form-group spacing">
                <img src="/img/tarefas/{{$task->image ?? ''}}" alt="{{$task->title}}">
            </div>   
        @endif   
        
        <input type="hidden" name="id" value="{{$task->id ?? ''}}">

        <div class="form-group spacing">
            <label for="image">Imagem da tarefa:</label>
            <input type="file" id="image" name="image" class="arquivo">
        </div>
        <div class="form-group spacing">
            <label for="title">Título:</label>
            <input type="text" value="{{$task->title ?? ''}}" class="form-control" id="title" name="title" required placeholder="Título da tarefa">
        </div>
        <div class="form-group spacing">
            <label for="date">Data:</label>
            <input type="date" value="{{ isset($task->date) ? \Carbon\Carbon::parse($task->date)->format('Y-m-d') : '' }}" class="form-control" id="date" name="date">
            
        </div>
        <div class="form-group spacing">
            <label for="description">Descrição:</label>
            <textarea class="form-control" id="description" name="description" placeholder="Descrição da tarefa">{{$task->description ?? ''}}</textarea>
        </div>

        <div class="form-group spacing">
            <label for="status_id">Status:</label>
            <select class="form-control" name="status_id" id="status_id" requered >
                <option value="">Selecione o Status</option>
                <option value="1" {{ isset($task) && $task->status_id == 1 ? 'selected' : '' }}>Concluído</option>
                <option value="2" {{ isset($task) && $task->status_id == 2 ? 'selected' : '' }}>Em andamento</option>
                <option value="3" {{ isset($task) && $task->status_id == 3 ? 'selected' : '' }}>Pendente</option>
            </select>
        </div>

        <div class="form-group spacing">
            <input type="submit" class="btn btn-primary spacing bt-salvar" value="Salvar">
        </div>

    </form>
</div>

@endsection