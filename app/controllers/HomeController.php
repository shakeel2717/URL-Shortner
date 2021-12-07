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

use Core\View;
use Core\File;
use Core\Helper;
use Core\Request;
use Core\Response;
use Core\Localization;
use Core\DB;

class Home {

    use \Traits\Links;
    /**
     * Home Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){
            
        request()->ref ? request()->cookie('urid', clean(request()->ref), 60 * 30) : '';
        
        $count = new \stdClass;

        $count->users = \Core\DB::user()->count();
        $count->links = \Core\DB::url()->count();
        $count->clicks = \Core\DB::url()->selectExpr('SUM(click) as click')->first()->click;

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        $themeconfig = config('theme_config');
            
        return View::with('index', compact('count', 'themeconfig'))->extend('layouts.main');
    }        
}