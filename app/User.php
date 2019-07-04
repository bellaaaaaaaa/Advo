<?php
namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
  use HasApiTokens, Notifiable;
  public function scholar(){
    return $this->hasOne('App\Scholar');
  }
  // old maybe idk
  public function funding_targets(){
    return $this->hasMany('App\FundingTarget');
  }
  // public function report_cards(){
  //   return $this->hasMany('App\ReportCard');
  // }
  public function scholar_posts(){
    return $this->hasMany('App\ScholarPost');
  }
  public function funding_transactions(){
    return $this->hasMany('App\FundingTransaction');
  }
  public function funding_receipts(){
    return $this->hasMany('App\FundingReceipt');
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