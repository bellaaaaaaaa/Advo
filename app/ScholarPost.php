<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScholarPost extends Model
{
    protected $fillable = ['title', 'body', 'cover_image'];
    // old
    public function user() {
        return $this->belongsTo('App\User');
    }
    //new
    public function scholar() {
        return $this->belongsTo('App\Scholar');
    }
    public function scholar_post_likes(){
        return $this->hasMany('App\ScholarPostLike');
    }
}
