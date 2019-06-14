<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingTransaction extends Model
{
    public function user() {
        return $this->belongsTo('App\User')->withTimestamps();
    }
    public function funding_package() {
        return $this->belongsTo('App\FundingPackage')->withTimestamps();
    }
    public function funding_target() {
        return $this->belongsTo('App\FundingTarget')->withTimestamps();
    }
    public function funding_receipt() {
        return $this->hasOne('App\FundingReceipt')->withTimestamps();
    }

}
