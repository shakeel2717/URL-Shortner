<?php 
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a 
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  software and contact gempixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package GemFramework
 * @author GemPixel (http://gempixel.com) 
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */

namespace Models;

use Gem;
use Core\Model;
use Core\Helper;

class User extends Model {

	/**	
	 * Table Name
	 */
	public static $_table = DBprefix.'user';

	/**
	 * Auth Key Name
	 */
	const AUTHKEY = 'auth_key';

	/**
	 * Return id or teamid for resources
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function rID(){
		return $this->teamid ?: $this->id;
	}	
	/**
	 * User avatar
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function avatar(){
		
		if($this->avatar) {
			return \Core\View::uploads($this->avatar, 'avatar');
		}

		if($this->auth == "facebook" && !empty($this->auth_id)){
			return "https://graph.facebook.com/".$this->auth_id."/picture?type=large";
		}else{
			return "https://www.gravatar.com/avatar/".md5(trim($this->email))."?s=64&d=identicon";		
		}	
	}
	/**
	 * Get User Plan
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function plan($limit = null){
			
		if(!isset(Gem::$App['userplan'])) {
			if($this->planid && $data = \Core\DB::plans()->where('id', $this->planid)->first()) {
				$plan = $data->asArray();
			} else {
				$plan = [];
			}
			Gem::$App['userplan'] = !config('pro') || $this->admin || is_null($this->planid) ? \Helpers\App::defaultPlan() : $plan;
		}

		if($limit) {
			return isset(Gem::$App['userplan'][$limit]) ? Gem::$App['userplan'][$limit] : false;
		}

		return Gem::$App['userplan'];
	}
	/**
	 * Check User Permission
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param [type] $permission
	 * @return boolean
	 */
	public function has($permission){	

		if(!config('pro')) return true;

		if(!$this->admin && !$this->planid) return false;

		$plan = $this->plan();	
		
		if(!$plan) return false;

		$plan["permission"] = json_decode($plan["permission"]);		

		if(isset($plan["permission"]->{$permission}) && $plan["permission"]->{$permission}->enabled){			
			return true;
		}
		return false;
	}
	/**
	 * Count User Permission
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param [type] $permission
	 * @return boolean
	 */	
	public function hasLimit($permission){

		if(!config('pro')) return 0;
		
		$plan = $this->plan();	

		if(!$plan) return false;
		
		$plan["permission"] = json_decode($plan["permission"]);	
		if(isset($plan["permission"]->{$permission}) && $plan["permission"]->{$permission}->enabled){		
			if(isset($plan["permission"]->{$permission}->count)){
				return $plan["permission"]->{$permission}->count;
			}
		}

		return false;
	}
	/**
	 * Check if user is in a team
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function team(){
		return $this->teamid ? true : false;
	}	
	/**
	 * View team permission
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param string $permission
	 * @return void
	 */
	public function teamPermission(string $permission){

		if(!$this->teamid) return true;
		
		if(empty($this->teampermission)) return true;	

		$permissions = json_decode($this->teampermission, true);

		if(in_array($permission, $permissions)) return true;

		return false;
	}		
	/**
	 * Get user pixels list
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function pixels(){
		$list = [];
		
		foreach(\Core\DB::pixels()->where('userid', $this->rId())->orderByDesc('type')->find() as $pixel){
			    
			$list[\Helpers\App::pixelName($pixel->type)][] = $pixel;
		}

		return $list;
	}
	/**
	 * Check if user is pro
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @return void
	 */
	public function pro(){
		
		if($this->admin || $this->pro) return true;

		return false;
	}
}