<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingPackage extends Model
{
    protected $fillable = ['title', 'description', 'body', 'payment_method_type'];
    protected $guarded = ['_token'];

    public function funding_transactions(){
        return $this->hasMany('App\FundingTransaction')->withTimestamps();
    }
}
