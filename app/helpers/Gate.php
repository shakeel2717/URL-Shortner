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

use Core\View;
use Core\Response;
use Core\Helper;
use Helpers\CDN;

class Gate {

    use \Traits\Overlays;

    /**
     * Inactive Link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function inactive(){
        
        View::set('title', e('Inactive Link'));

        View::set("description","This link has been marked as inactive and cannot currently be used.");

        return new Response(View::dryRender('errors.expired'));
    }    
    /**
     * Disabled Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function disabled(){
        
        View::set('title', e('Unsafe Link Detected'));

        View::set("description","This link has been marked as unsafe and we have disabled it for your own safety.");

        return new Response(View::dryRender('errors.disabled'), 410);
    }
    /**
     * Expired Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function expired(){
        View::set('title', e('Link Expired'));
        return View::dryRender('errors.expired');
    }
    /**
     * Password protected page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param object $url
     * @return void
     */
    public static function password(object $url){
        
        View::set('title', e('Enter your password to unlock this link'));
        View::set("description",e('The access to this link is restricted. Please enter your password to view it.'));

        if(config('detectadblock') && !$url->pro){
			
            CDN::load("blockadblock");

			View::push('<script type="text/javascript">var detect = '.json_encode(["on" => e("Adblock Detected"), "detail" => e("Please disable Adblock and refresh the page again.")]).'</script>','custom')->tofooter();

			View::push(assets('detect.app.js'),"script")->tofooter();
		}

        return View::with('gates.password')->extend('layouts.auth');
    }
    /**
     * Direct method
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param object $url
     * @param object $user
     * @return void
     */
    public static function direct(object $url, $user = null){

        if($user && $user->has('pixels') && !empty($url->pixels)){
			return (new Response('<!DOCTYPE html>
						<html lang="en">
						<head>
						  <meta charset="UTF-8">
						  <title>'.$url->meta_title.' | '.config("title").'</title>			
						  <meta name="description" content="'.$url->meta_description.'" />			  
						  <meta http-equiv="refresh" content="2;url='.$url->url.'">
						  <style>body{background:#f8f8f8; position: relative;}.loader,.loader:after{border-radius:50%;width:5em;height:5em}.loader{position:absolute!important;top:100%;display:block;left:48%;left:calc(50vw - 5em);font-size:10px;text-indent:-9999em;border-top:1.1em solid rgba(128,128,128,.2);border-right:1.1em solid rgba(128,128,128,.2);border-bottom:1.1em solid rgba(128,128,128,.2);border-left:1.1em solid grey;-webkit-transform:translateZ(0);-ms-transform:translateZ(0);transform:translateZ(0);-webkit-animation:load8 1.1s infinite linear;animation:load8 1.1s infinite linear}@-webkit-keyframes load8{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes load8{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}</style>
						  '.self::injectPixels($url->pixels, $user).'
						</head>
						<body>
						  <div class="loader">Redirecting</div>
						</body>
						</html>', 301))->send();
		}

        return (new Response(null, 301, ['location' => $url->url]))->send();
    }
    /**
     * Frame method
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param object $url
     * @return void
     */
    public static function frame(object $url){
        if($user && $user->has('pixels')){
			self::injectPixels($url->pixels, $user);
		}

        View::set('bodyClass', 'overflow-hidden');

        View::push('<style> html { overflow: hidden } </style>','custom')->toHeader();
        View::push('<script type="text/javascript"> $("iframe#site").height($(document).height()-$("#frame").height()).css("top",$("#frame").height()+30)</script>','custom')->tofooter();

        return View::with('gates.frame', ['url' => $url])->extend('layouts.auth');
    }
    /**
     * Splash method
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param object $url
     * @return void
     */
    public static function splash(object $url, $user = null){

        if($user && $user->has('pixels')){
			self::injectPixels($url->pixels, $user);
		}

        if(!empty(config('analytics'))){					
			\Core\View::push("<script async src='https://www.googletagmanager.com/gtag/js?id=".config('analytics')."'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '".config('analytics')."');</script>","custom")->tofooter();
		}	

		// Add timer animation	
		if(!empty(config('timer')) || config('timer') != "0"){
            if(appConfig('app.redirectauto')){
                \Core\View::push('<script type="text/javascript">var count = '.config('timer').';var countdown = setInterval(function(){$("a.redirect").attr("href","#pleasewait").html(count + " seconds");if (count < 1) {clearInterval(countdown);window.location="'.$url->url.'";}count--;}, 1000);</script>',"custom")->toHeader();
            } else {
                \Core\View::push('<script type="text/javascript">var count = '.config('timer').';var countdown = setInterval(function(){$("a.redirect").attr("href","#pleasewait").html(count + " seconds");if (count < 1) {clearInterval(countdown);$("a.redirect").attr("href","'.$url->url.'").html("'.e('Continue').'");}count--;}, 1000);</script>',"custom")->toHeader(); 
            }			     								
		}

		// BlockAdblock
		if(config('detectadblock') && !$url->pro){
			
            CDN::load("blockadblock");

			View::push('<script type="text/javascript">var detect = '.json_encode(["on" => e("Adblock Detected"), "detail" => e("Please disable Adblock and refresh the page again.")]).'</script>','custom')->tofooter();

			View::push(assets('detect.app.js'),"script")->tofooter();
		}	
        
        return View::with('gates.splash', ['url' => $url])->extend('layouts.api');
    }
    /**
     * Custom Overlay
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $url
     * @param [type] $user
     * @return void
     */
    public static function custom($url, $splash, $user){
        
        if($user && $user->has('pixels')){
			self::injectPixels($url->pixels, $user);
		}

        if(!empty(config('analytics'))){					
			\Core\View::push("<script async src='https://www.googletagmanager.com/gtag/js?id=".config('analytics')."'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '".config('analytics')."');</script>","custom")->tofooter();
		}	
        
        $splash->data = json_decode($splash->data);

        $counter = isset($splash->data->counter) && is_numeric($splash->data->counter) ? $splash->data->counter : config('timer');

        \Core\View::push('<script type="text/javascript">var count = '.$counter.';var countdown = setInterval(function(){$("#counter span").text(count);if (count < 1) {clearInterval(countdown);window.location="'.$url->url.'";}count--;}, 1000);</script>',"custom")->toHeader();
        

        View::set('bodyClass', 'bg-secondary');
        

        return View::with('gates.custom', ['url' => $url, 'splash' => $splash])->extend('layouts.auth');
    }
    /**
     * Overlay
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $url
     * @param [type] $user
     * @return void
     */
    public static function overlay($url, $user){
        
        $type = str_replace('overlay-', '', $url->type);

        if(!$overlay = \Core\DB::overlay()->where('id', $type)->where('userid', $url->userid)->first()){
            stop(404);
        }

        $overlay->data = json_decode($overlay->data);

        if(!empty(config('analytics'))){					
            \Core\View::push("<script async src='https://www.googletagmanager.com/gtag/js?id=".config('analytics')."'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '".config('analytics')."');</script>","custom")->tofooter();
		}	

        if(isset($overlay->data->link)){
            \Core\View::push('<script>$(document).ready(function(){ $(".clickable").click(function() { window.location = "'.$overlay->data->link.'"; });});</script>', "custom")->tofooter();
        }

        if($overlay->type == "newsletter"){
            \Core\View::push('<script>
            $("#newsletter-form").submit(function(e){
                e.preventDefault();
                if(validateForm($(this)) == false ) return false;
                $.ajax({
                    type: "POST",
                    url: "'.route('server.subscribe').'",
                    data: $(this).serialize(),
                    success: function (response) { 
                        $(".contact-box").text(response.message);                        
                        setTimeout(function(){
                            $(".contact-overlay").fadeOut();
                        }, 5000);
                    }
                }); 
            });</script>', 'custom')->tofooter();
        }

        if($overlay->type == "contact"){
            \Core\View::push('<script>$(".contact-event").click(function(e) { 
                e.preventDefault(); 
                $(this).hide(); 
                $(".contact-box").fadeIn(); 
            });  
            $(".contact-close").click(function(e){
                e.preventDefault(); 
                $(".contact-box").hide();
                $(".contact-event").fadeIn();
            });
            $("#contact-form").submit(function(e){
                e.preventDefault();
                if(validateForm($(this)) == false ) return false;
                $.ajax({
                    type: "POST",
                    url: "'.route('server.contact').'",
                    data: $(this).serialize(),
                    success: function (response) { 
                        $("#contact-form input").val("");
                        $(".contact-box").hide();
                        $(".contact-event").fadeIn();
                        $("#contact-form").trigger("reset");
                        let style = $(".contact-event i").attr("style");
                        $(".contact-event i").removeClass("fa-question").addClass("fa-check").attr("style", "background-color:#82e26f;color:#fff");
                        setTimeout(function(){
                            $(".contact-event i").removeClass("fa-check").addClass("fa-question").attr("style", style);
                            $(".contact-overlay").fadeOut();
                        }, 5000);
                    }
                }); 
            });</script>', 'custom')->tofooter();
        }
        if($overlay->type == "poll"){
            \Core\View::push('$(".poll-form").submit(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: appurl + "/server",
                data: "request=ajax_poll&"+$(this).serialize()+"&token="+token,        
                success: function (response) { 
                  $(".poll-box").html("<p><i class=\"fa fa-check\"></i></p>");
                  $(".poll-form").remove();
                  let style = $(".contact-event i").attr("style");
                  setTimeout(function(){
                    $(".poll-overlay").remove();
                  }, 2000);
                }
            }); 
          });</script>', 'custom')->tofooter();
        }

		if(App::iframePolicy($url->url)) return self::direct($url);

        View::push('<style> html { overflow: hidden } </style>','custom')->toHeader();
        View::push('<script type="text/javascript"> $("iframe#site").height($(document).height())</script>','custom')->tofooter();

		$content = \call_user_func_array(self::types($overlay->type, 'view'), [$overlay, $url]);
        
        return View::with(function() use ($url, $content){
            return print('<iframe id="site" src="'.$url->url.'" frameborder="0" loading="lazy" style="border: 0; width: 100%; height: 100%;position: absolute;top: 0px;z-index: 1;" scrolling="yes"></iframe><div id="main-overlay">'.$content.'</div>');
        })->extend('layouts.auth');
    }

    /**
     * Embed Media
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param array $data
     * @category extendable
     * @return void
     */
    public static function embed(array $data){
        $sites = [
            // Youtube
            "youtube" => "<iframe id='ytplayer' type='text/html'  width='100%' height='400' allowtransparency='true' src='//www.youtube.com/embed/{$data['id']}?autoplay=1&origin=".config('url')."' frameborder='0'></iframe>",
            "youtu" => "<iframe id='ytplayer' type='text/html'  width='100%' height='400' allowtransparency='true' src='//www.youtube.com/embed/{$data['id']}?autoplay=1&origin=".config('url')."' frameborder='0'></iframe>",

            // Vimeo
            "vimeo" => "<iframe src='//player.vimeo.com/video/{$data['id']}' width='100%' height='400' allowtransparency='true' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>",
            // Dailymotion
            "dailymotion" => "<iframe src='http://www.dailymotion.com/embed/video/{$data['id']}' width='100%' height='390' allowtransparency='true' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>",
            // FunnyOrDie
            "funnyordie" => "<iframe src='http://www.funnyordie.com/embed/{$data['id']}' width='100%' height='400' allowtransparency='true' frameborder='0' allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>",
            // Collegehumor
            "collegehumor" => "<iframe src='http://www.collegehumor.com/e/{$data['id']}'  width='100%' height='400' allowtransparency='true' frameborder='0' webkitAllowFullScreen allowFullScreen></iframe>",
        ];

        if($extended = \Core\Plugin::dispatch('mediaembed.extend')){
			foreach($extended as $fn){
				$sites = array_merge($sites, $fn);
			}
		}
        return $sites[$data['host']];
    }
    /**
     * Media Gateway
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param [type] $url
     * @param [type] $media
     * @return void
     */
    public static function media($url, $media, $user = null){

        if($user && $user->has('pixels')){
			self::injectPixels($url->pixels, $user);
		}

		if(!empty(config('analytics'))){					
			\Core\View::push("<script async src='https://www.googletagmanager.com/gtag/js?id=".config('analytics')."'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '".config('analytics')."');</script>","custom")->tofooter();
		}			
		if(config('detectadblock') && !$url->pro){
			
            CDN::load("blockadblock");

			View::push('<script type="text/javascript">var detect = '.json_encode(["on" => e("Adblock Detected"), "detail" => e("Please disable Adblock and refresh the page again.")]).'</script>','custom')->tofooter();

			View::push(assets('detect.app.js'),"script")->tofooter();
		}	

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();
        View::push(assets('custom.js'),"script")->tofooter();

        $url->embed = self::embed($media);

        return View::with('gates.media', ['url' => $url, 'media' => $media])->extend('layouts.api');
    }
    /**
     * Profile
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function profile($profile, $user = null){
        if(!$user) $user = \Models\User::where('id', $profile->userid)->first();        

        $profiledata = json_decode($profile->data, true);
        
        View::push('<style>body{min-height: 100vh;color: '.$profiledata['style']['textcolor'].'background: '.$profiledata['style']['bg'].';background: linear-gradient(135deg,'.$profiledata['style']['gradient']['start'].' 0%, '.$profiledata['style']['gradient']['stop'].' 100%);}.fab{font-size: 1.3em}h1,h3,em,p,a{color: '.$profiledata['style']['textcolor'].' !important;}a:hover{color: '.$profiledata['style']['textcolor'].';opacity: 0.8;}.btn-custom{background: '.$profiledata['style']['buttoncolor'].';color: '.$profiledata['style']['buttontextcolor'].' !important;}.btn-custom:hover{opacity: 0.8;color: '.$profiledata['style']['buttontextcolor'].';}</style>','custom')->toHeader();        

        foreach($profiledata['links'] as $key => $value){
            if($value['type'] == "link"){
                if($url = \Core\DB::url()->first($value['urlid'])){
                    $profiledata['links'][$key]['link'] = \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom);
                }
            }

            if($value['type'] == 'youtube'){
                preg_match("~youtube\.(.*)\/watch\?v=([^\&\?\/]+)~", $value['link'], $match);
                if(isset($match[2])){
                    $profiledata['links'][$key]['link'] = 'https://www.youtube.com/embed/'.$match[2];
                }
            }
            if($value['type'] == 'spotify'){
                $profiledata['links'][$key]['link'] = str_replace('/track/', '/embed/track/', $value['link']);
            }

            if($value['type'] == 'itunes'){
                $profiledata['links'][$key]['link'] = str_replace('music.apple', 'embed.music.apple', $value['link']);
            }
            if($value['type'] == 'tiktok'){
                $id = explode('/', $value['link']);
                $profiledata['links'][$key]['id'] = end($id);
            }
        }
    
        View::set('title', $profile->name);

        return View::with('gates.profile', compact('profile', 'profiledata', 'user'))->extend('layouts.auth');

    }
    /**
     * Bundle
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $profile
     * @return void
     */
    public static function bundle($profile, $bundle, $user = null){

        if(!$user) $user = \Models\User::where('id', $profile->userid)->first();

        $profiledata = json_decode($profile->data, true);
        
        View::push('<style>body{min-height: 100vh;color: '.$profiledata['style']['textcolor'].'background: '.$profiledata['style']['bg'].';background: linear-gradient(135deg,'.$profiledata['style']['gradient']['start'].' 0%, '.$profiledata['style']['gradient']['stop'].' 100%);}.fab{font-size: 1.3em}h1,h3,em,p,a{color: '.$profiledata['style']['textcolor'].' !important;}a:hover{color: '.$profiledata['style']['textcolor'].';opacity: 0.8;}.btn-custom{background: '.$profiledata['style']['buttoncolor'].';color: '.$profiledata['style']['buttontextcolor'].' !important;border:0;}.btn-custom:hover{background: '.$profiledata['style']['buttoncolor'].';opacity: 0.8;color: '.$profiledata['style']['buttontextcolor'].';}</style>','custom')->toHeader();        
        
        $urls = \Models\Url::recent()->where('bundle', $bundle->id)->orderByDesc('date')->paginate(10, true);
        
        View::set('title', $profile->name.' '.e('List'));

        return View::with('gates.list', compact('profile', 'profiledata', 'user', 'urls'))->extend('layouts.auth');

    }
    /**
     * Inject Pixel
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $pixels
     * @param object $user
     * @return void
     */
    protected static function injectPixels($pixels, object $user){

		$pixels = explode(",", $pixels);
		$output = "";
        foreach ($pixels as $pixel) {            
            
            if(empty($pixel)) continue;

            [$name, $id] = explode("-", $pixel);

            if(!$pixelInfo = \Core\DB::pixels()->select('tag')->where('userid', $user->id)->where('id', $id)->first()) continue;
            
            $fn = "pixel_{$name}";

            $output .= self::$fn($pixelInfo->tag)."\n";
            \Core\View::push(self::$fn($pixelInfo->tag), "custom")->toHeader();						
        }

        return $output;
	}

    /**
	 * Facebook Pixel
	 * @author KBRmedia <http://gempixel.com>
	 * @version 6.0
	 * @param  string $id
	 */
	protected static function pixel_fbpixel($id){
		if(empty($id) || strlen($id) < 9) return;

		return "<!--fbpixel--><script type='text/javascript'>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init', '{$id}');fbq('track', 'PageView');		fbq('track', 'Lead');</script><noscript><img height='1' width='1' style='display:none'src='https://www.facebook.com/tr?id={$id}&ev=PageView&noscript=1'/></noscript>";
	}
	/**
	 * Adwords Pixel
	 * @author KBRmedia <http://gempixel.com>
	 * @version 1.0
	 * @param  string $id
	 */
	protected static function pixel_adwordspixel($id){
		if(empty($id) || strlen($id) < 9) return;

		$Eid = explode("/", $id);

		return "<!--adwordspixel--><script async src='https://www.googletagmanager.com/gtag/js?id={$Eid[0]}'></script><script type='text/javascript'>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '{$Eid[0]}');gtag('event', 'conversion', {'send_to': '{$id}'});</script>";
	}	
	/**
	 * Lnkedin Pixel
	 * @author KBRmedia <http://gempixel.com>
	 * @version 6.0
	 * @param  string $id
	 */
	protected static function pixel_linkedinpixel($id){
		if(empty($id) || strlen($id) < 6) return;

		return '<!--linkedinpixel--><script type="text/javascript">_linkedin_data_partner_id = "'.$id.'";</script><script type="text/javascript">(function(){var s = document.getElementsByTagName("script")[0];var b = document.createElement("script");b.type = "text/javascript";b.async = true;b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";s.parentNode.insertBefore(b, s);})();</script><noscript><img height="1" width="1" style="display:none;" alt="" src="https://dc.ads.linkedin.com/collect/?pid='.$id.'&fmt=gif" /></noscript>';
	}	
	/**
	 * Adroll Pixel
	 * @author KBRmedia <http://gempixel.com>
	 * @version 5.1
	 * @param  string $id
	 */
	protected static function pixel_adrollpixel($id){

		if(empty($id) || strlen($id) < 9) return;

		$Eid = explode("/", $id);

		return '<!--adrollpixel--><script type="text/javascript">adroll_adv_id = "'.$Eid[0].'";adroll_pix_id = "'.$Eid[1].'";(function () {var _onload = function(){if (document.readyState && !/loaded|complete/.test(document.readyState)){setTimeout(_onload, 10);return}if (!window.__adroll_loaded){__adroll_loaded=true;setTimeout(_onload, 50);return}var scr = document.createElement("script");var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");scr.setAttribute(\'async\', \'true\');scr.type = "text/javascript";scr.src = host + "/j/roundtrip.js"; ((document.getElementsByTagName(\'head\') || [null])[0] || document.getElementsByTagName(\'script\')[0].parentNode).appendChild(scr);};if (window.addEventListener) {window.addEventListener(\'load\', _onload, false);}else {window.attachEvent(\'onload\', _onload)}}());</script>';

	}
	/**
	 * Twitter Pixel
	 * @author KBRmedia <http://gempixel.com>
	 * @version 5.1
	 * @param  string $id
	 */
	protected static function pixel_twitterpixel($id){
		return "<!--twitterpixel--><script type='text/javascript'>!function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);},s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='//static.ads-twitter.com/uwt.js',a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');twq('init','$id');twq('track','PageView');</script>";
	}
	/**
	 * Quora Pixel
	 * @author KBRmedia <https://gempixel.com>
	 * @version 5.6.3
	 * @param  string $id
	 */
	protected static function pixel_quorapixel($id){
		return "<!--quorapixel--><script>!function(q,e,v,n,t,s){if(q.qp) return; n=q.qp=function(){n.qp?n.qp.apply(n,arguments):n.queue.push(arguments);}; n.queue=[];t=document.createElement(e);t.async=!0;t.src=v; s=document.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s);}(window, 'script', 'https://a.quora.com/qevents.js');qp('init', '$id');qp('track', 'ViewContent');</script><noscript><img height=\"1\" width=\"1\" style=\"display:none\" src=\"https://q.quora.com/_/ad/$id/pixel?tag=ViewContent&noscript=1\"/></noscript>";
	}	
    /**
     * Google Tag Manager
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $id
     * @return void
     */
    protected static function pixel_gtmpixel($id){
        return "<!--gtmpixel--><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{$id}');</script>";
    }
    /**
     * Google Analytics
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $id
     * @return void
     */
    protected static function pixel_gapixel($id){
        return "<!--gapixel--><script async src='https://www.googletagmanager.com/gtag/js?id={$id}'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '{$id}');</script>";
    }
    /**
     * Pinterest Pixel
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $id
     * @return void
     */
    protected static function pixel_pinterest($id){
        return '<script>
        !function(e){if(!window.pintrk){window.pintrk = function () {
        window.pintrk.queue.push(Array.prototype.slice.call(arguments))};var
          n=window.pintrk;n.queue=[],n.version="3.0";var
          t=document.createElement("script");t.async=!0,t.src=e;var
          r=document.getElementsByTagName("script")[0];
          r.parentNode.insertBefore(t,r)}}("https://s.pinimg.com/ct/core.js");
        pintrk(\'load\', \''.$id.'\');
        pintrk(\'page\');
        pintrk(\'track\', \'pagevisit\');
        </script>
        <noscript>
        <img height="1" width="1" style="display:none;" alt="" src="https://ct.pinterest.com/v3/?event=init&tid=2613103465872&noscript=1" /></noscript>';
    }
}