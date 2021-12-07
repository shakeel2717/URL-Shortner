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
use Core\Response;
use Core\Helper;

final class Throttle extends Middleware {

    /**
     * Bearer Token
     */
    const BEARER = 'Bearer';    

    /**
     * Throttle API
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function handle(Request $request){
        
        $key = str_replace('Token'.' ', '', $request->server('http_authorization'));
        
        $key = str_replace(self::BEARER.' ', '', $key);
                
        $count = Helper::cacheGet('api'.$key);

        $ratelimiter = appConfig('app.throttle');

        if($count === null){
            $count = 0;
            Helper::cacheSet('api'.$key, 0,  60 * $ratelimiter[1]);
        }
               

        $expiry = Helper::cacheExpiry('api'.$key);
        
        $response = new Response();
        $response->setHeader(['X-RateLimit-Limit', $ratelimiter[0]]);
        $response->setHeader(['X-RateLimit-Remaining', $ratelimiter[0] - ($count+1)]);
        $response->setHeader(['X-RateLimit-Reset', $expiry->getTimestamp()]);
        
        if($count > 0 && $count >= $ratelimiter[0]) {      
            $diff = $expiry->getTimestamp() - (new \DateTime('now'))->getTimestamp();
            $response->setBody(['error' => 429, 'message' => 'Too Many API Requests.', 'Retry-After' => $diff])->json();
            exit;
        }    
        Helper::cacheUpdate('api'.$key, $count + 1);
    }
}