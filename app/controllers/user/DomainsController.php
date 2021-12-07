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

class Domains {

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){

        if(Auth::user()->has('domain') === false){
            return \Models\Plans::notAllowed();
        }
    }

    /**
     * List Domains Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){

        $domains = DB::domains()->where('userid', Auth::id())->orderByDesc('id')->findMany();
        $count = DB::domains()->where('userid', Auth::id())->count();
        $total = Auth::user()->hasLimit('domain');
        
        View::set('title', e('Branded Domains'));

        return View::with('domains.index', compact('domains', 'count', 'total'))->extend('layouts.dashboard');
    }

    /**
     * Add Domains Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function create(){

        $count = DB::domains()->where('userid', Auth::id())->count();
        $total = Auth::user()->hasLimit('domain');
        
        \Models\Plans::checkLimit($count, $total);

        View::set('title', e('New Domain'));        

        return View::with('domains.new', compact('count', 'total'))->extend('layouts.dashboard');
    }

    /**
     * Save Domains Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){

        \Gem::addMiddleware('DemoProtect');

        $count = DB::domains()->where('userid', Auth::id())->count();
        $total = Auth::user()->hasLimit('domain');        

        \Models\Plans::checkLimit($count, $total);


        if(!$request->domain || filter_var(idn_to_ascii($request->domain,0,INTL_IDNA_VARIANT_UTS46),FILTER_VALIDATE_URL) == false) return Helper::redirect()->back()->with('danger', e('A valid domain name is required.'));

        $domain =  str_replace(['http://', 'https://'], '', Helper::RequestClean($request->domain));
        
        if(DB::domains()->whereRaw('domain = ? OR domain = ?', ['http://'.$domain, 'https://'.$domain])->first()) return Helper::redirect()->back()->with('danger', e('The domain has been already used.'));
        
        // if(\Helpers\App::checkDNS(config('url'), $request->domain) === false) {
        //     return Helper::redirect()->back()->with('danger', e('The domain name is not pointed to our server. DNS changes could take up to 36 hours.'));
        // }

        if($request->root && !filter_var($request->root, FILTER_VALIDATE_URL)) return Helper::redirect()->back()->with('danger', e('A valid url is required for the root domain.'));
        if($request->root404 && !filter_var($request->root404, FILTER_VALIDATE_URL)) return Helper::redirect()->back()->with('danger', e('A valid url is required for the 404 page.'));

        $domain = DB::domains()->create();
        $domain->domain = Helper::clean($request->domain, 3, true);
        $domain->redirect = Helper::clean($request->root, 3, true);
        $domain->redirect404 = Helper::clean($request->root404, 3, true);
        $domain->status = 1;
        $domain->userid = Auth::id();

        $domain->save();
        return Helper::redirect()->to(route('domain'))->with('success', e('Domain has been added successfully'));
    }

    /**
     * Edit Domains
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        if(!$domain = DB::domains()->where('id', $id)->where('userid', Auth::id())->first()) {
            return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
        }
        
        View::set('title', e('Edit Domain'));

        return View::with('domains.edit', compact('domain'))->extend('layouts.dashboard');
    }
    
    /**
     * Update Existing Domains
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        \Gem::addMiddleware('DemoProtect');

        if(!$domain = DB::domains()->where('id', $id)->where('userid', Auth::id())->first()) return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
                
        $domain->redirect = Helper::clean($request->root, 3, true);
        $domain->redirect404 = Helper::clean($request->root404, 3, true);

        $domain->save();

        return Helper::redirect()->back()->with('success', e('Domain has been updated successfully.'));
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

        if(!Helper::validateNonce($nonce, 'domain.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$domain = DB::domains()->where('id', $id)->where('userid', Auth::id())->first()){
            return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
        }
        
        DB::url()->where("domain", $domain->domain)->update(['domain' => '']);
        $domain->delete();
        return Helper::redirect()->back()->with('success', e('Domain has been deleted.'));
    }

}