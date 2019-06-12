<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
  use Notifiable;
  public function interests(){
    return $this->belongsToMany('App\Interest')->withTimestamps();;
  }
  public function badges(){
    return $this->belongsToMany('App\Badge')->withTimestamps();;
  }
  public function funding_targets(){
    return $this->hasMany('App\FundingTarget');
  }
  public function report_cards(){
    return $this->hasMany('App\ReportCard');
  }
  public function is_admin()
  {
    return $this->role == 0;
  }
  public function is_benefactor()
  {
    return $this->role == 1;
  }
  public function is_scholar()
  {
    return $this->role == 2;
  }
/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = [
'name', 'email', 'password', 'role'
];
/**
* The attributes that should be hidden for arrays.
*
* @var array
*/
protected $hidden = [
'password', 'remember_token',
];
}
