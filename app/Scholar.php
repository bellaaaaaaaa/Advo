<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholar extends Model
{
    public function scholar_posts(){
        return $this->hasMany('App\ScholarPost');
    }
    public function report_cards(){
        return $this->hasMany('App\ReportCard');
    }
}
