<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonte do Google -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

        <!-- Css Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

        <!-- Css e JS -->

        <title>@yield('title') </title>

        <link rel="stylesheet" href="/css/style.css">

        <script src="/js/script.js"></script>
        
    </head>
    <body>

        <header>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbar">
                    <a href="/" class="navbar-brand">
                        <img src="/img/azure-event-hub.svg" alt="AB events">
                    </a>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="/" class="nav-link">Eventos</a>
                        </li>
                        <li class="nav-item">
                            <a href="/events/create" class="nav-link">Criar Evento</a>
                        </li>

                        @auth
                            <li class="nav-item">
                                <a href="/dashboard" class="nav-link">Dashboard</a>
                            </li>

                            <li class="nav-item">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <a href="/logout" class="nav-link" 
                                        onclick=" event.preventDefault();
                                        this.closest('form').submit();">
                                        Sair
                                    </a>
                                </form>
                            </li>

                        @endauth

                        @guest 
                            <li class="nav-item">
                                <a href="/login" class="nav-link">Entrar</a>
                            </li>
                            <li class="nav-item">
                                <a href="/register" class="nav-link">Cadastrar</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>    
        </header>

        <main>
            <div class="container-fluid">
                <div class="row">
                    @if(session('msg'))
                        <p class="msg">{{ session('msg')}}</p>
                    @endif

                    @yield('content')
                    
                </div>
            </div>
        </main>

        <footer>

            <p>AB Events  &copy; 2021</p>

        </footer>

    
    <!-- Modulo Ion-Icon-->

    <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>

    <!-- <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script> -->
    </body>
</html>
