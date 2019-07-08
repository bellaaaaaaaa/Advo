<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function scholars(){
        return $this->hasMany('App\Scholar');
    }
    public function badges(){
        return $this->hasMany('App\Badge');
    }
}
