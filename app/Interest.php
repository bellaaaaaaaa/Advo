<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = ['title'];
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
