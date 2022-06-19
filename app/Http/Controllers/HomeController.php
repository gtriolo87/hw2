<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    //funzione di apertura pagina base con controllo header
    public function index(){
        
        $session_id = session('_hw1_user_id');
        if ($session_id){
            $user = User::find($session_id);
            return view("index")
                ->with("user", $user)
                ->with("logged", true);
        } else{
            return view("index")
                ->with("logged", false);
        }
    }
}