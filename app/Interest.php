<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = ['title'];
    public function scholars(){
        return $this->belongsToMany('App\Scholar');
    }
}
