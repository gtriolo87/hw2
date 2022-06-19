<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $timestamps=false;

    protected $fillable = [
        'title','customer','device','description','latitude','longitude' ,'keywords','hasVideo', 'jobEnded','image', 'endingYear'
    ];

    public function likes(){
        return $this->hasMany("App\Models\Like");
    }
}
