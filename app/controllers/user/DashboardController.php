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

use Core\View;
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\Request;
use Core\Response;
use Helpers\CDN;
use Models\Url;

class Dashboard {

    /**
     * User Dashboard
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){

        $urls = [];
        foreach(Url::recent()->where("userid", Auth::user()->rID())->orderByDesc('date')->limit(15)->findMany() as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $urls[] = $url;
        }

            
        $count = new \stdClass;

        $count->links = DB::url()->where('userid', Auth::user()->rID())->count();
        $count->linksToday = DB::url()->where('userid', Auth::user()->rID())->whereRaw('`date` >= CURDATE()')->count();

        $clicks = DB::url()->selectExpr('SUM(click) as click')->where('userid', Auth::user()->rID())->first();
        $count->clicks = $clicks->click ? $clicks->click : 0;

        $count->clicksToday = DB::stats()->whereRaw('date >= CURDATE()')->where('urluserid', Auth::user()->rID())->count();

        $recentActivity = DB::stats()->where('urluserid', Auth::user()->rID())->limit(10)->orderByDesc('date')->find(); 
        
        foreach($recentActivity as $id => $stats){
            if(!$url = DB::url()->first($stats->urlid)){
                unset($recentActivity[$id]);
            } else {
                if($url->qrid && $qr = DB::qrs()->select('name')->where('urlid', $url->id)->first()){
                    $recentActivity[$id]->qr = $qr->name;    
                }

                if($url->profileid && $profile = DB::profiles()->select('name')->where('urlid', $url->id)->first()){
                    $recentActivity[$id]->profile = $profile->name;    
                }

                $recentActivity[$id]->url = $url;
            }
        }
                
        View::set('title', e('Dashboard'));

        CDN::load('datetimepicker');
        CDN::load('autocomplete');

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        return View::with('user.index', compact('urls', 'count', 'recentActivity'))->extend('layouts.dashboard');
    }
    /**
     * User's Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function links(Request $request){

        $urls = [];

        $title = e('Links');

        $query = Url::recent()->where("userid", Auth::user()->rID());

        if($request->campaign && is_numeric($request->campaign)){
            $query->where('bundle', $request->campaign);
            $title = e('Campaign Links');
        }

        if($request->sort == "popular"){
            $query->orderByDesc('click');
        }
        
        if($request->sort == "less"){
            $query->orderByAsc('click');
        }

        if(!$request->sort || $request->sort == "latest"){
            $query->orderByDesc('date');
        }

        if($request->sort == "oldest"){
            $query->orderByAsc('date');
        }

        if($request->pixel){
            $query->whereLike('pixels', '%'.clean($request->pixel).'%');
        }

        $results = $query->paginate(15, true);

        if($request->page > 1 && !$results) stop(404);

        foreach($results as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $urls[] = $url;
        }

        View::set('title', $title);

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();
        
        return View::with('user.links', compact('urls', 'title'))->extend('layouts.dashboard');
    }
    /**
     * Archived Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function archived(){
        $urls = [];
        foreach(Url::archived()->where("userid", Auth::user()->rID())->orderByDesc('date')->paginate(15, true) as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $urls[] = $url;
        }

        $title = e('Archived Links');

        View::set('title', $title);
        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        return View::with('user.links', compact('urls', 'title'))->extend('layouts.dashboard');        
    }
    /**
     * Expired Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function expired(){
        $urls = [];
        foreach(Url::expired()->where("userid", Auth::user()->rID())->orderByDesc('date')->paginate(15, true) as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $urls[] = $url;
        }

            
        $title = e('Expired Links');

        View::set('title', $title);
        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        return View::with('user.links', compact('urls', 'title'))->extend('layouts.dashboard');   
    }

    /**
     * Generate Clicks Graphs
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function statsClicks(){

        $response = ['label' => e('Clicks')];

        $timestamp = strtotime('now');
        for ($i = 14; $i >= 0; $i--) {
            $d = $i;
            $timestamp = \strtotime("-{$d} days");            
            $response['data'][date('d F', $timestamp)] = 0;
        }
            

        $results = DB::stats()
                    ->selectExpr('COUNT(DATE(date))', 'count')
                    ->selectExpr('DATE(date)', 'date')
                    ->whereRaw('date >= \''.date('Y-m-d', strtotime('-14 days')).'\'')
                    ->where('urluserid',Auth::user()->rID())
                    ->orderByDesc('date')
                    ->groupByExpr('DATE(date)')
                    ->findArray();

        foreach($results as $data){
            $response['data'][Helper::dtime($data['date'], 'd F')] = (int) $data['count'];
        }   
        
        return (new Response($response))->json(); 
    }
    /**
     * Refresh Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function refresh(){
        $urls = [];
        foreach(Url::recent()->where("userid", Auth::user()->rID())->orderByDesc('date')->paginate(15, true) as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $urls[] = $url;
        }

        foreach($urls as $url){
            view('partials.links', compact('url'));
        }
    }
    /**
     * Refresh Archive
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function refreshArchive(){
        $urls = [];
        foreach(DB::url()->where("userid", Auth::user()->rID())->where('archived', 1)->orderByDesc('date')->paginate(15, true) as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $urls[] = $url;
        }

        foreach($urls as $url){
            view('partials.links', compact('url'));
        }
    }

    /**
     * Search 
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param Request $request
     * @return void
     */
    public function search(Request $request){

        $urls =  [];
        
        echo "<script>$('#search button[type=submit]').addClass('d-none'); $('#search button[type=button]').removeClass('d-none');</script>";

        if(strlen($request->q) > 3) {
            
            foreach(DB::url()->whereAnyIs([
                ['url' => "%{$request->q}%"],
                ['custom' => "%{$request->q}%"],
                ['alias' => "%{$request->q}%"],
                ['meta_title' => "%{$request->q}%"],
            ], 'LIKE ')->where('userid', Auth::user()->rid())->limit(10)->findMany() as $url){
                
                if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                    $url->bundlename = $bundle ? $bundle->name : 'na';
                }

                view('partials.links', compact('url'));
            }
       
        } else {
            return Response::factory('<p class="alert alert-danger p-3">'.e('Keyword must be more than 3 characters!').'</p><br>')->send();
        }       
    }
    /**
     * Affiliate
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function affiliate(){
        
        if(!config('affiliate')->enabled) {
            stop(404);
        }

        View::set('title', e('Affiliate Referrals'));

        $user = Auth::user();

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        $sales = DB::affiliates()->where('refid', $user->id)->orderByDesc('referred_on')->find();

        return View::with('user.affiliate', compact('user', 'sales'))->extend('layouts.dashboard');
    }
}