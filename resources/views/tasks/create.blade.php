@extends('layouts.main')

@section('title',  'Criar Evento')

@section('content')

<div id="tarefa-create-container" class="col-md-6 offset-md-3">
    <h1>Cadastro de Tarefa</h1>
    <form action="/tasks" method="POST">
        @csrf
        <div class="form-group spacing">
            <label for="title">Título:</label>
            <input type="text" class="form-control" id="title" name="title" required placeholder="Título da tarefa">
        </div>
        <div class="form-group spacing">
            <label for="description">Descrição:</label>
            <textarea class="form-control" id="description" name="description" placeholder="Descrição da tarefa"></textarea>
        </div>
        <input type="submit" class="btn btn-primary spacing" value="Salvar">
    </form>
</div>

@endsection