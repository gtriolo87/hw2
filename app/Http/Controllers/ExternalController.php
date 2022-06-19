<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

class ExternalController extends BaseController
{
    public function getToDo(){
        $URL_API_TODO = 'https://api.todoist.com/rest/v1/projects';
        $URL_AUTH_TODO = 'https://todoist.com/oauth/access_token';
        $TODO_CLIENT_ID = 'ef23d98f84c74251892f571d2269bd1a';
        $TODO_CLIENT_SECRET = 'baf733ce1640426c8307a8fca14513b7';
        $TODO_CODE = '82f1232ce332f1d708f2ea5bc4b6f1bebe76a88f';

        $response=array();

        $curl = curl_init($URL_API_TODO);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$TODO_CODE)); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $projects = json_decode(curl_exec($curl));
        if($projects===false){
            //echo "Errore: ". curl_error($curl)."<br/>";
            $response[] = false;
            $response[] ="Errore: ". curl_error($curl)."<br/>";
        } else {            
            $response[] = true;
            $response[] =$projects;
        }
        curl_close($curl);
        

        return ($response);
    }

    public function getVideos($keywords){
        $YOU_TUBE_URL='https://youtube.googleapis.com/youtube/v3/search?part=snippet&maxResults=5&type=video&q=';
    
        if(!is_null($keywords) && !($keywords===" ")){
            $response=array();
            //echo $_GET['keywords'];
            $curl = curl_init($YOU_TUBE_URL.strtr($keywords," ","%20").'&key=AIzaSyA18CoxcFIRxukRKRhyLQentY99KGJOnEQ');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $videos = json_decode(curl_exec($curl));
            if($videos===false){
                //echo "Errore: ". curl_error($curl)."<br/>";
                $response[] = false;
                $response[] ="Errore: ". curl_error($curl)."<br/>";
            } else {
                $response[] = true;
                $response[] =$videos;
            }
            curl_close($curl);
        } else{
            $response[] = false;
            $response[] ="Errore: Nessuna Keywords presente<br/>";
        } 

        return ($response);
    }
}