<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this software and contact gempixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com) 
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com  
 */

namespace Helpers;

use Core\View;
use Core\Response;
use Core\Request;
use Core\Helper;
use Core\Http;

final class GoogleAuth {

	private $client_id = NULL;
	private $client_secret = NULL;
	private $response = NULL;
	private $redirect_uri = NULL;
	private $auth_url = "https://accounts.google.com/o/oauth2/auth?";
	private $token_url = "https://accounts.google.com/o/oauth2/token?";
	private $info_url = "https://www.googleapis.com/userinfo/v2/me?";

    /**
     * Connect OAuth
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct($client_id, $client_secret, $redirect_uri){

		// Validate Code
        session_regenerate_id();

		if(empty($client_id) || empty($client_secret) || empty($redirect_uri)){
            throw new \Exception("Sorry, Google connect is not available right now.");			
		}

		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->redirect_uri = $redirect_uri;
    }
    /**
     * Generate Redirect URI
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function redirectURI(Request $request){
        
        $state = md5(Helper::rand(32));

		$options = [
			"scope" => "email profile",
			"redirect_uri" => $this->redirect_uri,
			"response_type" => "code",
			"state" => $state,
			"client_id" => $this->client_id
        ];	

        $request->session('oauth_state', $state);

        return $this->auth_url.http_build_query($options);
    }
    /**
     * Get Access Token
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function getAccessToken(Request $request){

        if(!$request->state || $request->state != $request->session('oauth_state')){
            throw new \Exception("Security token doesn't match. Please try again.");
		}		

		$options = [
			"code" => $request->code,
			"client_secret" => $this->client_secret,
			"redirect_uri" => $this->redirect_uri,
			"client_id" => $this->client_id,
			"grant_type" => "authorization_code"
        ];

		$response = Http::url($this->token_url)->body($options)->post();

        $response = json_decode($response);

        // Validate Response
        if(!isset($response->access_token)) { 			
            throw new \Exception('Oops. The access token is not valid. Please try again.');		 			
        }

        $data = Http::url($this->info_url."access_token=".$response->access_token)->get();
        
        $this->response = json_decode($data);
    }
    /**
     * Get User
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function getUser(){
        return $this->response;
    }
}        