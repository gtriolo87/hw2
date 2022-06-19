<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps=false;
    
    public function user(){
        return $this->belongsTo("App\Models\User");
    }

    public function job(){
        return $this->belongsTo("App\Models\Job");
    }
}
