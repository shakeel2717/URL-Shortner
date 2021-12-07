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

use \Core\Helper;
use \Core\View;
use \Core\DB;
use \Core\Auth;
use \Core\Request;

class Export {     
    /**
     * Check if user can export
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){
        if(\Models\User::where('id', Auth::user()->rID())->first()->has('export') === false){
			return \Models\Plans::notAllowed();
		}
    }
    /**
     * Export Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function links(Request $request){        

        $links = DB::url()
                    ->where('userid', Auth::user()->id)
                    ->orderByDesc('date')
                    ->findArray();

        return \Core\File::contentDownload('MyLinks-'.date('d-m-Y').'.csv', function() use ($links) {

			echo "Short URL, Long URL, Date, Clicks, Unique Clicks\n";
            foreach($links as $url){
                echo ($url['domain'] ? $url['domain'] : config('url'))."/".$url['alias'].$url['custom'].",\"{$url['url']}\",{$url['date']},{$url['click']},{$url['uniqueclick']}\n";
            }
		});
    }
    /**
     * Export Single Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function single(int $id){

        if(!$url = DB::url()->select('alias')->select('custom')->select('domain')->where('id', $id)->first()) {
            return Helper::redirect()->back()->with('danger', e('Link does not exist.'));
        }

        $stats = DB::stats()->where("urluserid", Auth::user()->rId())->where('urlid', $id)->orderByDesc('date')->findArray();

        $content = "Short URL, Date, City, Country, Browser, Platform, Language, Referer\n";
        
        foreach($stats as $data){

            $content .= ($url->domain ? $url->domain : config('url'))."/".$url->alias.$url->custom.",{$data['date']},{$data['city']},{$data['country']},{$data['browser']},{$data['os']},{$data['language']},{$data['referer']}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=ReportLink_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }

    /**
     * Export Campaign Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function stats(Request $request){
        
        if(!$request->customreport) return Helper::redirect()->back()->with('danger', e('Please specify a range.')); 

        $range = explode(' - ', $request->customreport);       

        $stats = DB::stats()->where("urluserid", Auth::user()->rId())->orderByDesc('date')->findArray();

        $content = "Short URL, Date, City, Country, Browser, Platform, Language, Referer\n";
        
        foreach($stats as $data){

            if(!$url = DB::url()->select('alias')->select('custom')->select('domain')->where('id', $data['urlid'])->first()) continue;

            $content .= ($url->domain ? $url->domain : config('url'))."/".$url->alias.$url->custom.",{$data['date']},{$data['city']},{$data['country']},{$data['browser']},{$data['os']},{$data['language']},{$data['referer']}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=ReportAll_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }  
    /**
     * Export Campaign Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function campaign(Request $request, int $id){
        
        if(!\Core\Auth::user()->has('export')){
            return \Models\Plans::notAllowed();
        }

        if(!$request->customreport) return Helper::redirect()->back()->with('danger', e('Please specify a range.')); 

        $range = explode(' - ', $request->customreport);

        if(!$bundle = DB::bundle()->where('id', $id)->where('userid', Auth::user()->rId())->first()){
            return Response::factory('', 404)->json();
        }

        $urls = DB::url()->select('id', 'urlid')->where('bundle', $bundle->id)->findArray();

        $stats = DB::stats()->where("urluserid", Auth::user()->rId())->whereAnyIs($urls)->orderByDesc('date')->findArray();

        $content = "Short URL, Date, City, Country, Browser, Platform, Language, Referer\n";
        
        foreach($stats as $data){
            if(!$url = DB::url()->select('alias')->select('custom')->select('domain')->where('id', $data['urlid'])->first()) continue;

            $content .= ($url->domain ? $url->domain : config('url'))."/".$url->alias.$url->custom.",{$data['date']},{$data['city']},{$data['country']},{$data['browser']},{$data['os']},{$data['language']},{$data['referer']}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=ReportCampaign_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }
}