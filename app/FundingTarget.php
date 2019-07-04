<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingTarget extends Model
{
    protected $fillable = ['title', 'amount', 'amount_gained', 'status', 'user_id', 'scholar_id'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function scholar(){
        return $this->belongsTo('App\Scholar');
    }
    public function funding_transactions(){
        return $this->hasMany('App\FundingTransaction');
    }
}
