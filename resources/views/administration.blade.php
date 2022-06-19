@extends('layouts.base')

@section('title', '| Amministrazione profili')

@section('script')
    <link rel="stylesheet" href="{{ asset('css/administration.css') }}" />
    <script src="{{ asset('js/administration.js') }}" defer></script> 
@endsection


@section('content')
<h1> Gestione Utenti </h1>
<div id="divRicerca">
    <form name="formSearch" id="formSearch">
        <select name="searchProfile">
            <option value="0">Tutti</option>
            <option value="1">Visitatore</option>
            <option value="2">Amministratore</option>
            <option value="3">Manager</option>
            <option value="4">Operatore</option>
        </select>
        <input type="submit" value="Ricerca">
    </form>
    <span>Puoi ricercare solo gli utenti di un particolare profilo.</span>
</div>

<table>
    <thead>
        <tr>
            <th class="colUserId">ID</th>
            <th class="colUsername">Nome Utente</th>
            <th class="colName">Nome</th>
            <th class="colSurname">Cognome</th>
            <th class="colEmail">E-mail</th>
            <th class="colProfile">Profilo</th>
            <th class="colEdit">Salva Modifiche</th>
        </tr>
    </thead>
    
    <!-- il tbody veniva riempito dal js con chiamate asincrone al db
    In Laravel lo riempiro in maniera sincrona poichè la vista verrà richiamata con la lista utenti -->
    <tbody>
        @foreach ($usersList as $row)
        <tr>
            <td class="colUserId">{{$row->id}}</td>
            <td class="colUsername">{{$row->username}}</td>
            <td class="colName">{{$row->nome}}</td>
            <td class="colSurname">{{$row->cognome}}</td>
            <td class="colEmail">{{$row->email}}</td>
            <td class="colProfile">
                <select name="searchProfile" data-user_id="{{$row->id}}">
                    <option value="1" @if($row->group_id===1) selected="selected" @endif>Visitatore</option>
                    <option value="2" @if($row->group_id===2) selected="selected" @endif>Amministratore</option>
                    <option value="3" @if($row->group_id===3) selected="selected" @endif>Manager</option>
                    <option value="4" @if($row->group_id===4) selected="selected" @endif>Operatore</option>
                </select>
            </td>
            <td class="colEdit"><a href="@" data-user_id="{{$row->id}}">Aggiorna</a></td>
        </tr>            
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td class="colUserId">ID</td>
            <td class="colUsername">Nome Utente</td>
            <td class="colName">Nome</td>
            <td class="colSurname">Cognome</td>
            <td class="colEmail">E-mail</td>
            <td class="colProfile">Profilo</td>
            <td class="colEdit">Salva Modifiche</td>
        </tr>
    </tfoot>
</table>
<span id="esitoModifica" class="hidden"></span>
@endsection