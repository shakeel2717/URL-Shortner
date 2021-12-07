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

use Core\DB;
use Core\View;
use Core\Request;
use Core\Response;
use Core\Helper;
use Core\Auth;
use Models\User;

class Stats {
    
    use Traits\Links;
    /**
     * Simple Redirect
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function simple(Request $request, string $alias){

        if(!$url = $this->getURL($request, $alias)){
			stop(404);
		}

        return Helper::redirect()->to(route('stats', [$url->id]));

    }

    /**
     * Generate Statistics
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param int $id
     * @return void
     */
    public function index(int $id){
        if(!$url = DB::url()->where('id', $id)->first()){
			stop(404);
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
			if(Auth::user()->rID() != $url->userid) return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		$top = new \stdClass;
		// Top Country
		$top->country = DB::stats()
						->select('country', 'country')
						->selectExpr('COUNT(country)', 'count')
						->where('urlid', $url->id)
						->groupBy('country')
						->orderByDesc('count')
						->first();
		// Top Referer
		$top->referer = DB::stats()
						->select('domain', 'domain')
						->selectExpr('COUNT(domain)', 'count')
						->where('urlid', $url->id)
						->groupBy('domain')
						->orderByDesc('count')
						->first();

        $recentActivity = DB::stats()->where('urlid', $url->id)->limit(15)->orderByDesc('date')->find(); 

		if($top->referer && !$top->referer->domain) $top->referer->domain = e('Direct');

        if($url->qrid && $qr = DB::qrs()->where('id', $url->qrid)->first()){
            
            View::set("title",e("Stats for")." ".$qr->name);
            $url->qr = $qr;

        }elseif($url->profileid && $profile = DB::profiles()->where('id', $url->profileid)->first()){   
         
            View::set("title",e("Stats for")." ".$profile->name);
            $url->profile = $profile;
            
        }else{
            
            View::set("title",e("Stats for")." ".$url->meta_title);
            View::set("description", e("Advanced statistics page for the short URL")." ". \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain));
            View::set("image", \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain).'/i');
        }

		View::push(assets('Chart.min.js'), "script")->toHeader();
		View::push(assets('charts.min.js'), "script")->tofooter();

		\Helpers\CDN::load("daterangepicker");

		View::push("<script>$(document).ready(function(){ 		
            $('input[name=customreport]').daterangepicker({
                minDate: moment('{$url->date}').format('MM/DD/YY'),
                maxDate: moment(),
                startDate: moment().subtract(14, 'days'),
                endDate: moment(),
                autoUpdateInput: true,
                ranges: {
                    '".e("Last 7 Days")."': [moment().subtract(6, 'days'), moment()],
                    '".e("Last 30 Days")."': [moment().subtract(29, 'days'), moment()],
                    '".e("This Month")."': [moment().startOf('month'), moment().endOf('month')],
                    '".e("Last Month")."': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '".e("Last 3 Months")."': [moment().subtract(2, 'month').startOf('month'), moment()]
                }
			});			
		});</script>", "custom")->tofooter();

		return View::with('stats.index', compact('url', 'top', 'recentActivity'))->extend('layouts.main');
    }
   /**
    * Get Chart Data
    *
    * @author GemPixel <https://gempixel.com> 
    * @version 6.0
    * @param integer $id
    * @return void
    */
    public function dataClicks(Request $request, int $id){

        if(!$url = DB::url()->where('id', $id)->first()){
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
            if(Auth::user()->rID() != $url->userid) return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

        $response = ['label' => e('Clicks')];

        if(!$request->from || !$request->to){
            $from = date("Y-m-d", strtotime("-14 days"));
            $to = date("Y-m-d", strtotime("+1 day"));
        } else {
            $from = date("Y-m-d H:i:s", strtotime($request->from.' 00:00:00'));
            $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));					
        }
    

        $start = new \DateTime($from);
        $end = new \DateTime($to);

        $diff = $end->diff($start);

        if($diff->y >= 1 || $diff->m > 3){
            $interval = \DateInterval::createFromDateString('1 month');    
        } else {
            $interval = \DateInterval::createFromDateString('1 day');
        }

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            if($diff->y >= 1 || $diff->m > 3){
                $response['data'][$dt->format("F Y")] = 0;		
            } else {
                $response['data'][$dt->format("d F")] = 0;
            }
        }  
        if($diff->y >= 1 || $diff->m > 3){
            $results = DB::stats()
                        ->selectExpr('COUNT(MONTH(date))', 'count')
                        ->selectExpr('DATE(date)', 'date')
                        ->where('urlid', $id)
                        ->whereRaw("(date BETWEEN '{$from} 00:00:00' AND '{$to} 23:59:59')")
                        ->groupByExpr('YEAR(date)')
                        ->groupByExpr('MONTH(date)')
                        ->findArray();

            foreach($results as $data){
                $response['data'][Helper::dtime($data['date'], 'F Y')] = (int) $data['count'];
            }   
        }  else {
            $results = DB::stats()
                        ->selectExpr('COUNT(DATE(date))', 'count')
                        ->selectExpr('DATE(date)', 'date')
                        ->where('urlid', $id)
                        ->whereRaw("(date BETWEEN '{$from} 00:00:00' AND '{$to} 23:59:59')")
                        ->groupByExpr('DATE(date)')
                        ->findArray();
            
            foreach($results as $data){
                $response['data'][Helper::dtime($data['date'], 'd F')] = (int) $data['count'];
            }   
        }
        
        return (new Response($response))->json(); 
    }
    /**
     * Generate Country Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function countries(int $id){
        if(!$url = DB::url()->where('id', $id)->first()){
			stop(404);
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
			if(Auth::user()->rID() != $url->userid) return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		$top = new \stdClass;
		// Top Country
		$top->country = DB::stats()
						->select('country', 'country')
						->selectExpr('COUNT(country)', 'count')
						->where('urlid', $url->id)
						->groupBy('country')
						->orderByDesc('count')
						->first();
		// Top Referer
		$top->referer = DB::stats()
						->select('domain', 'domain')
						->selectExpr('COUNT(domain)', 'count')
						->where('urlid', $url->id)
						->groupBy('domain')
						->orderByDesc('count')
						->first();

		if($top->referer && !$top->referer->domain) $top->referer->domain = e('Direct');

        if($url->qrid && $qr = DB::qrs()->where('id', $url->qrid)->first()){    
            View::set("title",e("Country Stats for")." ".$qr->name);
            $url->qr = $qr;
        
        }elseif($url->profileid && $profile = DB::profiles()->where('id', $url->profileid)->first()){   
            View::set("title",e("Stats for")." ".$profile->name);
            $url->profile = $profile;
        }else{            
            View::set("title",e("Country Stats for")." ".$url->meta_title);
        }
		
		View::set("description", e("Country statistics page for the short URL")." ". \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain));
		View::set("image", \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain).'/i');

        View::push(assets('frontend/libs/jsvectormap/dist/js/jsvectormap.min.js'), "script")->tofooter();
        View::push(assets('frontend/libs/jsvectormap/dist/maps/world.js'), "script")->tofooter();
        View::push(assets('frontend/libs/jsvectormap/dist/css/jsvectormap.min.css'), "css")->toHeader();
        View::push(assets('charts.min.js'), "script")->tofooter();
        \Helpers\CDN::load("daterangepicker");

		View::push("<script>$(document).ready(function(){ 		
            $('input[name=customreport]').daterangepicker({
                minDate: moment('{$url->date}').format('MM/DD/YY'),
                maxDate: moment(),
                startDate: moment().subtract(14, 'days'),
                endDate: moment(),
                autoUpdateInput: true,
                ranges: {
                    '".e("Last 7 Days")."': [moment().subtract(6, 'days'), moment()],
                    '".e("Last 30 Days")."': [moment().subtract(29, 'days'), moment()],
                    '".e("This Month")."': [moment().startOf('month'), moment().endOf('month')],
                    '".e("Last Month")."': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '".e("Last 3 Months")."': [moment().subtract(2, 'month').startOf('month'), moment()]
                }
			});			
		});</script>", "custom")->tofooter();

        return View::with('stats.countries', compact('url', 'top'))->extend('layouts.main');
    }

     /**
     * Get Clicks Map
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function dataCountries(Request $request, int $id){
        
        if(!$url = DB::url()->where('id', $id)->first()){
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
            if(Auth::user()->rID() != $url->userid) return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

        if(!$request->from || !$request->to){
            $from = date("Y-m-d", strtotime("-14 days"));
            $to = date("Y-m-d", strtotime("+1 day"));
        } else {
            $from = date("Y-m-d H:i:s", strtotime($request->from.' 00:00:00'));
            $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));					
        }
    

        $start = new \DateTime($from);
        $end = new \DateTime($to);

        $diff = $end->diff($start);

        if($diff->y >= 1 || $diff->m > 3){
            $interval = \DateInterval::createFromDateString('1 month');    
        } else {
            $interval = \DateInterval::createFromDateString('1 day');
        }

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($start, $interval, $end);


        $countries = DB::stats()
                        ->selectExpr('COUNT(id)', 'count')
                        ->selectExpr('country', 'country')
                        ->where('urlid', $id)
                        ->whereRaw("(date BETWEEN '{$from} 00:00:00' AND '{$to} 23:59:59')")
                        ->groupByExpr('country')
                        ->orderByDesc('count')
                        ->findArray();

        $i = 0;
        $topCountries = [];
        $country  = [];

        foreach ($countries as $list) {
          
            $name = $list["country"] ? Helper::Country(ucwords($list["country"]), false, true) : 'unknown';

            $country[$name] = $list["count"];

            if($i <= 10){
                if(empty($list["country"])) $list["country"] = e('Unknown');

                $topCountries[$name] = ['name' => ucwords($list["country"]), 'count' => $list["count"]];
            }
            $i++;
        }

        return (new Response(['list' => $country, 'top' => $topCountries]))->json();  
    }
    /**
     * Get City Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function dataCities(Request $request, $id){

        if(!$url = DB::url()->where('id', $id)->first()){
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
            if(Auth::user()->rID() != $url->userid) return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

        if(!$request->country){
            return (new Response(['error' => true, 'data' => null], 500))->json();  
        }
        
        $country = Helper::Country(strtoupper($request->country));

        if($country == false){
            return (new Response(['error' => true, 'data' => null], 500))->json();  
        }

        $cities = DB::stats()
                    ->selectExpr('COUNT(id)', 'count')
                    ->selectExpr('city', 'city')
                    ->where('urlid', $id)
                    ->where('country', strtolower($country))
                    ->groupByExpr('city')
                    ->orderByDesc('count')
                    ->findArray();
        $response = '';

        if(!$cities) return (new Response(['error' => true, 'data' => null], 404))->json();  

        foreach($cities as $city){
            $response .= '<div class="d-flex align-items-start">                               
                            <div>
                                <img src="'.\Helpers\App::flag(strtolower($country)).'" width="32" class="rounded mr-2" alt="'.$country.'">
                                <small class="ml-2">'.($city['city'] ? ucfirst($city['city']).',': e('Somewhere from')).' '.$country.'</small>
                                
                            </div>
                            <div class="ml-auto">
                                <span class="badge badge-primary">'.$city['count'].' '.e('Clicks').'</span>
                            </div>
                        </div>          
                        <hr class="my-2">';
        }

        return (new Response($response))->send();  
    }
    /**
     * Get Platform Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function platforms(int $id){
        if(!$url = DB::url()->where('id', $id)->first()){
			stop(404);
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
			if(Auth::user()->rID() != $url->userid) return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		$top = new \stdClass;
		// Top Country
		$top->country = DB::stats()
						->select('country', 'country')
						->selectExpr('COUNT(country)', 'count')
						->where('urlid', $url->id)
						->groupBy('country')
						->orderByDesc('count')
						->first();
		// Top Referer
		$top->referer = DB::stats()
						->select('domain', 'domain')
						->selectExpr('COUNT(domain)', 'count')
						->where('urlid', $url->id)
						->groupBy('domain')
						->orderByDesc('count')
						->first();

		if($top->referer && !$top->referer->domain) $top->referer->domain = e('Direct');

        if($url->qrid && $qr = DB::qrs()->where('id', $url->qrid)->first()){    
            View::set("title",e("Platform Stats for")." ".$qr->name);
            $url->qr = $qr;
        
        }elseif($url->profileid && $profile = DB::profiles()->where('id', $url->profileid)->first()){   
            View::set("title",e("Stats for")." ".$profile->name);
            $url->profile = $profile;
        }else{ 
    		View::set("title",e("Platform Stats for")." ".$url->meta_title);
        }
		View::set("description", e("Platform statistics page for the short URL")." ". \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain));
		View::set("image", \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain).'/i');	        

		View::push(assets('Chart.min.js'), "script")->toHeader();
		View::push(assets('charts.min.js'), "script")->tofooter();

        \Helpers\CDN::load("daterangepicker");

		View::push("<script>$(document).ready(function(){ 		
            $('input[name=customreport]').daterangepicker({
                minDate: moment('{$url->date}').format('MM/DD/YY'),
                maxDate: moment(),
                startDate: moment().subtract(14, 'days'),
                endDate: moment(),
                autoUpdateInput: true,
                ranges: {
                    '".e("Last 7 Days")."': [moment().subtract(6, 'days'), moment()],
                    '".e("Last 30 Days")."': [moment().subtract(29, 'days'), moment()],
                    '".e("This Month")."': [moment().startOf('month'), moment().endOf('month')],
                    '".e("Last Month")."': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '".e("Last 3 Months")."': [moment().subtract(2, 'month').startOf('month'), moment()]
                }
			});			
		});</script>", "custom")->tofooter();

		return View::with('stats.platforms', compact('url', 'top'))->extend('layouts.main');
    }
    /**
     * Get Platform Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function dataPlatforms(Request $request, int $id){
        if(!$url = DB::url()->where('id', $id)->first()){
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
            if(Auth::user()->rID() != $url->userid) return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

        if(!$request->from || !$request->to){
            $from = date("Y-m-d", strtotime("-14 days"));
            $to = date("Y-m-d", strtotime("+1 day"));
        } else {
            $from = date("Y-m-d H:i:s", strtotime($request->from.' 00:00:00'));
            $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));					
        }
    

        $start = new \DateTime($from);
        $end = new \DateTime($to);

        $diff = $end->diff($start);

        if($diff->y >= 1 || $diff->m > 3){
            $interval = \DateInterval::createFromDateString('1 month');    
        } else {
            $interval = \DateInterval::createFromDateString('1 day');
        }

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($start, $interval, $end);

        $platform = DB::stats()
                    ->selectExpr('COUNT(id)', 'count')
                    ->selectExpr('os', 'os')
                    ->where('urlid', $id)
                    ->whereRaw("(date BETWEEN '{$from} 00:00:00' AND '{$to} 23:59:59')")
                    ->groupByExpr('os')
                    ->orderByDesc('count')
                    ->findArray();

        $response = [];
        $top = [];
        $i =0;

        foreach($platform as $os){
            $response[$os['os']] = $os['count'];

            if($i <= 10){
                if(!empty($os['os'])) $top[$os['os']] = $os["count"];
            }
            $i++;
        }
        return (new Response(['chart' => $response, 'top' => $top]))->json();  
    }
    /**
     * Get Browser Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function browsers(int $id){
        if(!$url = DB::url()->where('id', $id)->first()){
			stop(404);
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
			if(Auth::user()->rID() != $url->userid) return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		$top = new \stdClass;
		// Top Country
		$top->country = DB::stats()
						->select('country', 'country')
						->selectExpr('COUNT(country)', 'count')
						->where('urlid', $url->id)
						->groupBy('country')
						->orderByDesc('count')
						->first();
		// Top Referer
		$top->referer = DB::stats()
						->select('domain', 'domain')
						->selectExpr('COUNT(domain)', 'count')
						->where('urlid', $url->id)
						->groupBy('domain')
						->orderByDesc('count')
						->first();

		if($top->referer && !$top->referer->domain) $top->referer->domain = e('Direct');

        if($url->qrid && $qr = DB::qrs()->where('id', $url->qrid)->first()){    
            View::set("title",e("Browser Stats for")." ".$qr->name);
            $url->qr = $qr;
        
        }elseif($url->profileid && $profile = DB::profiles()->where('id', $url->profileid)->first()){   
            View::set("title",e("Stats for")." ".$profile->name);
            $url->profile = $profile;
        }else{ 
		    View::set("title",e("Browser Stats for")." ".$url->meta_title);
        }
		View::set("description", e("Browser statistics page for the short URL")." ". \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain));
		View::set("image", \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain).'/i');
		
        \Helpers\CDN::load("daterangepicker");

		View::push("<script>$(document).ready(function(){ 		
            $('input[name=customreport]').daterangepicker({
                minDate: moment('{$url->date}').format('MM/DD/YY'),
                maxDate: moment(),
                startDate: moment().subtract(14, 'days'),
                endDate: moment(),
                autoUpdateInput: true,
                ranges: {
                    '".e("Last 7 Days")."': [moment().subtract(6, 'days'), moment()],
                    '".e("Last 30 Days")."': [moment().subtract(29, 'days'), moment()],
                    '".e("This Month")."': [moment().startOf('month'), moment().endOf('month')],
                    '".e("Last Month")."': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '".e("Last 3 Months")."': [moment().subtract(2, 'month').startOf('month'), moment()]
                }
			});			
		});</script>", "custom")->tofooter();

		View::push(assets('Chart.min.js'), "script")->toHeader();
		View::push(assets('charts.min.js'), "script")->tofooter();

		return View::with('stats.browsers', compact('url', 'top'))->extend('layouts.main');
    }
    /**
     * Get Browsers Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function dataBrowsers(Request $request, int $id){
        if(!$url = DB::url()->where('id', $id)->first()){
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
            if(Auth::user()->rID() != $url->userid) return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

        if(!$request->from || !$request->to){
            $from = date("Y-m-d", strtotime("-14 days"));
            $to = date("Y-m-d", strtotime("+1 day"));
        } else {
            $from = date("Y-m-d H:i:s", strtotime($request->from.' 00:00:00'));
            $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));					
        }
    

        $start = new \DateTime($from);
        $end = new \DateTime($to);

        $diff = $end->diff($start);

        if($diff->y >= 1 || $diff->m > 3){
            $interval = \DateInterval::createFromDateString('1 month');    
        } else {
            $interval = \DateInterval::createFromDateString('1 day');
        }
        

        $browsers = DB::stats()
                    ->selectExpr('COUNT(id)', 'count')
                    ->selectExpr('browser', 'browser')
                    ->where('urlid', $id)
                    ->whereRaw("(date BETWEEN '{$from} 00:00:00' AND '{$to} 23:59:59')")
                    ->groupByExpr('browser')
                    ->orderByDesc('count')
                    ->findArray();

        $response = [];
        $top = [];
        $i =0;

        foreach($browsers as $browser){
            $response[$browser['browser']] = $browser['count'];

            if($i <= 10){
                if(!empty($browser['browser'])) $top[$browser['browser']] = $browser["count"];
            }
            $i++;
        }
        return (new Response(['chart' => $response, 'top' => $top]))->json();  
    }
    /**
     * Get Language Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function languages(int $id){
        if(!$url = DB::url()->where('id', $id)->first()){
			stop(404);
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
			if(Auth::user()->rID() != $url->userid) return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		$top = new \stdClass;
		// Top Country
		$top->country = DB::stats()
						->select('country', 'country')
						->selectExpr('COUNT(country)', 'count')
						->where('urlid', $url->id)
						->groupBy('country')
						->orderByDesc('count')
						->first();
		// Top Referer
		$top->referer = DB::stats()
						->select('domain', 'domain')
						->selectExpr('COUNT(domain)', 'count')
						->where('urlid', $url->id)
						->groupBy('domain')
						->orderByDesc('count')
						->first();

		if($top->referer && !$top->referer->domain) $top->referer->domain = e('Direct');

        if($url->qrid && $qr = DB::qrs()->where('id', $url->qrid)->first()){    
            View::set("title",e("Language Stats for")." ".$qr->name);
            $url->qr = $qr;
        
        }elseif($url->profileid && $profile = DB::profiles()->where('id', $url->profileid)->first()){   
            View::set("title",e("Stats for")." ".$profile->name);
            $url->profile = $profile;
        }else{
		    View::set("title",e("Language Stats for")." ".$url->meta_title);
        }
		View::set("description", e("Language statistics page for the short URL")." ". \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain));
		View::set("image", \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain).'/i');
		
        \Helpers\CDN::load("daterangepicker");

		View::push("<script>$(document).ready(function(){ 		
            $('input[name=customreport]').daterangepicker({
                minDate: moment('{$url->date}').format('MM/DD/YY'),
                maxDate: moment(),
                startDate: moment().subtract(14, 'days'),
                endDate: moment(),
                autoUpdateInput: true,
                ranges: {
                    '".e("Last 7 Days")."': [moment().subtract(6, 'days'), moment()],
                    '".e("Last 30 Days")."': [moment().subtract(29, 'days'), moment()],
                    '".e("This Month")."': [moment().startOf('month'), moment().endOf('month')],
                    '".e("Last Month")."': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '".e("Last 3 Months")."': [moment().subtract(2, 'month').startOf('month'), moment()]
                }
			});			
		});</script>", "custom")->tofooter();

		View::push(assets('Chart.min.js'), "script")->toHeader();
		View::push(assets('charts.min.js'), "script")->tofooter();

		return View::with('stats.languages', compact('url', 'top'))->extend('layouts.main');
    }
    /**
     * Get Language Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function dataLanguages(Request $request, int $id){
        if(!$url = DB::url()->where('id', $id)->first()){
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
            if(Auth::user()->rID() != $url->userid) return (new Response(['error' => true, 'data' => null], 500))->json();  
		}

        if(!$request->from || !$request->to){
            $from = date("Y-m-d", strtotime("-14 days"));
            $to = date("Y-m-d", strtotime("+1 day"));
        } else {
            $from = date("Y-m-d H:i:s", strtotime($request->from.' 00:00:00'));
            $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));					
        }
    

        $start = new \DateTime($from);
        $end = new \DateTime($to);

        $diff = $end->diff($start);

        if($diff->y >= 1 || $diff->m > 3){
            $interval = \DateInterval::createFromDateString('1 month');    
        } else {
            $interval = \DateInterval::createFromDateString('1 day');
        }

        $languages = DB::stats()
                    ->selectExpr('COUNT(id)', 'count')
                    ->selectExpr('language', 'language')
                    ->where('urlid', $id)
                    ->whereRaw("(date BETWEEN '{$from} 00:00:00' AND '{$to} 23:59:59')")
                    ->groupByExpr('language')
                    ->orderByDesc('count')
                    ->findArray();

        $response = [];
        $top = [];
        $i =0;

        foreach($languages as $language){
            if(empty($language['language'])) $language['language'] = e('Unknown');
            $response[$language['language']] = $language['count'];

            if($i <= 10){
                if(!empty($language['language'])) $top[$language['language']] = $language["count"];
            }
            $i++;
        }
        return (new Response(['chart' => $response, 'top' => $top]))->json();  
    }
    /**
     * Referrers Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function referrers(int $id){
        if(!$url = DB::url()->where('id', $id)->first()){
			stop(404);
		}

		// Check if user is anon and url is public		
		if(!Auth::logged() && (!empty($url->pass) || !$url->public)) {		
			return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		// Check if user is logged and is admin or owner
		if(Auth::logged() && !$url->public && !Auth::user()->admin){
			if(Auth::user()->rID() != $url->userid) return Helper::redirect()->to(route('login'))->with("danger", e("This link is private and only the creator can access the stats. If you are the creator, please login to access it."));
		}

		$top = new \stdClass;
		// Top Country
		$top->country = DB::stats()
						->select('country', 'country')
						->selectExpr('COUNT(country)', 'count')
						->where('urlid', $url->id)
						->groupBy('country')
						->orderByDesc('count')
						->first();
		// Top Referer
		$top->referer = DB::stats()
						->select('domain', 'domain')
						->selectExpr('COUNT(domain)', 'count')
						->where('urlid', $url->id)
						->groupBy('domain')
						->orderByDesc('count')
						->first();

		if($top->referer && !$top->referer->domain) $top->referer->domain = e('Direct');

        $topReferrer = DB::stats()
                            ->select('domain', 'domain')
                            ->selectExpr('COUNT(domain)', 'count')
                            ->where('urlid', $url->id)
                            ->groupBy('domain')
                            ->orderByDesc('count')
                            ->limit(10)
                            ->findArray();
        
        $social = [];
        $social[] = DB::stats()->where("urlid", $url->id)->whereRaw("(domain LIKE '%facebook.%' OR domain LIKE '%fb.%')")->count();
        $social[] = DB::stats()->where("urlid", $url->id)->whereRaw("(domain LIKE '%twitter.%' OR domain LIKE '%t.co%')")->count();
        $social[] = DB::stats()->where("urlid", $url->id)->whereRaw("(domain LIKE '%instagram.%')")->count();
        $social[] = DB::stats()->where("urlid", $url->id)->whereRaw("(domain LIKE '%linkedin.%')")->count();
        
        if($url->qrid && $qr = DB::qrs()->where('id', $url->qrid)->first()){    
            View::set("title",e("Referrers Stats for")." ".$qr->name);
            $url->qr = $qr;
        
        }elseif($url->profileid && $profile = DB::profiles()->where('id', $url->profileid)->first()){   
            View::set("title",e("Stats for")." ".$profile->name);
            $url->profile = $profile;
        }else{
		    View::set("title",e("Referrers Stats for")." ".$url->meta_title);
        }

		View::set("description", e("Country statistics page for the short URL")." ". \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain));
		View::set("image", \Helpers\App::shortRoute($url->domain, $url->alias.$url->domain).'/i');
        View::push(assets('Chart.min.js'), "script")->toHeader();
        View::push(assets('charts.min.js'), "script")->tofooter();

        View::push("<script>new Chart($('canvas'), {type: 'pie',data: {labels: ['Facebook', 'Twitter', 'Instagram', 'Linkedin'],datasets: [{data: ".json_encode($social).",borderWidth: 5,backgroundColor: ['#3b5998','#1DA1F2', '#fbad50', '#0077b5']}]},options: {responsive: !window.MSInputMethodContext,maintainAspectRatio: false,plugins:{legend: {position: 'bottom',display: true}},cutoutPercentage: 75}})</script>", 'custom')->tofooter();

        return View::with('stats.referrers', compact('url', 'top', 'topReferrer'))->extend('layouts.main');
    }
}