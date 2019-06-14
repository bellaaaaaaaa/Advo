<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingTarget extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function funding_transactions(){
        return $this->hasMany('App\FundingTransaction');
    }
}
