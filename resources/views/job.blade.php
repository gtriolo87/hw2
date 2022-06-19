@extends('layouts.base')

@section('title', '| Gestione Lavori')

@section('script')
    <link rel="stylesheet" href="{{ asset('css/job.css') }}" />
    <script src="{{ asset('js/job.js') }}" defer></script>
@endsection


@section('content')
<div id="divEditJob">
    @if (is_null($jobData))
        <h1>Modulo di Inserimento nuovo Lavoro</h1>
    @else 
        <h1>Modifica Lavoro</h1>
    @endif
    <form name="formAddJob" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="jobTitle">
            <label>Titolo: <input type="text" name="jobTitle" @if(!is_null($jobData)) value="{{ $jobData->title }}" @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden">Titolo non valido.</span>
        </div>
        <div class="jobCustomer">
            <label>Cliente: <input type="text" name="jobCustomer" @if(!is_null($jobData)) value="{{ $jobData->customer }}" @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden">Cliente non valido.</span>
        </div>
        <div class="jobDevice">
            <label>Dispositivo/SCADA: <input type="text" name="jobDevice" @if(!is_null($jobData)) value="{{ $jobData->device }}" @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden">Dispositivo non valido.</span>
        </div>
        <div class="jobEndingYear">
            <label>Anno fine Lavoro: <input type="text" name="jobEndingYear" @if(!is_null($jobData)) value="{{ $jobData->endingYear }}" @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden">Anno non valido.</span>
        </div>
        <div class="jobDescription">
            <label>Descrizione: <input type="textbox" name="jobDescription" @if(!is_null($jobData)) value="{{ $jobData->description }}" @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden">Descrizione non valida.</span>
        </div>
        <div class="jobLat">
            <label>Latitudine: <input type="text" name="jobLat" @if(!is_null($jobData)) value="{{ $jobData->latitude }}" @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden">Latitudine non valida.</span>
        </div>
        <div class="jobLong">
            <label>Longitudine: <input type="text" name="jobLong" @if(!is_null($jobData)) value="{{ $jobData->longitude }}" @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden">Longitudine non valida.</span>
        </div>
        <div class="jobKeywords">
            <label>Parole Chiave: <input type="text" name="jobKeywords" @if(!is_null($jobData)) value="{{ $jobData->keywords }}" @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden">Parole chiave non valide.</span>
        </div>
        <div class="jobImage">
            <label>Scegli un'immagine: <input type="text" name="jobImage" @if(!is_null($jobData)) value="{{ $jobData->image }}" @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden">Inserisci un url corretto.</span>
        </div>
        <div class="jobHasVideo">
            <label>Presenza Video su YouTube? <input type="checkbox" name="jobHasVideo" @if(!is_null($jobData) && $jobData->hasVideo) checked  @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden"> </span>
        </div>
        <div class="jobEnded">
            <label>Lavoro Finito? <input type="checkbox" name="jobEnded" @if(!is_null($jobData) && $jobData->jobEnded) checked  @endif @if(!$canManageJob) disabled  @endif></label>
            <span class="hidden"> </span>
        </div>
        <div class="jobSubmit">
            <input id="btnSubmit" type="submit" 
            @if (is_null($jobData))
                value="Inserisci"
            @else 
                value="Modifica" data-job_id="{{ $jobData->id }}"
            @endif
            disabled>
        <strong  @if (!$jobError)  class="hidden"  @endif>Esito: </strong>
        </div>
    </form>
</div>
@endsection