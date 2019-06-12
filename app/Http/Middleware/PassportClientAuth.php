<?php

namespace App\Http\Middleware;

use Closure;
use Validator;
use App\OauthClient;

class PassportClientAuth{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next){
    $validator = Validator::make($request->headers->all(), [
      // 'password-client-id' => 'required',
      // 'password-client-secret' => 'required',
      'client-id' => 'required',
      'client-secret' => 'required',
      ]);

    if ($validator->fails()) {
      return validationError('client_id or client_secret is missing');
    }
    
    $client_id = $request->header('client-id');
		$client_secret = $request->header('client-secret');
    
    $oauthClient = OauthClient::where('id', $client_id)->where('secret', $client_secret)->first();

    if ($oauthClient == null) {
			return validationError('client_id or client_secret is wrong');
    }

    return $next($request);
  }
}
