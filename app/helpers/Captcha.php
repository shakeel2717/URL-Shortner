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

use Core\Http;

final class Captcha {
    /**
     * Captcha System
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $system = [
        1 => [
            'display' => [Captcha::class, 'reCaptchaV3Display'],
            'validate' => [Captcha::class, 'reCaptchaValidate']
        ],       
        3 => [
            'display' => [Captcha::class, 'reCaptchaV2Display'],
            'validate' => [Captcha::class, 'reCaptchaValidate']
        ],
        4 => [
            'display' => [Captcha::class, 'hCaptchaDisplay'],
            'validate' => [Captcha::class, 'hCaptchaValidate']
        ]
    ];  
    /**
     * Choose system
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $captcha = null;
    /**
     * Error
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $error = false;
    /**
     * Select system
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){

        if(isset($this->system[config('captcha')])) {
            $this->captcha = $this->system[config('captcha')];
        } else {
            $this->error = true;
        }
    }
    /**
     * Display Captcha
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function display(){
        
        if(config('captcha') == 0) return false;
        
        $captcha = new self();

        if($captcha->error) return false;

        return \call_user_func($captcha->captcha['display']);
    }
    /**
     * Validate captcha
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function validate($request){
        
        if(config('captcha') == 0 || $this->error) return true;

        return \call_user_func($this->captcha['validate'], $request);

    }

    /**
     * Validate Recaptcha
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    public function reCaptchaValidate($request){

        if(empty($request->get("g-recaptcha-response"))) throw new \Exception(e("The captcha did not validate. Please try again."));
            
        $validation = Http::url('https://www.google.com/recaptcha/api/siteverify')->body([
            'secret' => config('captcha_private'),
            'remoteip' => $request->server('remote_addr'),
            'response' => $request->get('g-recaptcha-response')
        ])->post();

        if(!$validation->bodyObject() || $validation->bodyObject()->success === false) {
            throw new \Exception(e("The captcha did not validate. Please try again.")."<script>recaptcha()</script>");
        }
        
        return true;
    }
    /**
     * Display V2 Captcha
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function reCaptchaV2Display(){

        return '<div class="g-recaptcha mb-3" data-sitekey="'.config('captcha_public').'"></div>
                <script src="https://www.google.com/recaptcha/api.js?hl='.\Core\Localization::locale().'" async defer></script>
                <script>
                    var recaptcha = () => {
                        return grecaptcha.reset();
                    }
                </script>';
    }
    /**
     * Display V3 Captcha
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function reCaptchaV3Display(){

        $rand = \Core\Helper::rand(15);
        $key = config('captcha_public');

	    return "<div data-id=\"{$rand}\" class=\"mb-3\"></div><script src=\"https://www.google.com/recaptcha/api.js?hl=".\Core\Localization::locale()."&render={$key}\"></script>
                <script>
                    var recaptcha = () => {
                        grecaptcha.execute('{$key}', {action: 'login'}).then(function(token) {
                            $('[data-id={$rand}]').html('<input type=\"hidden\" name=\"g-recaptcha-response\" value=\"'+token+'\" />')
                        });
                    }
					grecaptcha.ready('recaptcha');
                </script>";
    }
    /**
     * Display hCaptcha
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function hCaptchaDisplay(){
        return '<div class="h-captcha" data-sitekey="'.config('captcha_public').'"></div>
                <script src="https://www.hCaptcha.com/1/api.js?hl='.\Core\Localization::locale().'" async defer></script>
                <script>
                  var recaptcha = () => {
                    return hcaptcha.reset();
                  }
                </script>';
    }
    /**
     * Validate hCaptcha
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    public function hCaptchaValidate($request){
        
        if(empty($request->get("g-recaptcha-response"))) throw new \Exception(e("The captcha did not validate. Please try again."));
            
        $validation = Http::url('https://hcaptcha.com/siteverify')->body([
            'secret' => config('captcha_private'),
            'response' => $request->get('g-recaptcha-response')
        ])->post();

        if(!$validation->bodyObject() || $validation->bodyObject()->success === false) {
            throw new \Exception(e("The captcha did not validate. Please try again.")."<script>recaptcha()</script>");
        }       
        
        return true;
    }    
}