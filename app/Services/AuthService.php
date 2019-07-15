<?php

namespace App\Services;

use DB;
use Carbon\Carbon;

use App\User;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AuthService{

 public function login(Request $request) {
   $user = User::where('mobile', $request->mobile)->first();
   if($user == null){
     return unauthorizedResponse('Looks like this account has not been registered yet. Please proceed to sign-up page.');
   }
        if($user){
            $user->login_count += 1;
            $user->save();
     return $this->createToken($request, $user);
   }
  }

 public function createToken(Request $request, User $user) {
        $tokenExist = DB::table("oauth_access_tokens")->where("user_id", $user->id)->where("revoked", 0)->first();
        if($tokenExist != null) {
            DB::table('oauth_refresh_tokens')->where('access_token_id', $tokenExist->id)->update(['revoked' => true]);
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->update(['revoked' => true]);
   }

        $response = $this->generateOauthRequest($request, $user);
   $responseBody = json_decode($response->getBody());
        
        $player = $user->player;
        $player->last_login = Carbon::now();
        $player->save();
        
   return $this->transform($responseBody, $user);
 }

 public function generateOauthRequest(Request $request, User $user = null){
   $http = new Client();
        if ($user) {
            $form_params = [
                'grant_type' => 'password',
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
                'username' => $request->mobile ? $request->mobile : $user->mobile,
       'password' => $request->password ? $request->password : 'allianz10@Passw0rd',
       'scope' => '*'
            ];
        }else {
            $form_params = [
                'grant_type' => 'refresh_token',
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
                'refresh_token' => $request->refresh_token
            ];
   }

        $response = $http->post(url('oauth/token'), [
            'verify' => false,
            'form_params' => $form_params,
   ]);

        return $response;
    }

    public function refreshToken(Request $request) {
        $user = User::where("id", $request->user_id)->first();
        if (!$user) {
            return notFoundError();
        }
        $response = $this->generateOauthRequest($request);
        $responseBody = json_decode($response->getBody());
        return $this->transform($responseBody, $user);
    }

 public function transform($response, $user) {
        $expires_at = DB::table("oauth_access_tokens")->where("user_id", $user->id)->where("revoked", 0)->first()->expires_at;
        return [
            'nickname' => $user->player->nickname,
            'access_token' => $response->access_token,
            'refresh_token' => $response->refresh_token,
            'user_id' => $user->id,
            'user_avatar' => $user->player->avatar,
            'expires_at' => $expires_at
        ];
    }
}