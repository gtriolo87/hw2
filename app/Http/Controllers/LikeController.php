<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

class LikeController extends BaseController
{
    //Corrisponde alla richiesta di Tipo 1
    //conta like di un job
    public function countJobLike($jobId){
        $response=array('result'=>0,'message'=>"Conta Like: Non e' presente alcun job con questo ID!",'jobId'=>$jobId,'jobNLikes'=>0);
        $oJob=Job::find($jobId);
        if ($oJob){
            $response['result']=1;
            $response['message']="Conta Like: Numero di like prelevato";
            $response['jobNLikes']=$oJob["nLikes"];
        }
        return ($response);
    }

    //Corrisponde alla richiesta di Tipo 2
    //Verifica se l'utente ha inserito like ad un job
    public function checkUserJobLike($jobId,$userId){
        $response=array('result'=>0,'message'=>"Errore nel passaggio parametri",'jobId'=>$jobId,'esito'=>false);
        $oJob=Job::find($jobId);
        if ($oJob){
            $oLike=Like::where("job_id",$oJob->id)
            ->where("user_id",$userId)
            ->first();
            if ($oLike){
                $response['result']=2; //Per retrocompatibilità il risultato è di tipo 2
                $response['message']="Controlla Like Utente: e' presente il like!";
                $response['jobId']=$oLike['job_id'];
                $response['esito']=true;
            } else{
                $response['result']=2; //Per retrocompatibilità il risultato è di tipo 2
                $response['message']="Controlla Like Utente: Non sono presenti like!";
                $response['jobId']=$jobId;
                $response['esito']=false;
            }
            $response['jobNLikes']=$oJob["nLikes"];
        } else {
            $response['message']="Non e' presente alcun job con questo ID!";
            $response['esito']=false;
        }
        return ($response);
    }

    //Corrisponde alla richiesta di Tipo 3
    //Verifica se l'utente ha inserito like ad un job
    public function addLike($jobId,$userId){
        $response=array('result'=>0,'message'=>"Modifica Like Utente: Utente non Loggato!",'esito'=>false);
        if (!is_null(session("_hw1_user_id",null))){
            if(session("_hw1_user_id")===intval($userId)){
                if(Job::find($jobId)){
                    $oLike=Like::where("job_id",$jobId)
                    ->where("user_id",$userId)
                    ->first();
                    if($oLike){
                        if ($oLike->delete()){
                            $response['result']=3; //Per retrocompatibilità il risultato è di tipo 2
                            $response['message']="Modifica Like Utente: Cancellazione eseguita";
                            $response['esito']=true;
                        } else{
                            $response['result']=0; //Per retrocompatibilità il risultato è di tipo 2
                            $response['message']="Modifica Like Utente: Cancellazione Fallita";
                            $response['esito']=false;
                        }
                    } else{
                        $oLike=New Like;
                        $oLike->user_id=$userId;
                        $oLike->job_id=$jobId;
                        if ($oLike->save()){
                            $response['result']=3; //Per retrocompatibilità il risultato è di tipo 2
                            $response['message']="Modifica Like Utente: Inserimento eseguito";
                            $response['esito']=true;
                        } else{
                            $response['result']=0; //Per retrocompatibilità il risultato è di tipo 2
                            $response['message']="Modifica Like Utente: Inserimento Fallito";
                            $response['esito']=false;
                        }
                    }
                } else {
                    $response['message']="Modifica Like Utente: Non esistono job con questo ID!";
                }
            } else{
                $response['message']="Modifica Like Utente: L'utente loggato non corrisponde a quello di cui si vogliono modificare i like. Sessione:". session("_hw1_user_id") . " Utente:".$userId;
            }

        }
        return ($response);
    }
}