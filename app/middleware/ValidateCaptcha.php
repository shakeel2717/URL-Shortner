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

use Core\Middleware;
use Core\Request;
use Core\Helper;
use Helpers\Captcha;

final class ValidateCaptcha extends Middleware {

	/**
	 * Do not un Captcha for these routes
	 * @var array
	 */
	protected $_exempt = [];

	/**
	 * Validate Captcha
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 */
	public function handle(Request $request) {

		if(self::check($request) === false) return true;

        $captcha = new Captcha;

		try{
			$captcha->validate($request);
			
			return true;

		} catch (\Exception $e){
			
			if($request->isAjax()){
				(new \Core\Response(['error' => true, 'message' => $e->getMessage(), 'token' => csrf_token()]))->json();
				exit;
			}

			Helper::redirect()->back()->with("danger", $e->getMessage());
			exit;
		}
	}
}