<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Session;

use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController{
    public function getUsers(){
        $users=User::all();
        return $users;
    }

    public function getUsersFiltered($groupId){
        $users=User::where('group_id',$groupId)->get();
        return $users;
    }

    public function checkUsername($username){
        $exist=User::where('username',$username)->exists();
        return (array('exist'=>$exist));
    }

    public function checkEmail($email){
        $exist=User::where('email',$email)->exists();
        return ($exist);
    }

    public function checkAdminPermission($userId){
        $userGroup=User::findOrFail($userId)->group()->first();
        $result=$userGroup->canManageUsers;
        return ($result);
    }

    public function checkJobPermissions($userId){
        $userGroup=User::findOrFail($userId)->group()->first();
        $result=$userGroup->canAddJob || $userGroup->canEditJob;
        return ($result);
    }

    public function checkLikePermissions($userId){
        $userGroup=User::findOrFail($userId)->group()->first();
        $result=$userGroup->canLike;
        return ($result);
    }

    public function checkManageTaskPermissions($userId){
        $userGroup=User::findOrFail($userId)->group()->first();
        $result=$userGroup->canAddTask || $userGroup->canEditTask;
        return ($result);
    }

    public function checkWorkTaskPermissions($userId){
        $userGroup=User::findOrFail($userId)->group()->first();
        $result=$userGroup->canWorkTask;
        return ($result);
    }

    public function editUserGroup($userId,$groupId){
        $response=array('message'=>"Utente non Loggato!");
        if (!is_null(session("_hw1_user_id",null))){
            if($this->checkAdminPermission(session("_hw1_user_id"))){
                if(Group::find($groupId)){
                    $user=User::findOrFail($userId);
                    $user->group_id=$groupId;
                    if($user->save()){
                        $response['message'] = "Modifica utente ". $userId ." eseguita con successo";
                    } else {
                        $response['message'] = "Errore nella modifica Utente";
                    }
                } else{
                    $response['message']="Non esiste il gruppo scelto";
                }
            } else{
                $response['message']="Non si hanno privilegi di amministrazione";
            }

        }
        return ($response);
    }

    public function signup(){
        $postData=request();

        if ($postData){
            $error = array();
            $session_id = session('_hw1_user_id');

            if ($session_id){
                $user = User::find($session_id);
                $oldPassword=$user->password;
                $oldName=$user->nome;
                $oldSurname=$user->cognome;
                $oldEmail=$user->email;
                $logged=true;
            } else{
                $logged=false;
            }

            if (!empty($postData["new_username"]) && !empty($postData["new_password"]) && !empty($postData["email"]) && !empty($postData["name"]) && !empty($postData["surname"]) && !empty($postData["checkPassword"])){
                
                //Controllo Username POST
                if(!preg_match('/^[0-9a-zA-Z_.-]{2,15}$/', $postData['new_username'])) {
                    $error[] = "Username non valido";
                } else {
                    $username = $postData['new_username'];
                    // Controllo la disponibilità dello Username
                    if(!$logged){
                        $exist=$this->checkUsername($username);
                        if ($exist['exist']) {
                            $error[] = "Username già utilizzato";
                        }
                    }
                }
    
                //Controllo Password
                if (!preg_match('/^[0-9a-zA-Z_!.-]{5,10}$/', $postData['new_password'])) {
                    $error[] = "La password non rispetta i requisiti";
                } 
    
                // Controlla conferma PASSWORD
                if (strcmp($postData["new_password"], $postData["checkPassword"]) != 0) {
                    $error[] = "Le password non coincidono";
                }
    
                // Controlla E-mail
                if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
                    $error[] = "Email non valida";
                } else {
                    $email = strtolower($postData['email']);
                    if(!$logged || ($logged && ($oldEmail!==$email))){
                        $exist=$this->checkEmail($email);
                        if ($exist) {
                            $error[] = "Email già utilizzata";
                        }
                    }
                }
    
                // Controlla Nome
                if (!preg_match('/^[a-zA-Z ]{1,25}$/', $postData['name'])) {
                    $error[] = "Nome non valido";
                }
    
                // Controlla Cognome
                if (!preg_match('/^[a-zA-Z ]{1,25}$/', $postData['surname'])) {
                    $error[] = "Cognome non valido";
                }
    
                //Controllo per inserimento utente o aggiornamento
                if (count($error) == 0) {
                    
                    $name = $postData['name'];
                    $surname = $postData['surname'];
                    $password = $postData['new_password'];
                    
                    if ($logged){
                        $user->nome=$name;
                        $user->cognome=$surname;
                        $user->email=$email;
                        if ($user->save()) {
                            return redirect('/');
                        } else {
                            $error[] = "Errore Modifica Utente";
                            return view('account')
                                ->with("user", $user)
                                ->with("logged", $logged)
                                ->with("error", $error);
                        }
                    } else {
                        $user =  User::create([
                        'username' => $username,
                        'password' => $password,
                        'nome' => $name,
                        'cognome' => $surname,
                        'email' => $email
                        ]);
                        if ($user) {
                            session(['_hw1_user_id'=>$user->id]);
                            session(['_hw1_user_name'=>$user->username]);
                            $logged=true;
                            return redirect('/');
                        } else {
                            $error[] = "Errore Creazione utente";
                            return view('account')
                                ->with("user", $user)
                                ->with("logged", $logged)
                                ->with("error", $error);
                        }
                    }
                    
                }
            } else if (isset($postData["new_username"])) {
                $error = array("Riempi tutti i campi");

                return view('account')
                        ->with("user", $user)
                        ->with("logged", $logged)
                        ->with("error", $error);
            } else {
                return view('account')
                        ->with("user", $user)
                        ->with("logged", $logged);
            }
        } else {
            //Se non sono presenti dati POST allora ritorno alla pagina senza fare nulla
            return view("account")
                ->with("logged", false);
        }
        
    }

    public function login(){
        $session_id = session('_hw1_user_id');
        if ($session_id){
            $user = User::find($session_id);
            return view("index")
                ->with("user", $user)
                ->with("logged", true);
        } else{
            $username=request('username',null);
            $password=request('password',null);
            if(is_null($username)||is_null($password)){
                return redirect('/');
            }else{
                request()->validate([
                    'username'=>['required', 'string', 'regex:/^[0-9a-zA-Z_.-]{2,15}$/'],
                    'password'=>['required', 'string', 'regex:/^[0-9a-zA-Z_!.-]{5,10}$/']
                ]);
                $user=User::where('username',$username)
                        ->where('password',$password)
                        ->first();
                if ($user){
                    session(['_hw1_user_id'=>$user->id]);
                    session(['_hw1_user_name'=>$user->username]);
                    return redirect('/');
                } else{
                    return view("index")
                        ->with("error", true)
                        ->with("logged", false);
                }
            }
        }
    }
    public function logout(){
        $session_id = session('_hw1_user_id');
        if ($session_id){
            Session::flush();
            return redirect('/');
        }
    }
    public function index(){
        $session_id = session('_hw1_user_id');
        if ($session_id){
            $user = User::find($session_id);
            return view("account")
                ->with("user", $user)
                ->with("logged", true);
        } else{
            return view("account")
                ->with("logged", false);
        }
    }

    public function test(){
        return view("users");
    }
}
