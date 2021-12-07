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

namespace Middleware;

use Core\Helper;
use Core\Request;
use Core\Response;

final class Auth {
	/**
	 * Set Redirect 
	 * @var string
	 */
	protected $redirecto = "user/login";
	/**
	 * Redirect Error message
	 * @var string
	 */
	protected $message = "You need to be logged in to access this page.";
	/**
	 * Handle Auth
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function handle() {
		if(\Core\Auth::check() === false) {
			Helper::redirect($this->redirecto)->with("danger", e($this->message));
			exit;
		}

		$user = \Core\Auth::user();

		if(config('pro') && !$user->admin){

			if(!$user->teamid && !$user->pro && is_null($user->planid) || !\Core\DB::plans()->where('id', $user->planid)->first()){
				if($plan = \Core\DB::plans()->where('free', 1)->orderByDesc('id')->first()){					
					$user->pro = '0';
					$user->planid = $plan->id;
					$user->trial = '0';
					$user->save();
				}else{
					return \Core\Helper::redirect()->to(route('pricing'))->with('success', e('Please upgrade to a premium package in order to continue.'));
				}
			}

			if($user->pro && strtotime($user->expiration) < time() || ($user->trial && strtotime('now') > strtotime($user->expiration))) {
				$user->pro = 0;
				$user->planid = null;
				$user->trial = 0;
				$user->save();
			}

			\Core\Auth::check();
		}		

		
		return true;
	}
	/**
	 * Check if user is admin
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @return void
	 */
	public function admin(){
		if(\Core\Auth::check() === false) {
			\GemError::trigger(404, 'Page not found');
			exit;
		}
		if(!\Core\Auth::user()->admin){
			\GemError::trigger(404, 'Page not found');
			exit;
		}

		return true;
	}
	/**
	 * Check Auth via API
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function api(){

		if(!config("api")) die(Response::factory(['error' => 1, 'message' => 'API service is disabled.'], 403)->json());
        
        $request = new Request();

        $key = str_replace('Token ', '', $request->server('http_authorization'));
        
        $key = str_replace('Bearer ', '', $key);

        if(\Core\Auth::ApiUser($key) == false){
            die(Response::factory(['error' => 1, 'message' => 'A valid API key is required to use this service.'], 403)->json());
        }

        if(config('pro') && !\Core\Auth::ApiUser()->admin){
            if(!\Core\Auth::ApiUser()->has('api') || \Core\Auth::ApiUser()->banned){
                die(Response::factory(['error' => 1, 'message' => 'You do not have the permission to use the API.'], 403)->json());
            }
        }

		if(!\Core\Auth::ApiUser()->active){
			die(Response::factory(['error' => 1, 'message' => 'Please activate your account.'], 403)->json());
		}
		
		return true;
	}

}