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
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\View;
use Models\User;

class Overlay {

	use \Traits\Overlays;
	
	/**
	 * Verify Permission
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 */
	public function __construct(){

		if(User::where('id', Auth::user()->rID())->first()->has('overlay') === false){
			return \Models\Plans::notAllowed();
		}
	}
	/**
	 * List Overlay Page
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function index(){

		$overlaypages = DB::overlay()->where('userid', Auth::user()->rID())->orderByDesc('id')->map(function($overlay){
			$overlay->icon = self::types($overlay->type, 'icon');
			return $overlay;
		});

		$count = DB::overlay()->where('userid', Auth::user()->rID())->count();
		$total = User::where('id', Auth::user()->rID())->first()->hasLimit('overlay');

		View::set('title', e('CTA Overlay'));

		return View::with('overlay.index', compact('overlaypages', 'count', 'total'))->extend('layouts.dashboard');
	}

	/**
	 * Create Overlay Page
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function create($type = null){
		
		if(Auth::user()->teamPermission('overlay.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

		$types = self::types();

		if($type && isset($types[$type]) && isset($types[$type]['create'])){
			return \call_user_func_array($types[$type]['create'], [$type]);
		}

		$count = DB::overlay()->where('userid', Auth::user()->rID())->count();
		$total = User::where('id', Auth::user()->rID())->first()->hasLimit('overlay');

		\Models\Plans::checkLimit($count, $total);

		View::set('title', e('Create a CTA Overlay'));

		return View::with('overlay.create', compact('types','count', 'total'))->extend('layouts.dashboard');

	}	

	/**
	 * Save Overlay Page
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @return void
	 */
	public function save(Request $request, $type){

		if(Auth::user()->teamPermission('overlay.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

		$count = DB::overlay()->where('userid', Auth::user()->rID())->count();
		$total = User::where('id', Auth::user()->rID())->first()->hasLimit('overlay');

		\Models\Plans::checkLimit($count, $total);

		$types = self::types();

		if($type && isset($types[$type]) && isset($types[$type]['save'])){
			return \call_user_func_array($types[$type]['save'], [$request]);
		}
		return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
	}	

	/**
	 * Edit Overlay
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param integer $id
	 * @return void
	 */
	public function edit(int $id){
		
		if(Auth::user()->teamPermission('overlay.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

		if(!$overlay = DB::overlay()->where('userid', Auth::user()->rID())->where('id', $id)->first()){
			return back()->with('danger', e('Overlay page does not exist.'));
		}

		$types = self::types();

		if(isset($types[$overlay->type]) && isset($types[$overlay->type]['edit'])){
			return \call_user_func_array($types[$overlay->type]['edit'], [$overlay]);
		}

		return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
	}
	
	/**
	 * Update Existing Overlay
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @param integer $id
	 * @return void
	 */
	public function update(Request $request, int $id){

		if(Auth::user()->teamPermission('overlay.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

		if(!$overlay = DB::overlay()->where('userid', Auth::user()->rID())->where('id', $id)->first()){
			return back()->with('danger', e('Overlay page does not exist.'));
		}

		$overlay->data = json_decode($overlay->data);

		$types = self::types();

		if(isset($types[$overlay->type]) && isset($types[$overlay->type]['update'])){
			return \call_user_func_array($types[$overlay->type]['update'], [$request, $overlay]);
		}

		return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
	}
	/**
	 * Create Contact Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function contactCreate(string $type){

		$name = self::types($type, 'name');
		$description = self::types($type, 'description');

		View::set('title', $name);
		
		\Helpers\CDN::load('spectrum');

		View::push('<script type="text/javascript">							
					function bgColor(element, color, e) {
						$(element).css("background-color", (color ? color.toHexString() : ""));
						e.val(color.toHexString());
					}
					function Color(element, color, e) {
						$(element).css("color", (color ? color.toHexString() : ""));
						e.val(color.toHexString());
					}		
					$("#name-p").keyup(function(e){
							$("label[for=contact-name]").text($(this).val());
					});		
					$("#email-p").keyup(function(e){
							$("label[for=contact-email]").text($(this).val());
					});			
					$("#message-p").keyup(function(e){
							$("label[for=contact-message]").text($(this).val());
					});			
					$("#button-p").keyup(function(e){
							$(".contact-box button[type=submit]").text($(this).val());
					});							    				    				    					    
					$("#label").keyup(function(e){
						if($(this).val().length > 20) return false;
						if($(this).val().length < 1) return $(".contact-box .contact-label").hide();
						$(".contact-box .contact-label").show();
						$(".contact-box .contact-label, #contact-button span").text($(this).val());
					});	
					$("#content").keyup(function(e){
						if($(this).val().length > 144) return false;
						if($(this).val().length < 1) return $(".contact-box .contact-description").hide();
						$(".contact-box .contact-description").show();
						$(".contact-box .contact-description").text($(this).val());
					});							    						    				    
					$("#bg").spectrum({
						color: "#ffffff",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { bgColor(".contact-box, #contact-button", color, $(this)); },
						hide: function (color) { bgColor(".contact-box, #contact-button", color, $(this)); }
					}); 
					$("#color").spectrum({
						color: "#000000",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { Color(".contact-label,.contact-description,.contact-box label", color, $(this)); },
						hide: function (color) { Color(".contact-label,.contact-description,.contact-box label", color, $(this)); }
					});
					$("#inputbg").spectrum({
						color: "#ffffff",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { bgColor(".contact-box .form-control", color, $(this)); },
						hide: function (color) { bgColor(".contact-box .form-control", color, $(this)); }
					});  
					$("#inputcolor").spectrum({
						color: "#000000",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { Color(".contact-box .form-control", color, $(this)); },
						hide: function (color) { Color(".contact-box .form-control", color, $(this)); }
					});				    	
					$("#btnbg").spectrum({
						color: "#000000",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { bgColor(".contact-box button, #contact-button i", color, $(this)); },
						hide: function (color) { bgColor(".contact-box button, #contact-button i", color, $(this)); }
					});  
					$("#btncolor").spectrum({
						color: "#ffffff",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { Color(".contact-box button, #contact-button i", color, $(this)); },
						hide: function (color) { Color(".contact-box button, #contact-button i", color, $(this)); }
					});						    	
				</script>', "custom")->tofooter();

		return View::with('overlay.create_contact', compact('type', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Save Contact Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @return void
	 */
	public function contactSave(Request $request){
		
		$overlay = [];

		$lang = [
			'name' => e('Name'),
			'email' => e('Email'),
			'message' => e('Message'),
			'button' => e('send')
		];

		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","email","subject","label","content","success","lang","bg","color","btnbg","btncolor","inputbg","inputcolor","position","webhook"])) continue;
			$overlay[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
		}

		if(!$overlay['name']) return back()->with("danger", e("The name field cannot be empty."));

		if(!$overlay['email'] || !$request->validate($overlay['email'], 'email')) return back()->with("danger", e("Please enter a valid email."));		

		foreach($overlay['lang'] as $key => $value){
			if(empty($value)) $overlay['lang'][$key] = $lang[$key];
		}

		$overlayData = [
				"email" => $overlay["email"],
				"subject" => $overlay["subject"],
				"label" => $overlay["label"],
				"content" => $overlay["content"],
				"lang" => $overlay["lang"],
				"success" => $overlay["success"],
				"bg" => !empty($overlay["bg"]) && strlen($overlay["bg"]) < 8 ? $overlay["bg"] : '#fff',
				"color" => !empty($overlay["color"]) && strlen($overlay["color"]) < 8 ? $overlay["color"] : '#000',
				"btnbg" => !empty($overlay["btnbg"]) && strlen($overlay["btnbg"]) < 8 ? $overlay["btnbg"] : '#fff',
				"btncolor" => !empty($overlay["btncolor"]) && strlen($overlay["btncolor"]) < 8 ? $overlay["btncolor"] : '#000',
				"inputbg" => !empty($overlay["inputbg"]) && strlen($overlay["inputbg"]) < 8 ? $overlay["inputbg"] : '#fff',
				"inputcolor" => !empty($overlay["inputcolor"]) && strlen($overlay["inputcolor"]) < 8 ? $overlay["inputcolor"] : '#000',
				"position" => in_array($overlay["position"], ['tr','tl','bc','br','bl']) ? $overlay["position"] : 'br',
				"webhook" => $overlay["webhook"]
		];

		$db = DB::overlay()->create();
		$db->userid = Auth::user()->rID();
		$db->name = $overlay['name'];
		$db->data = json_encode($overlayData);
		$db->type = "contact";
		$db->date = Helper::dtime();

		$db->save();

		return Helper::redirect()->to(route('overlay'))->with('success', e('Overlay has been successfully created.'));
	}
	/**
	 * Edit Contact Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param object $overlay
	 * @return void
	 */
	public function contactEdit(object $overlay){

		$name = self::types($overlay->type, 'name');
		$description = self::types($overlay->type, 'description');

		$overlay->data = json_decode($overlay->data);

		View::set('title', e('Edit').' '.$overlay->name);
		
		\Helpers\CDN::load('spectrum');

		View::push('<script type="text/javascript">							
					function bgColor(element, color, e) {
						$(element).css("background-color", (color ? color.toHexString() : ""));
						e.val(color.toHexString());
					}
					function Color(element, color, e) {
						$(element).css("color", (color ? color.toHexString() : ""));
						e.val(color.toHexString());
					}		
					$("#name-p").keyup(function(e){
							$("label[for=contact-name]").text($(this).val());
					});		
					$("#email-p").keyup(function(e){
							$("label[for=contact-email]").text($(this).val());
					});			
					$("#message-p").keyup(function(e){
							$("label[for=contact-message]").text($(this).val());
					});			
					$("#button-p").keyup(function(e){
							$(".contact-box button[type=submit]").text($(this).val());
					});							    				    				    					    
					$("#label").keyup(function(e){
						if($(this).val().length > 20) return false;
						if($(this).val().length < 1) return $(".contact-box .contact-label").hide();
						$(".contact-box .contact-label").show();
						$(".contact-box .contact-label").text($(this).val());
					});	
					$("#content").keyup(function(e){
						if($(this).val().length > 144) return false;
						if($(this).val().length < 1) return $(".contact-box .contact-description").hide();
						$(".contact-box .contact-description").show();
						$(".contact-box .contact-description").text($(this).val());
					});							    						    				    
					$("#bg").spectrum({
						color: "'.$overlay->data->bg.'",
						showInput: true,
						preferredFormat: "hex",
						showPalette: true,
						move: function (color) { bgColor(".contact-box, #contact-button", color, $(this)); },
						hide: function (color) { bgColor(".contact-box, #contact-button", color, $(this)); }
					}); 
					$("#color").spectrum({
						color: "'.$overlay->data->color.'",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { Color(".contact-label,.contact-description,.contact-box label", color, $(this)); },
						hide: function (color) { Color(".contact-label,.contact-description,.contact-box label", color, $(this)); }
					});
					$("#inputbg").spectrum({
						color: "'.$overlay->data->inputbg.'",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { bgColor(".contact-box .form-control", color, $(this)); },
						hide: function (color) { bgColor(".contact-box .form-control", color, $(this)); }
					});  
					$("#inputcolor").spectrum({
						color: "'.$overlay->data->inputcolor.'",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { Color(".contact-box .form-control", color, $(this)); },
						hide: function (color) { Color(".contact-box .form-control", color, $(this)); }
					});				    	
					$("#btnbg").spectrum({
						color: "'.$overlay->data->btnbg.'",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { bgColor(".contact-box button, #contact-button i", color, $(this)); },
						hide: function (color) { bgColor(".contact-box button, #contact-button i", color, $(this)); }
					});  
					$("#btncolor").spectrum({
						color: "'.$overlay->data->btncolor.'",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { Color(".contact-box button, #contact-button i", color, $(this)); },
						hide: function (color) { Color(".contact-box button, #contact-button i", color, $(this)); }
					});						    	
				</script>', "custom")->tofooter();

		return View::with('overlay.edit_contact', compact('overlay', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Update Contact
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @param object $overlay
	 * @return void
	 */
	public function contactUpdate(Request $request, object $overlay){

		$db = [];

		$lang = [
			'name' => e('Name'),
			'email' => e('Email'),
			'message' => e('Message'),
			'button' => e('send')
		];

		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","email","subject","label","content","success","lang","bg","color","btnbg","btncolor","inputbg","inputcolor","position","webhook"])) continue;
			$db[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
		}

		if(!$db['name']) return back()->with("danger", e("The name field cannot be empty."));

		if(!$db['email'] || !$request->validate($db['email'], 'email')) return back()->with("danger", e("Please enter a valid email."));		

		foreach($db['lang'] as $key => $value){
			if(empty($value)) $db['lang'][$key] = $lang[$key];
		}

		$dbData = [
				"email" => $db["email"],
				"subject" => $db["subject"],
				"label" => $db["label"],
				"content" => $db["content"],
				"lang" => $db["lang"],
				"success" => $db["success"],
				"bg" => !empty($db["bg"]) && strlen($db["bg"]) < 8 ? $db["bg"] : '#fff',
				"color" => !empty($db["color"]) && strlen($db["color"]) < 8 ? $db["color"] : '#000',
				"btnbg" => !empty($db["btnbg"]) && strlen($db["btnbg"]) < 8 ? $db["btnbg"] : '#fff',
				"btncolor" => !empty($db["btncolor"]) && strlen($db["btncolor"]) < 8 ? $db["btncolor"] : '#000',
				"inputbg" => !empty($db["inputbg"]) && strlen($db["inputbg"]) < 8 ? $db["inputbg"] : '#fff',
				"inputcolor" => !empty($db["inputcolor"]) && strlen($db["inputcolor"]) < 8 ? $db["inputcolor"] : '#000',
				"position" => in_array($db["position"], ['tr','tl','bc','br','bl']) ? $db["position"] : 'br',
				"webhook" => $db["webhook"]
		];

		$overlay->name = $db['name'];
		$overlay->data = json_encode($dbData);		

		$overlay->save();

		return back()->with('success', e('Overlay has been successfully updated.')); 
	}
	/**
	 * Create Poll Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function pollCreate(string $type){

		$name = self::types($type, 'name');
		$description = self::types($type, 'description');

		View::set('title', $name);
		
		\Helpers\CDN::load('spectrum');

		View::push('<script type="text/javascript">	
					var poll_max = 10;
					$("[data-trigger=addpollchoice]").click(function(e){
						e.preventDefault();
						var poll_num = $(".poll-options > .form-group").length;
						if(poll_num == poll_max) return false;
						poll_num++;
						$(".poll-options").append("<div class=\"form-group mb-2\"><input type=\"text\" placeholder=\"#"+poll_num+"\" class=\"form-control\" name=\"answer[]\"  placeholder=\"\" data-id=\""+poll_num+"\"></div>");
						$("ol.poll-answers").append("<li data-id=\""+poll_num+"\">#"+poll_num+"</li>");
					});
					$(document).on("keyup", ".poll-options input[type=text]", function(){
						let id = $(this).data("id");
						if($(this).val().length <1 || $(this).val().length > 50) return false;
						$("ol.poll-answers li[data-id="+id+"]").text($(this).val());
					});								
					function bgColor(element, color, e) {
						$(element).css("background-color", (color ? color.toHexString() : ""));
						e.val(color.toHexString());
					}
					function Color(element, color, e) {
						$(element).css("color", (color ? color.toHexString() : ""));
						e.val(color.toHexString());
					}		
					$("#question").keyup(function(e){
						if($(this).val().length > 144) return false;
						$(".poll-question").text($(this).val());
					});		
					$("#votetext").keyup(function(e){
						$("[data-trigger=vote]").text($(this).val());
					});																    						    				    
					$("#bg").spectrum({
						color: "#ffffff",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { bgColor(".poll-box", color, $(this)); },
						hide: function (color) { bgColor(".poll-box", color, $(this)); }
					}); 
					$("#color").spectrum({
						color: "#000000",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { Color(".poll-box .poll-question,.poll-answers li", color, $(this)); },
						hide: function (color) { Color(".poll-box .poll-question,.poll-answers li", color, $(this)); }
					});								    	
					$("#btnbg").spectrum({
						color: "#000000",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { bgColor(".poll-box button", color, $(this)); },
						hide: function (color) { bgColor(".poll-box button", color, $(this)); }
					});  
					$("#btncolor").spectrum({
						color: "#ffffff",
						showInput: true,
						preferredFormat: "hex",
						move: function (color) { Color(".poll-box button", color, $(this)); },
						hide: function (color) { Color(".poll-box button", color, $(this)); }
					});						    	
				</script>', "custom")->tofooter();

		return View::with('overlay.create_poll', compact('type', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Save Poll Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @return void
	 */
	public function pollSave(Request $request){
		
		$overlay = [];


		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","question","answer","thankyou", "votetext", "bg","color","btnbg","btncolor","inputbg","inputcolor","position"])) continue;
			$overlay[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
		}

		if(!$overlay['name']) return back()->with("danger", e("The name field cannot be empty."));

		if(!$overlay['question'] || strlen($overlay['question']) < 4) return back()->with("danger", e("Please enter a valid question."));

		if(count($overlay["answer"]) < 2) return back()->with("danger",e("A minimum of two options is required."));

		$answers = [];
		$i = 0;
		foreach ($overlay["answer"] as $key => $answer) {
			if(empty($answer) || $i > 9) continue;
			$answers[$key]["option"] = $answer;
			$answers[$key]["votes"] = 0;
			$i++;
		}

		$overlayData = [
				"question" => $overlay["question"],
				"answers" => $answers,
				"votetext" => empty($overlay["votetext"]) ? e("Vote") : $overlay["votetext"],
				"thankyou" => $overlay["thankyou"],
				"bg" => !empty($overlay["bg"]) && strlen($overlay["bg"]) < 8 ? $overlay["bg"] : '#fff',
				"color" => !empty($overlay["color"]) && strlen($overlay["color"]) < 8 ? $overlay["color"] : '#000',
				"btnbg" => !empty($overlay["btnbg"]) && strlen($overlay["btnbg"]) < 8 ? $overlay["btnbg"] : '#fff',
				"btncolor" => !empty($overlay["btncolor"]) && strlen($overlay["btncolor"]) < 8 ? $overlay["btncolor"] : '#000',
				"position" => in_array($overlay["position"], ['tr','tl','bc','br','bl']) ? $overlay["position"] : 'br',
		];

		$db = DB::overlay()->create();
		$db->userid = Auth::user()->rID();
		$db->name = $overlay['name'];
		$db->data = json_encode($overlayData);
		$db->type = "poll";
		$db->date = Helper::dtime();

		$db->save();

		return Helper::redirect()->to(route('overlay'))->with('success', e('Overlay has been successfully created.'));
	}
	/**
	 * Edit Poll Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param object $overlay
	 * @return void
	 */
	public function pollEdit(object $overlay){

		$name = self::types($overlay->type, 'name');
		$description = self::types($overlay->type, 'description');

		$overlay->data = json_decode($overlay->data);

		View::set('title', e('Edit').' '.$overlay->name);
		
		\Helpers\CDN::load('spectrum');

		View::push('<script type="text/javascript">							
						var poll_max = 10;
						$("[data-trigger=addpollchoice]").click(function(e){
							e.preventDefault();
							var poll_num = $(".poll-options > .form-group").length;
							if(poll_num == poll_max) return false;
							poll_num++;
							$(".poll-options").append("<div class=\"form-group mb-2\"><input type=\"text\" placeholder=\"#"+poll_num+"\" class=\"form-control\" name=\"answer[]\"  placeholder=\"\" data-id=\""+poll_num+"\"></div>");
							$("ol.poll-answers").append("<li data-id=\""+poll_num+"\">#"+poll_num+"</li>");
						});
						$(document).on("keyup", ".poll-options input[type=text]", function(){
							let id = $(this).data("id");
							if($(this).val().length <1 || $(this).val().length > 50) return false;
							$("ol.poll-answers li[data-id="+id+"]").text($(this).val());
						});								
						function bgColor(element, color, e) {
							$(element).css("background-color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}
						function Color(element, color, e) {
							$(element).css("color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}		
						$("#question").keyup(function(e){
							if($(this).val().length > 144) return false;
							$(".poll-question").text($(this).val());
						});		
						$("#votetext").keyup(function(e){
							$("[data-trigger=vote]").text($(this).val());
						});																    						    				    
						$("#bg").spectrum({
							color: "'.$overlay->data->bg.'",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { bgColor(".poll-box", color, $(this)); },
							hide: function (color) { bgColor(".poll-box", color, $(this)); }
						}); 
						$("#color").spectrum({
							color: "'.$overlay->data->color.'",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { Color(".poll-box .poll-question,.poll-answers li", color, $(this)); },
							hide: function (color) { Color(".poll-box .poll-question,.poll-answers li", color, $(this)); }
						});								    	
						$("#btnbg").spectrum({
							color: "'.$overlay->data->btnbg.'",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { bgColor(".poll-box button", color, $(this)); },
							hide: function (color) { bgColor(".poll-box button", color, $(this)); }
						});  
						$("#btncolor").spectrum({
							color: "'.$overlay->data->btncolor.'",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { Color(".poll-box button", color, $(this)); },
							hide: function (color) { Color(".poll-box button", color, $(this)); }
						});							    	
				</script>', "custom")->tofooter();
		
		$overlay->totalResponse = 0;
		foreach($overlay->data->answers as $answer){
			$overlay->totalResponse += $answer->votes;
		}

		return View::with('overlay.edit_poll', compact('overlay', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Update Poll
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @param object $overlay
	 * @return void
	 */
	public function pollUpdate(Request $request, object $overlay){

		$db = [];

		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","question","answer","thankyou", "votetext", "bg","color","btnbg","btncolor","inputbg","inputcolor","position"])) continue;
			$db[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
		}

		if(!$db['name']) return back()->with("danger", e("The name field cannot be empty."));

		if(!$db['question'] || strlen($db['question']) < 4)  return back()->with("danger", e("Please enter a valid question."));		

		if(count($db["answer"]) < 2) return back()->with("danger",e("A minimum of two options is required."));

		$answers = [];
		$i = 0;
		foreach ($db["answer"] as $key => $answer) {
			if(empty($answer) || $i > 9) continue;
			$answers[$key]["option"] = $answer;
			$answers[$key]["votes"] = isset($overlay->data->answers[$key]) ? $overlay->data->answers[$key]->votes : 0;
			$i++;
		}

		$dbData = [
			"question" => $db["question"],
			"answers" => $answers,
			"votetext" => empty($db["votetext"]) ? e("Vote") : $db["votetext"],
			"thankyou" => $db["thankyou"],
			"bg" => !empty($db["bg"]) && strlen($db["bg"]) < 8 ? $db["bg"] : '#fff',
			"color" => !empty($db["color"]) && strlen($db["color"]) < 8 ? $db["color"] : '#000',
			"btnbg" => !empty($db["btnbg"]) && strlen($db["btnbg"]) < 8 ? $db["btnbg"] : '#fff',
			"btncolor" => !empty($db["btncolor"]) && strlen($db["btncolor"]) < 8 ? $db["btncolor"] : '#000',
			"position" => in_array($db["position"], ['tr','tl','bc','br','bl']) ? $db["position"] : 'br',
		];

		$overlay->name = $db['name'];
		$overlay->data = json_encode($dbData);
		$overlay->save();

		return back()->with('success', e('Overlay has been successfully updated.')); 
	}
	/**
	 * Create Message Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function messageCreate(string $type){

		$name = self::types($type, 'name');
		$description = self::types($type, 'description');

		View::set('title', $name);	

		\Helpers\CDN::load("spectrum");

  		View::push('<script type="text/javascript">
						$("input[name=logo]").change(function(e){
							if(!e.target.files[0]) return $(".custom-img img").remove();							  	
							var type = e.target.files[0].type;
							if(type == "image/png" || type == "image/jpeg"){
								var reader = new FileReader();							      
								reader.onload = function (e) {							          
								$(".custom-img").html("<img src=\'"+e.target.result+"\'>");
								}
								reader.readAsDataURL(e.target.files[0]);      
							}
						});  							
						function bgColor(element, color, e) {
							$(element).css("background-color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}
						function Color(element, color, e) {
							$(element).css("color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}		
						$("#message").keyup(function(e){
							if($(this).val().length > 140) return false;
								$(".custom-message .custom-text").text($(this).val());
						});		
						$("#label").keyup(function(e){
							if($(this).val().length > 8) return false;
							if($(this).val().length < 1) return $(".custom-message .custom-label").hide();
							$(".custom-message .custom-label").show();
							$(".custom-message .custom-label").text($(this).val());
						});	
						$("#text").keyup(function(e){
						    	if($(this).val().length > 35) return false;
						    	if($(this).val().length < 1) return $(".custom-message .btn").hide();
								$(".custom-message .btn").show();
								$(".custom-message .btn").text($(this).val());
						});							    						    				    
						$("#bg").spectrum({
					        color: "#008aff",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { bgColor(".custom-message", color, $(this)); },
					        hide: function (color) { bgColor(".custom-message", color, $(this)); }
						}); 
						$("#color").spectrum({
					        color: "#fff",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { Color(".custom-message .custom-text", color, $(this)); },
					        hide: function (color) { Color(".custom-message .custom-text", color, $(this)); }
						});
						$("#btnbg").spectrum({
					        color: "#fff",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { bgColor(".custom-message .btn", color, $(this)); },
					        hide: function (color) { bgColor(".custom-message .btn", color, $(this)); }
						});  
						$("#btncolor").spectrum({
					        color: "#000",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { Color(".custom-message .btn", color, $(this)); },
					        hide: function (color) { Color(".custom-message .btn", color, $(this)); }
						});
						$("#labelbg").spectrum({
					        color: "#fff",
					        showInput: true,
					        preferredFormat: "hex",					        
					        move: function (color) { bgColor(".custom-message .custom-label", color, $(this)); },
					        hide: function (color) { bgColor(".custom-message .custom-label", color, $(this)); }
						});  
						$("#labelcolor").spectrum({
					        color: "#000",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { Color(".custom-message .custom-label", color, $(this)); },
					        hide: function (color) { Color(".custom-message .custom-label", color, $(this)); }
						});					    	
					</script>', "custom")->tofooter(); 

		return View::with('overlay.create_message', compact('type', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Save Message Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @return void
	 */
	public function messageSave(Request $request){
		
		$overlay = [];

		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","link", "label", "text", "message","bg","color","btnbg","btncolor","labelbg","labelcolor","position"])) continue;
			$overlay[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
			$request->save($key, $value);
		}

		if(!$overlay['name']) return back()->with("danger", e("The name field cannot be empty."));

		if(!$overlay['message']) return back()->with("danger", e("The message field cannot be empty."));

		if($overlay['link'] && !$request->validate($overlay['link'], 'url')) return back()->with("danger", e("Please enter a valid URL."));


		$overlayData = [
				"message" => Helper::truncate($overlay["message"], 140),
				"link" => $overlay["link"],
				"label" => $overlay["label"],
				"text" => $overlay["text"],
				"bg" => !empty($overlay["bg"]) && strlen($overlay["bg"]) < 8 ? $overlay["bg"] : '#008aff',
				"color" => !empty($overlay["color"]) && strlen($overlay["color"]) < 8 ? $overlay["color"] : '#fff',
				"btnbg" => !empty($overlay["btnbg"]) && strlen($overlay["btnbg"]) < 8 ? $overlay["btnbg"] : '#fff',
				"btncolor" => !empty($overlay["btncolor"]) && strlen($overlay["btncolor"]) < 8 ? $overlay["btncolor"] : '#000',
				"labelbg" => !empty($overlay["labelbg"]) && strlen($overlay["labelbg"]) < 8 ? $overlay["labelbg"] : '#fff',
				"labelcolor" => !empty($overlay["labelcolor"]) && strlen($overlay["labelcolor"]) < 8 ? $overlay["labelcolor"] : '#000',
				"position" => in_array($overlay["position"], ['tr','tl','bc','br','bl']) ? $overlay["position"] : 'br',
		];

		if($image = $request->file('logo')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            if($image->sizekb >= 500) return back()->with("danger", e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            [$width, $height] = getimagesize($image->location);
            
            if(($width > 200 || $height > 200) ) return back()->with("danger", e("Logo must be either a PNG or a JPEG with a recommended dimension of 100x100."));
            
			$filename = Helper::rand(6)."_message_".$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);

			$overlayData['image'] = $filename;
		}

		$db = DB::overlay()->create();
		$db->userid = Auth::user()->rID();
		$db->name = $overlay['name'];
		$db->data = json_encode($overlayData);
		$db->type = "message";
		$db->date = Helper::dtime();
		$request->clear();
		$db->save();

		return Helper::redirect()->to(route('overlay'))->with('success', e('Overlay has been successfully created.'));
	}
	/**
	 * Edit Message Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param object $overlay
	 * @return void
	 */
	public function messageEdit(object $overlay){

		$name = self::types($overlay->type, 'name');
		$description = self::types($overlay->type, 'description');

		$overlay->data = json_decode($overlay->data);

		View::set('title', e('Edit').' '.$overlay->name);

		\Helpers\CDN::load("spectrum");
		
		View::push('<script type="text/javascript">
						$("input[name=logo]").change(function(e){
							if(!e.target.files[0]) return $(".custom-img img").remove();							  	
							var type = e.target.files[0].type;
							if(type == "image/png" || type == "image/jpeg"){
								var reader = new FileReader();							      
								reader.onload = function (e) {							          
								$(".custom-img").html("<img src=\'"+e.target.result+"\'>");
								}
								reader.readAsDataURL(e.target.files[0]);      
							}
						});  							
						function bgColor(element, color, e) {
							$(element).css("background-color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}
						function Color(element, color, e) {
							$(element).css("color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}		
						$("#message").keyup(function(e){
							if($(this).val().length > 140) return false;
								$(".custom-message .custom-text").text($(this).val());
						});		
						$("#label").keyup(function(e){
							if($(this).val().length > 8) return false;
							if($(this).val().length < 1) return $(".custom-message .custom-label").hide();
							$(".custom-message .custom-label").show();
							$(".custom-message .custom-label").text($(this).val());
						});	
						$("#text").keyup(function(e){
						    	if($(this).val().length > 35) return false;
						    	if($(this).val().length < 1) return $(".custom-message .btn").hide();
								$(".custom-message .btn").show();
								$(".custom-message .btn").text($(this).val());
						});							    						    				    
						$("#bg").spectrum({
					        color: "'.$overlay->data->bg.'",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { bgColor(".custom-message", color, $(this)); },
					        hide: function (color) { bgColor(".custom-message", color, $(this)); }
						}); 
						$("#color").spectrum({
					        color: "'.$overlay->data->color.'",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { Color(".custom-message .custom-text", color, $(this)); },
					        hide: function (color) { Color(".custom-message .custom-text", color, $(this)); }
						});
						$("#btnbg").spectrum({
					        color: "'.$overlay->data->btnbg.'",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { bgColor(".custom-message .btn", color, $(this)); },
					        hide: function (color) { bgColor(".custom-message .btn", color, $(this)); }
						});  
						$("#btncolor").spectrum({
					        color: "'.$overlay->data->btncolor.'",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { Color(".custom-message .btn", color, $(this)); },
					        hide: function (color) { Color(".custom-message .btn", color, $(this)); }
						});
						$("#labelbg").spectrum({
					        color: "'.$overlay->data->labelbg.'",
					        showInput: true,
					        preferredFormat: "hex",					        
					        move: function (color) { bgColor(".custom-message .custom-label", color, $(this)); },
					        hide: function (color) { bgColor(".custom-message .custom-label", color, $(this)); }
						});  
						$("#labelcolor").spectrum({
					        color: "'.$overlay->data->labelcolor.'",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { Color(".custom-message .custom-label", color, $(this)); },
					        hide: function (color) { Color(".custom-message .custom-label", color, $(this)); }
						});					    	
					</script>', "custom")->tofooter();

		return View::with('overlay.edit_message', compact('overlay', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Update Message
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @param object $overlay
	 * @return void
	 */
	public function messageUpdate(Request $request, object $overlay){

		$db = [];

		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","link", "label", "text", "message","bg","color","btnbg","btncolor","labelbg","labelcolor","position"])) continue;
			$db[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
			$request->save($key, $value);
		}

		if(!$db['name']) return back()->with("danger", e("The name field cannot be empty."));

		if(!$db['message']) return back()->with("danger", e("The message field cannot be empty."));

		if($db['link'] && !$request->validate($db['link'], 'url')) return back()->with("danger", e("Please enter a valid URL."));


		$dbData = [
				"message" => Helper::truncate($db["message"], 140),
				"link" => $db["link"],
				"label" => $db["label"],
				"text" => $db["text"],
				"bg" => !empty($db["bg"]) && strlen($db["bg"]) < 8 ? $db["bg"] : '#008aff',
				"color" => !empty($db["color"]) && strlen($db["color"]) < 8 ? $db["color"] : '#fff',
				"btnbg" => !empty($db["btnbg"]) && strlen($db["btnbg"]) < 8 ? $db["btnbg"] : '#fff',
				"btncolor" => !empty($db["btncolor"]) && strlen($db["btncolor"]) < 8 ? $db["btncolor"] : '#000',
				"labelbg" => !empty($db["labelbg"]) && strlen($db["labelbg"]) < 8 ? $db["labelbg"] : '#fff',
				"labelcolor" => !empty($db["labelcolor"]) && strlen($db["labelcolor"]) < 8 ? $db["labelcolor"] : '#000',
				"position" => in_array($db["position"], ['tr','tl','bc','br','bl']) ? $db["position"] : 'br',
		];

		if($image = $request->file('logo')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            if($image->sizekb >= 500) return back()->with("danger", e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            [$width, $height] = getimagesize($image->location);
            
            if(($width > 200 || $height > 200) ) return back()->with("danger", e("Logo must be either a PNG or a JPEG with a recommended dimension of 100x100."));
			
			if(isset($overlay->data->image) && $overlay->data->image && file_exists(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->image)){
				unlink(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->image);
			}
			$filename = Helper::rand(6)."_message_".$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);

			$dbData['image'] = $filename;
		}

		$overlay->name = $db['name'];
		$overlay->data = json_encode($dbData);

		$overlay->save();

		return back()->with('success', e('Overlay has been successfully updated.')); 
	}
	/**
	 * Create Image
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function imageCreate(string $type){

		$name = self::types($type, 'name');
		$description = self::types($type, 'description');

		View::set('title', $name);	

		\Helpers\CDN::load("spectrum");

  		View::push('<script type="text/javascript">
						$("input[name=logo]").change(function(e){
							if(!e.target.files[0]) return $(".custom-img img").remove();							  	
							var type = e.target.files[0].type;
							if(type == "image/png" || type == "image/jpeg"){
								var reader = new FileReader();							      
								reader.onload = function (e) {							          
									$(".custom-img").html("<img src=\'"+e.target.result+"\'>");
								}
								reader.readAsDataURL(e.target.files[0]);      
							}
						});
						$("input[name=image]").change(function(e){
							if(!e.target.files[0]) return $(".custom-bg").css("background-image", "");							  	
							var type = e.target.files[0].type;
							if(type == "image/png" || type == "image/jpeg"){
								var reader = new FileReader();							      
								reader.onload = function (e) {			
									console.log( e.target.result);		          
									$(".custom-bg").css("background-image", "url("+e.target.result+")");
								}
								reader.readAsDataURL(e.target.files[0]);      
							}
						});  							
						function bgColor(element, color, e) {
							$(element).css("background-color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}
						function Color(element, color, e) {
							$(element).css("color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}								    						    				    
						$("#bg").spectrum({
					        color: "#008aff",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { bgColor(".custom-image", color, $(this)); },
					        hide: function (color) { bgColor(".custom-image", color, $(this)); }
						});
					</script>', "custom")->tofooter(); 

		return View::with('overlay.create_image', compact('type', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Save Image
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @return void
	 */
	public function imageSave(Request $request){
		
		$overlay = [];

		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","bg","position","link"])) continue;
			$overlay[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
			$request->save($key, $value);
		}

		if(!$overlay['name']) return back()->with("danger", e("The name field cannot be empty."));
		
		if($overlay['link'] && !$request->validate($overlay['link'], 'url')) return back()->with("danger", e("Please enter a valid URL."));

		if(!$request->file('logo') || !$request->file('image')) return back()->with("danger", e("You need to upload your logo and/or a background."));

		$overlayData = [
			"bg" => !empty($overlay["bg"]) && strlen($overlay["bg"]) < 8 ? $overlay["bg"] : '#008aff',
			"link" => $db["link"],
			"position" => in_array($db["position"], ['tr','tl','bc','br','bl']) ? $db["position"] : 'br'
		];

		if($image = $request->file('logo')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            if($image->sizekb >= 500) return back()->with("danger", e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            [$width, $height] = getimagesize($image->location);
            
            if(($width > 200 || $height > 200) ) return back()->with("danger", e("Logo must be either a PNG or a JPEG with a recommended dimension of 100x100."));

			$filename = Helper::rand(6)."_image_".$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);

			$overlayData['image'] = $filename;
		}

		if($image = $request->file('image')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Image must be either a PNG or a JPEG (Max 1mb).'));

            if($image->sizemb >= 1) return back()->with("danger", e('Image must be either a PNG or a JPEG (Max 1mb).'));

            [$width, $height] = getimagesize($image->location);
            
            if(($width > 600 || $height > 150) ) return back()->with("danger", e("Image must be either a PNG or a JPEG with a recommended dimension of 600x150."));

			$filename = Helper::rand(6)."_image_".$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);

			$overlayData['bgimage'] = $filename;
		}

		$db = DB::overlay()->create();
		$db->userid = Auth::user()->rID();
		$db->name = $overlay['name'];
		$db->data = json_encode($overlayData);
		$db->type = "image";
		$db->date = Helper::dtime();
		$request->clear();
		$db->save();

		return Helper::redirect()->to(route('overlay'))->with('success', e('Overlay has been successfully created.'));
	}
	/**
	 * Edit Image
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param object $overlay
	 * @return void
	 */
	public function imageEdit(object $overlay){

		$name = self::types($overlay->type, 'name');
		$description = self::types($overlay->type, 'description');

		$overlay->data = json_decode($overlay->data);

		View::set('title', e('Edit').' '.$overlay->name);

		\Helpers\CDN::load("spectrum");
		
		View::push('<script type="text/javascript">
						$("input[name=logo]").change(function(e){
							if(!e.target.files[0]) return $(".custom-img img").remove();							  	
							var type = e.target.files[0].type;
							if(type == "image/png" || type == "image/jpeg"){
								var reader = new FileReader();							      
								reader.onload = function (e) {							          
									$(".custom-img").html("<img src=\'"+e.target.result+"\'>");
								}
								reader.readAsDataURL(e.target.files[0]);      
							}
						});
						$("input[name=image]").change(function(e){
							if(!e.target.files[0]) return $(".custom-bg").css("background-image", "");							  	
							var type = e.target.files[0].type;
							if(type == "image/png" || type == "image/jpeg"){
								var reader = new FileReader();							      
								reader.onload = function (e) {			
									console.log( e.target.result);		          
									$(".custom-bg").css("background-image", "url("+e.target.result+")");
								}
								reader.readAsDataURL(e.target.files[0]);      
							}
						});  							
						function bgColor(element, color, e) {
							$(element).css("background-color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}
						function Color(element, color, e) {
							$(element).css("color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}							    						    				    
						$("#bg").spectrum({
					        color: "'.$overlay->data->bg.'",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { bgColor(".custom-message", color, $(this)); },
					        hide: function (color) { bgColor(".custom-message", color, $(this)); }
						}); 										    	
					</script>', "custom")->tofooter();

		return View::with('overlay.edit_image', compact('overlay', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Update Image
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @param object $overlay
	 * @return void
	 */
	public function imageUpdate(Request $request, object $overlay){

		$db = [];

		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","bg","position","link"])) continue;
			$db[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
			$request->save($key, $value);
		}

		if(!$db['name']) return back()->with("danger", e("The name field cannot be empty."));
		
		if($db['link'] && !$request->validate($db['link'], 'url')) return back()->with("danger", e("Please enter a valid URL."));
		
		$dbData = [
			"bg" => !empty($db["bg"]) && strlen($db["bg"]) < 8 ? $db["bg"] : '#008aff',
			"link" => $db["link"],
			'image' => $overlay->data->image,
			'bgimage' =>  $overlay->data->bgimage,
			"position" => in_array($db["position"], ['tr','tl','bc','br','bl']) ? $db["position"] : 'br'
		];

		if($image = $request->file('logo')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            if($image->sizekb >= 500) return back()->with("danger", e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            [$width, $height] = getimagesize($image->location);
            
            if(($width > 200 || $height > 200) ) return back()->with("danger", e("Logo must be either a PNG or a JPEG with a recommended dimension of 100x100."));
			
			if(isset($overlay->data->image) && $overlay->data->image && file_exists(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->image)){
				unlink(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->image);
			}

			$filename = Helper::rand(6)."_".$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);

			$dbData['image'] = $filename;
		}

		if($image = $request->file('image')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Image must be either a PNG or a JPEG (Max 1mb).'));

            if($image->sizemb >= 1) return back()->with("danger", e('Image must be either a PNG or a JPEG (Max 1mb).'));

            [$width, $height] = getimagesize($image->location);
            
            if(($width > 600 || $height > 150) ) return back()->with("danger", e("Image must be either a PNG or a JPEG with a recommended dimension of 600x150."));
			
			if(isset($overlay->data->bgimage) && $overlay->data->bgimage && file_exists(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->bgimage)){
				unlink(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->bgimage);
			}

			$filename = Helper::rand(6)."_image_".$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);
			$dbData['bgimage'] = $filename;
		}

		$overlay->name = $db['name'];
		$overlay->data = json_encode($dbData);

		$overlay->save();

		return back()->with('success', e('Overlay has been successfully updated.')); 
	}
	/**
	 * Create Newsletter
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function newsletterCreate(string $type){

		$name = self::types($type, 'name');
		$description = self::types($type, 'description');

		View::set('title', $name);	

		\Helpers\CDN::load("spectrum");

  		View::push('<script type="text/javascript">													
						function bgColor(element, color, e) {
							$(element).css("background-color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}
						function Color(element, color, e) {
							$(element).css("color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}				
						$("#label").keyup(function(e){
							if($(this).val().length > 20) return false;
							if($(this).val().length < 1) return $(".contact-box .contact-label").hide();
							$(".contact-box .contact-label").show();
							$(".contact-box .contact-label").text($(this).val());
						});	
						$("#content").keyup(function(e){
							if($(this).val().length > 144) return false;
							if($(this).val().length < 1) return $(".contact-box .contact-description").hide();
							$(".contact-box .contact-description").show();
							$(".contact-box .contact-description").text($(this).val());
						});	
						$("#button-p").keyup(function(e){
							$(".contact-box button[type=submit]").text($(this).val());
						});					    						    				    
						$("#bg").spectrum({
					        color: "#fff",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { bgColor(".contact-box", color, $(this)); },
					        hide: function (color) { bgColor(".contact-box", color, $(this)); }
						});		
						$("#color").spectrum({
							color: "#000",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { Color(".contact-label,.contact-description,.contact-box label", color, $(this)); },
							hide: function (color) { Color(".contact-label,.contact-description,.contact-box label", color, $(this)); }
						});				
						$("#btnbg").spectrum({
							color: "#000",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { bgColor(".contact-box button, #contact-button i", color, $(this)); },
							hide: function (color) { bgColor(".contact-box button, #contact-button i", color, $(this)); }
						});  
						$("#btncolor").spectrum({
							color: "#fff",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { Color(".contact-box button, #contact-button i", color, $(this)); },
							hide: function (color) { Color(".contact-box button, #contact-button i", color, $(this)); }
						});	
					</script>', "custom")->tofooter(); 

		return View::with('overlay.create_newsletter', compact('type', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Save Newsletter
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @return void
	 */
	public function newsletterSave(Request $request){
		
		$overlay = [];

		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","email","subject","label","content","success","button","bg","color","btnbg","btncolor","inputbg","inputcolor","position","webhook"])) continue;
			$overlay[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
			$request->save($key, $value);
		}

		if(!$overlay['name']) return back()->with("danger", e("The name field cannot be empty."));
	
		$overlayData = [
			"label" => $overlay["label"],
			"content" => $overlay["content"],
			"button" => $overlay["button"],
			"success" => $overlay["success"],
			"bg" => !empty($overlay["bg"]) && strlen($overlay["bg"]) < 8 ? $overlay["bg"] : '#fff',
			"color" => !empty($overlay["color"]) && strlen($overlay["color"]) < 8 ? $overlay["color"] : '#000',
			"btnbg" => !empty($overlay["btnbg"]) && strlen($overlay["btnbg"]) < 8 ? $overlay["btnbg"] : '#000',
			"btncolor" => !empty($overlay["btncolor"]) && strlen($overlay["btncolor"]) < 8 ? $overlay["btncolor"] : '#fff',
			"position" => in_array($overlay["position"], ['tr','tl','bc','br','bl']) ? $overlay["position"] : 'br',
			"webhook" => $overlay["webhook"],
			"emails" => []
		];

		$db = DB::overlay()->create();
		$db->userid = Auth::user()->rID();
		$db->name = $overlay['name'];
		$db->data = json_encode($overlayData);
		$db->type = "newsletter";
		$db->date = Helper::dtime();
		$request->clear();
		$db->save();

		return Helper::redirect()->to(route('overlay'))->with('success', e('Overlay has been successfully created.'));
	}
	/**
	 * Edit Newsletter
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param object $overlay
	 * @return void
	 */
	public function newsletterEdit(object $overlay){
		
		$request = new Request;

		$name = self::types($overlay->type, 'name');
		$description = self::types($overlay->type, 'description');

		$overlay->data = json_decode($overlay->data);

		if($request->downloadcsv){
			$emails = $overlay->data->emails;
			\Core\File::contentDownload('emails.csv', function() use ($emails){
				echo "ID, Email\n";
				foreach($emails as $i => $email){					
					echo ($i+1).",{$email}\n";
				}
			});
			exit;
		}

		View::set('title', e('Edit').' '.$overlay->name);

		\Helpers\CDN::load("spectrum");
		
		View::push('<script type="text/javascript">													
						function bgColor(element, color, e) {
							$(element).css("background-color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}
						function Color(element, color, e) {
							$(element).css("color", (color ? color.toHexString() : ""));
							e.val(color.toHexString());
						}				
						$("#label").keyup(function(e){
							if($(this).val().length > 20) return false;
							if($(this).val().length < 1) return $(".contact-box .contact-label").hide();
							$(".contact-box .contact-label").show();
							$(".contact-box .contact-label").text($(this).val());
						});	
						$("#content").keyup(function(e){
							if($(this).val().length > 144) return false;
							if($(this).val().length < 1) return $(".contact-box .contact-description").hide();
							$(".contact-box .contact-description").show();
							$(".contact-box .contact-description").text($(this).val());
						});	
						$("#button-p").keyup(function(e){
							$(".contact-box button[type=submit]").text($(this).val());
						});					    						    				    
						$("#bg").spectrum({
					        color: "'.$overlay->data->bg.'",
					        showInput: true,
					        preferredFormat: "hex",
					        move: function (color) { bgColor(".contact-box", color, $(this)); },
					        hide: function (color) { bgColor(".contact-box", color, $(this)); }
						});		
						$("#color").spectrum({
							color: "'.$overlay->data->color.'",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { Color(".contact-label,.contact-description,.contact-box label", color, $(this)); },
							hide: function (color) { Color(".contact-label,.contact-description,.contact-box label", color, $(this)); }
						});				
						$("#btnbg").spectrum({
							color: "'.$overlay->data->btnbg.'",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { bgColor(".contact-box button, #contact-button i", color, $(this)); },
							hide: function (color) { bgColor(".contact-box button, #contact-button i", color, $(this)); }
						});  
						$("#btncolor").spectrum({
							color: "'.$overlay->data->btncolor.'",
							showInput: true,
							preferredFormat: "hex",
							move: function (color) { Color(".contact-box button, #contact-button i", color, $(this)); },
							hide: function (color) { Color(".contact-box button, #contact-button i", color, $(this)); }
						});	
					</script>', "custom")->tofooter(); 

		return View::with('overlay.edit_newsletter', compact('overlay', 'name', 'description'))->extend('layouts.dashboard');
	}
	/**
	 * Update Newsletter
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param \Core\Request $request
	 * @param object $overlay
	 * @return void
	 */
	public function newsletterUpdate(Request $request, object $overlay){

		$db = [];

		foreach($request->all() as $key => $value){
			if(!in_array($key, ["name","email","subject","label","content","success","button","bg","color","btnbg","btncolor","inputbg","inputcolor","position","webhook"])) continue;
			$db[$key] = is_array($value) ? array_map('\Core\Helper::RequestClean', $value) : Helper::RequestClean($value);
			$request->save($key, $value);
		}

		if(!$db['name']) return back()->with("danger", e("The name field cannot be empty."));
	
		$dbData = [
			"label" => $db["label"],
			"content" => $db["content"],
			"button" => $db["button"],
			"success" => $db["success"],
			"bg" => !empty($db["bg"]) && strlen($db["bg"]) < 8 ? $db["bg"] : '#fff',
			"color" => !empty($db["color"]) && strlen($db["color"]) < 8 ? $db["color"] : '#000',
			"btnbg" => !empty($db["btnbg"]) && strlen($db["btnbg"]) < 8 ? $db["btnbg"] : '#fff',
			"btncolor" => !empty($db["btncolor"]) && strlen($db["btncolor"]) < 8 ? $db["btncolor"] : '#000',
			"position" => in_array($db["position"], ['tr','tl','bc','br','bl']) ? $db["position"] : 'br',
			"webhook" => $db["webhook"],
			"emails" => $overlay->emails ?? []
		];

		$overlay->name = $db['name'];
		$overlay->data = json_encode($dbData);

		$overlay->save();

		return back()->with('success', e('Overlay has been successfully updated.')); 
	}
	/**
	 * Delete Overlay
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param integer $id
	 * @return void
	 */
	public function delete(int $id, string $nonce){
		
		\Gem::addMiddleware('DemoProtect');

		if(Auth::user()->teamPermission('overlay.delete') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

		if(!Helper::validateNonce($nonce, 'overlay.delete')){
			return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
		}

		if(!$overlay = DB::overlay()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
			return Helper::redirect()->back()->with('danger', e('Overlay not found. Please try again.'));
		}
		$overlay->data = json_decode($overlay->data);
		
		if(isset($overlay->data->image) && $overlay->data->image && file_exists(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->image)){
			unlink(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->image);
		}
		if(isset($overlay->data->bgimage) && $overlay->data->bgimage && file_exists(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->bgimage)){
			unlink(appConfig('app.storage')['uploads']['path'].'/'.$overlay->data->bgimage);
		}
		
		DB::url()->where("type", 'overlay-'.$overlay->id)->update(['type' => '']);
		$overlay->delete();
		return Helper::redirect()->back()->with('success', e('Overlay has been deleted.'));
	}	
}