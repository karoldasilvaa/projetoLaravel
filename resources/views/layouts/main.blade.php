<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body>
        <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="/img/task.jpg" class='ms-2'>
                </a>
                <a class="navbar-brand" href="/">Tarefas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="/tasks/create">Criar Tarefa</a>

                        @auth
                            <form action="/logout" method="POST" style="display: inline;">
                                @csrf
                                <a class="nav-link" href="/logout" onclick="event.preventDefault(); this.closest('form').submit();">Sair</a>
                            </form>
                        @endauth

                        @guest
                            <a class="nav-link" href="/login">Login</a>
                            <a class="nav-link" href="/register">Criar conta</a>
                        @endguest
                        

                    </div>
                </div>
            </div>
        </nav>
        </header>
        <main>
            <div class="container-fluid">
                <div class="row">
                @if(session('msg-success'))
                    <p class="msg-success">{{ session('msg-success') }}</p>
                @elseif(session('msg-error'))
                    <p class="msg-error">{{ session('msg-error') }}</p>
                @endif
                    @yield('content')
                </div>
            </div>
        </main>
        <footer>
            <p>Tarefas &copy; 2024</p>
        </footer>

        <script scr="/js/app.js"></script>
        <link rel="stylesheet" href="/css/style.css">
    </body>
</html>
