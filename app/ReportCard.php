<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    protected $fillable = ['title', 'scholar_id', 'term_start', 'term_end', 'user_id', 'file'];
    // public function user(){
    //     return $this->belongsTo('App\User');
    // }
    public function scholar(){
        return $this->belongsTo('App\Scholar');
    }
}
