<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Benefactor extends Model
{
    protected $fillable = ['user_id', 'position', 'workplace'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function experiences(){
        return $this->hasMany('App\Experience');
    }
}
