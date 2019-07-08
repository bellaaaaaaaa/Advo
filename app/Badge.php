<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    public function users(){
        return $this->belongsToMany('App\User');
    }
    public function school(){
        return $this->belongsTo('App\School');
    }
}
