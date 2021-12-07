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

use Core\DB;
use Core\View;

final class CDN {
    /**
     * JS
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public static $list = [];
    /**
     * Load CDN Assets
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $name
     * @return void
     */
    public static function load(string $name){
        
        if(empty(self::$list)) self::$list = appConfig('cdn');

        if(isset(self::$list[$name])){          
            if(isset(self::$list[$name]['js'])){
                foreach(self::$list[$name]['js'] as $js){
                    $js = str_replace('[version]', self::$list[$name]['version'], $js);
                    View::push($js, 'js')->toFooter();
                }
            }
            if(isset(self::$list[$name]['css'])){
                foreach(self::$list[$name]['css'] as $css){
                    $css = str_replace('[version]', self::$list[$name]['version'], $css);
                    View::push($css, 'css')->toHeader();
                }
            }
        }
    }
}