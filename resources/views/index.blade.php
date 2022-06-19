@extends('layouts.base')

@section('title', '| Home')

@section('script')
<script src="{{ asset('js/script.js') }}" defer></script>
@endsection


@section('content')
<section id="ToDo" class="hidden">
    <section class="intro">
        <h2>Impianti Work in Progress</h2>
        <p>Di seguito gli impianti in ToDo List.</p>
    </section>
    <section id="job-ToDo">
        <!-- popolato da javascript dopo fetch verso php interno che inoltra la richiesta al servizio esterno -->
    </section>
</section>

<section class="intro">
    <h2 class=interno>Impianti realizzati</h2>
    <p>Di seguito un elenco degli impianti di automazione realizzati.</p>
</section>

<section>
    <div id="divRicerca">
        <form name="formSearch" id="formSearch">
            <input type="text" name="keyRicerca" id="keyRicerca">
            <input type="submit" value="Ricerca" id="btnRicerca">
        </form>
        <span>Puoi ricercare i lavori con delle parole chiave<br/>(Non sono accettati simboli e devono essere separati solo da spazi).</span>
    </div>
</section>

<section id="job-list">
    <!-- popolato da javascript dopo fetch verso php interno
    viene popolato anche dopo una ricerca con parole chiave -->
</section>

<section id="overlay" class="hidden">
    <div class="close">
        <img src="images/x_close.png" />
    </div>
    <div class="content">
    </div>
</section>
@endsection