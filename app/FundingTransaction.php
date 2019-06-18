<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingTransaction extends Model
{
    protected $fillable = ['benefactor_id', 'scholar_id', 'funding_target_id', 'amount_cents', 'funding_package_id', 'payment_method'];
    protected $guarded = ['_token', 'stripeToken'];

    public function benefactor() {
        return $this->belongsTo('App\User', 'benefactor_id');
    }
    public function scholar() {
        return $this->belongsTo('App\User', 'scholar_id');
    }
    public function funding_package() {
        return $this->belongsTo('App\FundingPackage');
    }
    public function funding_target() {
        return $this->belongsTo('App\FundingTarget');
    }
    public function funding_receipt() {
        return $this->hasOne('App\FundingReceipt');
    }

}
