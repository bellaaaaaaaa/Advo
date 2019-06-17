<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingReceipt extends Model
{
    public function funding_transaction(){
        return $this->belongsTo('App\FundingTransaction');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
