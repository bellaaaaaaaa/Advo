<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholar extends Model
{
    protected $fillable = ['user_id', 'school_id', 'school_file'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function scholar_posts(){
        return $this->hasMany('App\ScholarPost');
    }
    public function report_cards(){
        return $this->hasMany('App\ReportCard');
    }
    public function funding_targets(){
        return $this->hasMany('App\FundingTarget');
    }
    public function interests(){
        return $this->belongsToMany('App\Interest');
    }
    public function school(){
        return $this->belongsTo('App\School');
    }
}
