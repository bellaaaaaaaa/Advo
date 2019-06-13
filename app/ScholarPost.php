<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScholarPost extends Model
{
    protected $fillable = ['title', 'body', 'cover_image'];
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function scholar_post_likes(){
        return $this->hasMany('App\ScholarPostLike');
    }
    public function scholar_post_comments(){
        return $this->hasMany('App\ScholarPostComment');
    }
}
