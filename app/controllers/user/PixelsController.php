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
namespace User;

use Core\Request;
use Core\Helper;
use Core\Auth;
use Core\DB;
use Core\View;

class Pixels {

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){

        if(Auth::user()->has('pixels') === false){
            return \Models\Plans::notAllowed();
        }
    }

    /**
     * List Pixels Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){
        
        $pixels = DB::pixels()->where('userid', Auth::user()->rID())->orderByDesc('id')->find();

        $count = DB::pixels()->where('userid', Auth::id())->count();

        $total = Auth::user()->hasLimit('pixels');    
        
        View::set('title', e('Tracking Pixels'));

        return View::with('pixels.index', compact('pixels', 'count', 'total'))->extend('layouts.dashboard');
    }

    /**
     * Add Pixels Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function create(){

        $pixels = DB::pixels()->where('userid', Auth::user()->rID())->orderByDesc('id')->find();

        $count = DB::pixels()->where('userid', Auth::id())->count();

        $total = Auth::user()->hasLimit('pixels');
                
        \Models\Plans::checkLimit($count, $total);

        View::set('title', e('New Pixel'));        

        return View::with('pixels.new', compact('count', 'total'))->extend('layouts.dashboard');
    }

    /**
     * Save Pixels Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){

        \Gem::addMiddleware('DemoProtect');

        $user = Auth::user();

        $pixels = DB::pixels()->where('userid', Auth::user()->rID())->orderByDesc('id')->find();

        $count = DB::pixels()->where('userid', Auth::user()->rID())->count();

        $total = Auth::user()->hasLimit('domain');        

        \Models\Plans::checkLimit($count, $total);

        $key = $request->type;

        if(strlen($key) < 3) {
            return Helper::redirect()->back()->with("danger",e("Please enter valid id."));
        }

        if($request->type == "facebook"){
            if(!is_numeric($request->tag) || (strlen($request->tag) > 20)) return Helper::redirect()->back()->with("danger",e("Facebook pixel ID is not correct. Please double check."));
            $key = "fbpixel";
        }

        if($request->type == "adwords"){
            if(strlen($request->tag) > 40) return Helper::redirect()->back()->with("danger", e("Google Ads pixel ID is not correct. Please double check."));
            $key = "adwordspixel";
        }

        if($request->type == "linkedin"){
            if(strlen($request->tag) > 10) return Helper::redirect()->back()->with("danger", e("LinkedIn ID is not correct. Please double check."));		
            $key = "linkedinpixel";	
        }

        if($request->type == "twitter"){
            if(strlen($request->tag) > 15) return Helper::redirect()->back()->with("danger", e("Twitter ID is not correct. Please double check."));		
            $key = "twitterpixel";	
        }

        if($request->type == "adroll"){
            if(strlen($request->tag) > 50) return Helper::redirect()->back()->with("danger", e("AdRoll ID is not correct. Please double check."));		
            $key = "adrollpixel";	
        }		

        if($request->type == "quora"){
            if(strlen($request->tag) < 30) return Helper::redirect()->back()->with("danger", e("Quora ID is not correct. Please double check."));		
            $key = "quorapixel";	
        }		

        if($request->type == "gtm"){
            if(strlen($request->tag) < 5 || strpos($request->tag, "GTM") === false) return Helper::redirect()->back()->with("danger", e("GTM container ID is not correct. Please double check."));
            $key = "gtmpixel";	
        }

        if($request->type == "ga"){
            if(strlen($request->tag) < 5) return Helper::redirect()->back()->with("danger", e("Google Analytics ID is not correct. Please double check."));
            $key = "gapixel";	
        }


        $pixel = DB::pixels()->create();
        
        $pixel->userid =  Auth::user()->rID();
        $pixel->type = $key;
        $pixel->name = clean($request->pixel);
        $pixel->tag = clean($request->tag);
        $pixel->created_at = Helper::dtime('now');
        $pixel->save();

        return Helper::redirect()->to(route('pixel'))->with('success', e('Pixel has been added successfully'));
    }

    /**
     * Edit Pixels
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        
        if(!$pixel = DB::pixels()->where('userid', Auth::user()->rID())->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Pixel not found. Please try again.'));
        }
            
        View::set('title', e('Edit Pixel'));

        return View::with('pixels.edit', compact('pixel'))->extend('layouts.dashboard');
    }
    
    /**
     * Update Existing Pixels
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        \Gem::addMiddleware('DemoProtect');

        if(!$pixel = DB::pixels()->where('userid', Auth::user()->rID())->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Pixel not found. Please try again.'));
        }                

        $pixel->name = clean($request->pixel);
        $pixel->tag = clean($request->tag);

        $pixel->save();

        return Helper::redirect()->back()->with('success', e('Pixel has been updated successfully.'));
    }

    /**
     * Delete Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(int $id, string $nonce){
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'pixel.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }
        
        if(!$pixel = DB::pixels()->where('userid', Auth::user()->rID())->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Pixel not found. Please try again.'));
        }

        foreach(DB::url()->whereLike('pixels', '%'.$pixel->type.'-'.$pixel->id.'%')->where('userid', Auth::user()->rID())->findMany() as $url){
            $url->pixels = trim(str_replace( $pixel->type.'-'.$pixel->id, '', $url->pixels), ',');
            $url->save();
        }

        $pixel->delete();
            
        return Helper::redirect()->back()->with('success', e('Pixel has been deleted.'));
    }

}