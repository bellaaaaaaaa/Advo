<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    public function benefactor(){
        return $this->belongsTo('App\Benefactor');
    }
}
