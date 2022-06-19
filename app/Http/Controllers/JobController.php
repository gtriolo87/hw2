<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

class JobController extends BaseController
{
    //funzione di controllo dati
    private function checkField($data){
        $error=array();

        //CONTROLLO DEI DATI INSERITI
        if (!preg_match('/^[a-zA-Z \']{1,255}$/', $data['jobTitle'])) {
            $error[] = "Titolo non valido: ".$data['jobTitle'];
        }
        if (!preg_match('/^[a-zA-Z -.\/]{1,255}$/', $data['jobCustomer'])) {
            $error[] = "Cliente non valido";
        }
        if (!preg_match('/^[0-9a-zA-Z -.\/]{1,255}$/', $data['jobDevice'])) {
            $error[] = "Dispositivo non valido";
        }
        if (!preg_match('/^[0-9]{0,4}$/', $data['jobEndingYear'])) {
            $error[] = "Anno di fine non valido";
        }
        if (!(strlen($data['jobDescription'])>=1 && strlen($data['jobDescription'])<=1000)) {
            $error[] = "Descrizione non valida: ". strlen($data['jobDescription']);
        }
        if (!preg_match('/^[0-9.,]{1,20}$/', $data['jobLat'])) {
            $error[] = "Latitudine non valida";
        }
        if (!preg_match('/^[0-9.,]{1,20}$/', $data['jobLong'])) {
            $error[] = "Longitudine non valida";
        }
        if (!preg_match('/^[0-9a-zA-Z -]{0,255}$/', $data['jobKeywords'])) {
            $error[] = "Parole Chiave non valide";
        }
        if (!is_bool(boolval($data['jobHasVideo']))) {
            $error[] = 'Errore nel parametro booleano "Esistono Video" '. $data['jobHasVideo'];
        }
        if (!is_bool(boolval($data['jobEnded']))) {
            $error[] = 'Errore nel parametro booleano "Lavoro Finito" '. $data['jobEnded'];
        }

        # Verifica immagine  
        
        if (!preg_match('/^[0-9a-zA-Z.-:\/]{0,255}$/', $data['jobImage'])) {
            $error[] = "Percorso immagine non valido";
        }

        return $error;
    }

    public function getJobs(){
        $jobs=Job::all();
        $response['result']=1; //Per retrocompatibilità il risultato è di tipo 1
        $response['message']="Job trovati!";
        $response['jobList']=$jobs;

        return $response;
    }

    public function getJob($jobId){
        $job=Job::find($jobId);
        return ($job);
    }

    public function editJob(){
        $response=array('result'=>0,'message'=>"Utente non loggato.");
        if (!is_null(session("_hw1_user_id",null))){
            if((New UserController)->checkJobPermissions(session("_hw1_user_id"))){
                $postData=request();
                $postData->validate([
                    'jobId'=>['required'],
                    'jobTitle'=>['required'],
                    'jobCustomer'=>['required'],
                    'jobDevice'=>['required'],
                    'jobDescription'=>['required'],
                    'jobLat'=>['required'],
                    'jobLong'=>['required'],
                    'jobHasVideo'=>['required'],
                    'jobEnded'=>['required']
                ]);
                $error=$this->checkField($postData);
                if(count($error)===0){
                    $oJob=Job::find($postData['jobId']);
                    $oJob->title=$postData['jobTitle'];
                    $oJob->customer=$postData['jobCustomer'];
                    $oJob->device=$postData['jobDevice'];
                    $oJob->endingYear= filter_var($postData['jobEndingYear'],FILTER_VALIDATE_INT,FILTER_NULL_ON_FAILURE);
                    $oJob->description=$postData['jobDescription'];
                    $oJob->latitude=filter_var($postData['jobLat'],FILTER_VALIDATE_FLOAT);
                    $oJob->longitude=filter_var($postData['jobLong'],FILTER_VALIDATE_FLOAT);
                    $oJob->keywords=request('jobKeywords',null);
                    $oJob->hasVideo= filter_var($postData['jobHasVideo'], FILTER_VALIDATE_BOOLEAN);
                    $oJob->jobEnded=filter_var($postData['jobEnded'], FILTER_VALIDATE_BOOLEAN);
                    $oJob->image=request('jobImage',"images/jobs/defaultJob.png");

                    if($oJob->save()){
                        $response['result']=1; //Per retrocompatibilità il risultato è di tipo 2
                        $response['message']="Job ".$postData['jobId']." Aggiornato. Ricorda di caricare in FTP l'immagine.";
                        $response['jobId']=$postData['jobId'];
                    } else{
                        $response['result']=0; //Per retrocompatibilità il risultato è di tipo 2
                        $response['message']="Errore durante l'aggiornamento del job!";
                    }
                } else {
                    $response['result']=3; //Per retrocompatibilità il risultato è di tipo 2
                    $response['message']="Errore nei dati di aggiornamento";
                    $response['errori']=$error;
                }
            } else{
                $response['message']="L'utente non ha i permessi per eseguire la richiesta.";
            }

        }
        return ($response);
    }

    public function addJob(){
        $response=array('result'=>0,'message'=>"Utente non loggato.");
        if (!is_null(session("_hw1_user_id",null))){
            if((New UserController)->checkJobPermissions(session("_hw1_user_id"))){
                $postData=request();
                $postData->validate([
                    'jobTitle'=>['required'],
                    'jobCustomer'=>['required'],
                    'jobDevice'=>['required'],
                    'jobDescription'=>['required'],
                    'jobLat'=>['required'],
                    'jobLong'=>['required'],
                    'jobHasVideo'=>['required'],
                    'jobEnded'=>['required']
                ]);
                $error=$this->checkField($postData);
                if(count($error)===0){
                    $oJob =  Job::create([
                        'title' => $postData['jobTitle'],
                        'customer' => $postData['jobCustomer'],
                        'device' => $postData['jobDevice'],
                        'description' => $postData['jobDescription'],
                        'latitude' => filter_var($postData['jobLat'],FILTER_VALIDATE_FLOAT),
                        'longitude' => filter_var($postData['jobLong'],FILTER_VALIDATE_FLOAT),
                        'keywords' => request('jobKeywords',null),
                        'hasVideo' => filter_var($postData['jobHasVideo'], FILTER_VALIDATE_BOOLEAN),
                        'jobEnded' => filter_var($postData['jobEnded'], FILTER_VALIDATE_BOOLEAN),
                        'image' => request('jobImage',"images/jobs/defaultJob.png"),
                        'endingYear' => filter_var($postData['jobEndingYear'],FILTER_VALIDATE_INT,FILTER_NULL_ON_FAILURE)
                        ]);
                    /*$oJob=New Job;
                    $oJob->title=$postData['jobTitle'];
                    $oJob->customer=$postData['jobCustomer'];
                    $oJob->device=$postData['jobDevice'];
                    if (isset($postData['jobEndingYear'])){
                        $oJob->endingYear=$postData['jobEndingYear'];
                    }
                    $oJob->description=$postData['jobDescription'];
                    $oJob->latitude=$postData['jobLat'];
                    $oJob->longitude=$postData['jobLong'];
                    $oJob->keywords=$postData['jobKeywords'];
                    $oJob->hasVideo=$postData['jobHasVideo'];
                    $oJob->jobEnded=$postDa-* ta['jobEnded'];
                    if (isset($postData['jobImage'])){
                        $oJob->image=$postData['jobImage'];
                    }*/
                    if($oJob){
                        $response['result']=2; //Per retrocompatibilità il risultato è di tipo 1
                        $response['message']="Job Inserito. Ricorda di caricare in FTP l'immagine.";
                        $response['jobId']=$oJob->id;
                    } else{
                        $response['result']=3; //Per retrocompatibilità il risultato è di tipo 0
                        $response['message']="Errore durante l'inserimento del job!";
                        $response['errori']="Creazione Fallita";
                    }
                } else {
                    $response['result']=3; //Per retrocompatibilità il risultato è di tipo 3
                    $response['message']="Errore nei dati di inserimento";
                    $response['errori']=$error;
                }
                
            } else{
                $response['message']="L'utente non ha i permessi per eseguire la richiesta.";
            }

        }
        return ($response);
    }

    public function searchJob(){
        $keyRicerca=request('keyRicerca',"");
        $error[] = "Chiave di ricerca non valida: ".$keyRicerca;
        $response=array();
        
        if (preg_match('/^[0-9a-zA-Z -]{0,255}$/', $keyRicerca)) {
            $paroleChiave=explode(" ", $keyRicerca);
            $nParole=0;
            $jobDataArray=Job::where('keywords','like','%'.$paroleChiave[0].'%')
                            ->OrWhere('description','like','%'.$paroleChiave[0].'%');
            foreach($paroleChiave as $word){
                if ($nParole>0){
                    $jobDataArray->OrWhere('keywords','like','%'.$word.'%')
                                ->OrWhere('description','like','%'.$word.'%');
                }
                $nParole++;
            }
            $jobDataArray=$jobDataArray->get();

            if(count($jobDataArray)===0){
                $response['result']=0; //Per retrocompatibilità il risultato è di tipo 0
                $response['message']="Non e' presente alcun job con queste chiavi!";
            } else{
                $response['result']=1; //Per retrocompatibilità il risultato è di tipo 1
                $response['message']="Job trovati!";
                $response['jobList']=$jobDataArray;
            }
        } else {
            $response['result']=3; //Per retrocompatibilità il risultato è di tipo 3
            $response['message']="Errore nei dati di inseriti";
            $response['errori']=$error;
        }
        

        return $response;
    }

    public function indexJob($jobId){
        $jobData=$this->getJob($jobId);
        $session_id = session('_hw1_user_id');
        $user = User::find($session_id);
        if ($user){
            $canManageJob=(New UserController)->checkJobPermissions($session_id); 
        } else{
            $canManageJob=false;
        }
        $jobError=is_null($jobData);
        return view("job")
            ->with("user", $user)
            ->with("jobData",$jobData)
            ->with("logged", !is_null($user))
            ->with("canManageJob",$canManageJob)
            ->with("jobError",$jobError);
    }

    public function index(){
        $session_id = session('_hw1_user_id');
        if ($session_id){
            $user = User::find($session_id);
            if((New UserController)->checkJobPermissions($session_id)){
                return view("job")
                    ->with("user", $user)
                    ->with("jobData",null)
                    ->with("logged", true)
                    ->with("canManageJob",true)
                    ->with("jobError",false);
            }
        }
        return redirect('/');
    }
}