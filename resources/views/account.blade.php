@extends('layouts.base')

@section('title', '| Profilo')

@section('script')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}" />
    <script src="{{ asset('js/form.js') }}" defer></script>
@endsection


@section('content')
                
    @if(isset($error)>0){
        Sono presenti errori: <br/>
        {{$n=0;}}
        @foreach ($error as $msg)
            {{$n++}};
            nr. {{$n}}: {{$msg}} <br/>
        @endforeach
    }
    @endif
    @if ($logged)
        <h1>Modifica Profilo</h1>
        <h3>Qui puoi modificare il tuo profilo. Devi inserire la password corretta nella conferma</h3>
    @else
        <h1>Modulo di registrazione al sito</h1>
        <h3>Registrati per avere la possibilità di interagire con i lavori presenti sul sito. Un amministratore valuterà se il tuo profilo ha necessità di permessi aggiuntivi.</h3>
    @endif
    
    <form name="formSignup" method='post' enctype="multipart/form-data" autocomplete="off" action= {{ route('signup')}}>
        @csrf
        <div id="divFormSignup">
            <div class="new_username">
            <label>Username: <input type="text" name="new_username" @if ($logged){ value="{{$user->username}}" readonly="readonly"}@endif></label>
            <span class="hidden">Nome utente non valido o già usato.</span>
            </div>
            <div class="new_password">
            <label>Password: <input type="password" name="new_password" @if ($logged){ value="{{$user->password}}" readonly="readonly"}@endif></label>
            <span class="hidden">Password tra 5 e 10 caratteri.</span>
            </div>
            <div class="checkPassword">
            <label>Conferma Password: <input type="password" name="checkPassword"></label>
            <span class="hidden">Le Password non coincidono.</span>
            </div>
            <div class="name">
            <label>Nome: <input type="text" name="name" @if ($logged){ value="{{$user->nome}}"}@endif></label>
            <span class="hidden">Nome non valido</span>
            </div>
            <div class="surname">
            <label>Cognome: <input type="text" name="surname" @if ($logged){ value="{{$user->cognome}}"}@endif></label>
            <span class="hidden">Cognome non valido</span>
            </div>
            <div class="email">
            <label>E-mail: <input type="text" name="email" @if ($logged){ value="{{$user->email}}"}@endif></label>
            <span class="hidden">E-mail non valida</span>
            </div>
            <input id="btnSignup" type="submit" @if ($logged){ value="Modifica"} @else {value="Registrati"} @endif disabled>
        </div>
    </form>
@endsection