<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'username', 'password', 'email', 'nome', 'cognome'
    ];

    public $timestamps=false;
    public function likes(){
        return $this->hasMany("App\Models\Like");
    }

    public function group(){
        return $this->belongsTo("App\Models\Group");
    }
}
