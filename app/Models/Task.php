<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Task extends Model
{
    protected $connection='mongodb';
    public $timestamps=false;
    
}
