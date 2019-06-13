<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScholarPostComment extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function scholar_post() {
        return $this->belongsTo('App\ScholarPost');
    }
}
