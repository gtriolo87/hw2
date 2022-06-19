<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    private function getUsers($groupId=null){
        $userController=New UserController;
        if(!is_null( filter_var($groupId,FILTER_VALIDATE_INT,FILTER_NULL_ON_FAILURE))){
            $users=$userController->getUsersFiltered($groupId);
        } else {
            $users=$userController->getUsers();
        }
        return $users;
    }

    //funzione di apertura pagina base con controllo header
    public function index(){
        
        $session_id = session('_hw1_user_id');
        if ($session_id){
            $user = User::find($session_id);
            $userController=New UserController;
            if($userController->checkAdminPermission($user->id)){
                $groupId=filter_var(request("searchProfile"),FILTER_VALIDATE_INT,FILTER_NULL_ON_FAILURE);
                if ($groupId===0 || is_null($groupId)){
                    $users=$this->getUsers();
                } else{
                    $users=$this->getUsers($groupId);
                }
                return view("administration")
                    ->with("user", $user)
                    ->with("logged", true)
                    ->with("usersList",$users);
            }
        }
        return view("index")
            ->with("logged", false);
    }

    
    //funzione di apertura pagina base con controllo header
    public function filterUsers($groupId){
        $session_id = session('_hw1_user_id');
        if ($session_id){
            $user = User::find($session_id);
            $userController=New UserController;
            if($userController->checkAdminPermission($user->id)){
                $users=$this->getUsers($groupId);
                return view("administration")
                    ->with("user", $user)
                    ->with("logged", true)
                    ->with("usersList",$users);
            }
        }
        return view("index")
            ->with("logged", false);
    }
    
}