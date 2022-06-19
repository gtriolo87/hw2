
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebProgramming - Homework 2 @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@500&family=Kanit&family=Righteous&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <script src="{{ asset('js/header.js') }}" defer></script>
    @yield('script')
    
    <script type="text/javascript">
        const CSFR_TOKEN = '{{ csrf_token() }}';
    </script>
</head>

    <body>
        <article>
            <header>
                <nav>
                    <div id="menu">
                        <a class="menu-item" href="{{route('index')}}">Home</a>
                        <a class="menu-item" id="btnLogin">Login</a>
                    </div>
                    <div id="loginWindow"
                    @if ( !isset($error) ) 
                        class="hidden"
                    @endif>
                        <div id="divFormLogin"
                        @if ( $logged )
                            class="hidden"
                        @endif>
                            <form name="formLogin" method="post" action="{{ route ('login')}}">
                                @csrf
                                <label>Nome Utente: <input type="text" name="username"></label>
                                <label>Password: <input type="password" name="password"></label>
                                <label>
                                    @if ( isset($error) ) 
                                        <span>Dati Errati</span>
                                    @endif
                                    <input id="btnSignin" type="submit" value="Accedi">
                                </label>
                            </form>
                            <div class="signup">Non hai un account? <a href="{{route('account')}}">Iscriviti</a></div>
                        </div>
                        <div id="divLogged" 
                        @if ( $logged )
                            data-user-id="{{ $user->id }}" 
                        @else
                            class="hidden"
                        @endif>
                            <div>
                                <span>Benvenuto @if( $logged ) {{$user->username}}@endif!</span>
                                <a href="{{route('account')}}">Profilo</a>
                                @if ( $logged )
                                    
                                    @inject('UserController', 'App\Http\Controllers\UserController' )
                                    @if ( $UserController->checkAdminPermission($user->id)=='1' )
                                        <a href="{{route('administration')}}">Amministrazione</a>
                                    @endif
                                    @if ( $UserController->checkJobPermissions($user->id)=='1' )
                                        <a href="{{route('job')}}">Nuovo Job</a>
                                    @endif
                                @endif
                                <a href="{{route('logout')}}">LogOut</a>
                            </div>
                        </div>
                    </div>
                </nav>
                <div id="title">
                    <h1>BitControl: Gestione lavori</h1>
                </div>
            </header>
            
            
            <section id="content">
                @yield('content')
            </section>

            <footer>
                <span>
                    Powered By <em>Giuseppe Triolo Puleio - Matr. 100/0041524</em><br />
                    Corso di WebProgramming - Ingegneria Informatica 2021/2022<br />
                    Università di Catania
                </span>
            </footer>
        </article>
    </body>
</html>