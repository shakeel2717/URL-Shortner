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

namespace API;

use \Core\Helper;
use \Core\Request;
use \Core\Response;
use \Core\DB;
use \Core\Auth;
use \Models\User;

class Links {

    use \Traits\Links;
    /**
     * List All Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function get(Request $request){
        
        $user = Auth::ApiUser();

        $urls = [];

        $query = DB::url()->where('userid', $user->id)->whereNull('qrid')->whereNull('profileid');

        $page = (int) currentpage();

        $limit = 15;

        if( $request->limit && \is_numeric($request->limit) ){                    
            $limit = (int) $request->limit;
        } 

        $total = $query->count();

        if($request->order && $request->order == "click"){

            $query->orderByDesc('click');

        } else{
            $query->orderByDesc('date');
        }

        $results = $query->limit($limit)->offset(($page-1)*$limit)->findMany();
        
        if(($total % $limit)<>0) {
            $max = floor($total/$limit)+1;
        } else {
            $max = floor($total/$limit);
        }  
    
        foreach($results as $url){

            $urls[] = [
                "id" => (int) $url->id,
                "alias" => $url->alias.$url->custom,
                "shorturl" => \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom),
                "longurl" => $url->url,
                "title" => $url->meta_title,
                "description" => $url->meta_description,
                "click" => $url->click,
                "uniqueclick" => $url->uniqueclick,
                "date" => $url->date
            ];
        }

        return Response::factory(['error' => 0, 'data' => ['result' => $total, 'perpage' => $limit, 'currentpage' => $page, 'nextpage' => $max == 0 || $page == $max ? null : $page+1, 'maxpage' => $max, 'urls' => $urls]])->json();


    }
    /**
     * Get a single link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function single(int $id){
        
        $user = Auth::ApiUser();

        $url = DB::url()->where('userid', $user->id)->where('id', $id)->first();

        $result = [
            "id" => (int) $url->id,
            "alias" => $url->alias.$url->custom,
            "shorturl" => \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom),
            "longurl" => $url->url,
            "title" => $url->meta_title,
            "description" => $url->meta_description,
            "location" => json_decode($url->location),
            "device" => json_decode($url->device),
            "expiry" => $url->expiry,
            "date" => $url->date
        ];

        $stats = [
            "clicks" => (int) $url->click,
            "uniqueClicks" => (int) $url->uniqueclick
        ];


        $countries = DB::stats()
                        ->selectExpr('COUNT(id)', 'count')
                        ->selectExpr('country', 'country')
                        ->where('urlid', $url->id)
                        ->groupByExpr('country')
                        ->orderByDesc('count')
                        ->limit(10)
                        ->findArray();
    
        foreach ($countries as $country) {

            if(empty($country['country'])) $country['country'] = 'unknown';

            $stats['topCountries'][ucwords($country['country'])] = (int) $country['count'];
        }
        
        $browsers = DB::stats()
                    ->selectExpr('COUNT(id)', 'count')
                    ->selectExpr('browser', 'browser')
                    ->where('urlid', $url->id)
                    ->groupByExpr('browser')
                    ->orderByDesc('count')
                    ->limit(10)
                    ->findArray();
        
        foreach ($browsers as $browser) {
            $stats['topBrowsers'][ucwords($browser['browser'])] = (int) $browser['count'];
        }

        $oss = DB::stats()
                    ->selectExpr('COUNT(id)', 'count')
                    ->selectExpr('os', 'os')
                    ->where('urlid', $url->id)
                    ->groupByExpr('os')
                    ->orderByDesc('count')
                    ->limit(10)
                    ->findArray();
        
        foreach ($oss as $os) {
            $stats['topOs'][ucwords($os['os'])] = (int) $os['count'];
        }

        $referrers = DB::stats()
                        ->select('domain', 'referer')
                        ->selectExpr('COUNT(domain)', 'count')
                        ->where('urlid', $url->id)
                        ->groupBy('domain')
                        ->orderByDesc('count')
                        ->limit(10)
                        ->findArray();
    
        foreach ($referrers as $referrer) {
            
            if(empty($referrer['domain'])) $referrer['domain'] = e("Direct, email and other");

            if(!preg_match("~facebook.~", $referrer['domain']) && 
                !preg_match("~fb.~", $referrer['domain']) && 
                    !preg_match("~t.co~", $referrer['domain']) && 
                        !preg_match("~twitter.~", $referrer['domain']) && 
                            !preg_match("~instagram.~", $referrer['domain'])){       

                $stats['topReferrers'][$referrer['domain']] = $referrer['count'];
            }
        }  

        $stats['socialCount']['facebook'] = DB::stats()->where("urlid", $url->id)->whereRaw("(domain LIKE '%facebook.%' OR domain LIKE '%fb.%')")->count();
        $stats['socialCount']['twitter'] = DB::stats()->where("urlid", $url->id)->whereRaw("(domain LIKE '%twitter.%' OR domain LIKE '%t.co%')")->count();
        $stats['socialCount']['instagram']  = DB::stats()->where("urlid", $url->id)->whereRaw("(domain LIKE '%instagram.%')")->count();
        $stats['socialCount']['linkedin']  = DB::stats()->where("urlid", $url->id)->whereRaw("(domain LIKE '%linkedin.%')")->count();
    
        return Response::factory(['error' => 0, 'details' => $result, 'data' => $stats])->json();
    }
    /**
     * Shorten a link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function create(Request $request){

        $user = Auth::ApiUser();

        $count = DB::url()->where('userid', $user->rID())->count();

        $total = $user->plan('numurls');

        if($total != 0 && $count > $total){
            return Response::factory(['error' => 1, 'message' => 'You have reached your limit.'])->json();
        }
        
        $data = $request->getJSON();

        $link = new \stdClass;

        if(!isset($data->url)){
            return Response::factory(['error' => 1, 'message' => 'Missing required parameter: url'])->json();
        }

        if(isset($data->url) && !empty($data->url)) $link->url = clean($data->url);

        $link->custom = (isset($data->custom) && !empty($data->custom)) ? clean($data->custom) : null;

		$link->pass = (isset($data->password) && !empty($data->password)) ? clean($data->password) : null;

		$link->domain = (isset($data->domain) && !empty($data->domain)) ? clean($data->domain) : null;

		$link->expiry = (isset($data->expiry) && !empty($data->expiry)) ? clean($data->expiry) : null;

        $link->type = null;
        $link->location = null;
        $link->device = null;
        $link->state = null;
        $link->paramname  = null;
        $link->paramvalue  = null;
        $link->metatitle = null;
        $link->metadescription = null;
        $link->metaimage = null;
        $link->description = null;
        $link->pixels = null;

        if(isset($data->type)){

			if($user->pro || $user->admin) {

				if(in_array($data->type, ["direct", "frame", "splash"])) {
                    $link->type = clean($data->type);
                }

			}else{

				if(!in_array($data->type, ["direct", "frame", "splash"])) {
                    if(!config("pro")) $link->type = clean($data->type);
                } 

			}			

		}

        if(isset($data->geotarget)){
			foreach ($data->geotarget as $country ) {
				$link->location[] = $country->location;
				$link->target[] = $country->link;
			}
		}

		if(isset($data->devicetarget)){
			foreach ($data->devicetarget as $device ) {
				$link->device[] = $device->device;
				$link->dtarget[] = $device->link;
			}
		}
        
        if(isset($data->parameters)){
			foreach ($data->parameters as $param ) {
				$link->paramname[] = $param->name;
				$link->paramvalue[] = $param->value;
			}
		}

        try{
            
            $result = $this->createLink($link, $user);

            return Response::factory(['error' => 0, 'id' => $result['id'], 'shorturl' => $result['shorturl']])->json();

        } catch(\Exception $e){

            return Response::factory(['error' => 1, 'message' => $e->getMessage()])->json();

        }

    }
    /**
     * Update a link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        $user = Auth::ApiUser();
        
        $data = $request->getJSON();

        if(!$url = DB::url()->where('userid', $user->id)->where('id', $id)->first()){
            return Response::factory(['error' => 1, 'message' => 'Link does not exist.'])->json();
        }

        $link = new \stdClass;

        $link->type = null;
        $link->location = null;
        $link->device = null;
        $link->state = null;
        $link->paramname  = null;
        $link->paramvalue  = null;
        $link->metatitle = null;
        $link->metadescription = null;
        $link->metaimage = null;
        $link->description = null;

        $link->url = isset($data->url) && !empty($data->url) ? clean($data->url) : null;

        $link->custom = (isset($data->custom) && !empty($data->custom)) ? clean($data->custom) : null;

		$link->pass = (isset($data->password) && !empty($data->password)) ? clean($data->password) : null;

		$link->domain = (isset($data->domain) && !empty($data->domain)) ? clean($data->domain) : null;

		$link->expiry = (isset($data->expiry) && !empty($data->expiry)) ? clean($data->expiry) : null;

        if(isset($data->type)){

			if($user->pro || $user->admin) {

				if(in_array($data->type, ["direct", "frame", "splash"])) {
                    $link->type = clean($data->type);
                }

			}else{

				if(!in_array($data->type, ["direct", "frame", "splash"])) {
                    if(!config("pro")) $link->type = clean($data->type);
                } 

			}			

		}

        if(isset($data->geotarget)){
			foreach ($data->geotarget as $country ) {
				$link->location[] = $country->location;
				$link->target[] = $country->link;
			}
		}

		if(isset($data->devicetarget)){
			foreach ($data->devicetarget as $device ) {
				$link->device[] = $device->device;
				$link->dtarget[] = $device->link;
			}
		}

        if(isset($data->parameters)){
			foreach ($data->parameters as $param ) {
				$link->paramname[] = $param->name;
				$link->paramvalue[] = $param->value;
			}
		}

        try{
            
            $result = $this->updateLink($link, $url, $user);

            return Response::factory(['error' => 0, 'id' => $result['id'], 'shorturl' => $result['shorturl']])->json();

        } catch(\Exception $e){

            return Response::factory(['error' => 1, 'message' => $e->getMessage()])->json();

        }

    }
    /**
     * Delete Link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function delete(int $id){
        if($this->deleteLink($id, Auth::ApiUser())){
            return Response::factory(['error' => 0, 'message' => 'Link has been successfully deleted.'])->json();
        }
        return Response::factory(['error' => 1, 'message' => 'An error occurred and the link was not deleted.'])->json();
    }    
}