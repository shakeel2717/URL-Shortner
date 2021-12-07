<?php 
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a 
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  sofware and contact gempixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package Gem\Core\Auth
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */
namespace Core;

use Gem;
use Core\Helper;
use Core\Request;
use Models\User;

final class Auth extends Gem {
	/**
	 * Current session data
	 * @var null
	 */
	private static $currentSession = NULL;
	/**
	 * Current user data
	 * @var null
	 */
	private static $user = NULL;
  /**
   * Cookie name
   * @var string
   */
  const COOKIE = "logged_in";
	/**
	 * __construct
	 * @author GemPixel <http://gempixel.com>
	 * @version 1.0
	 */
	public function __construct(){				
		parent::__construct();
	}
	/**
	 * Read user cookie and extract user info
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
  public static function session(){

    $request = new Request();

    // Fetch data from cookie or session
    if($cookie = $request->cookie(self::COOKIE)){
      $data = json_decode(Helper::decrypt($cookie));
    }
    if($session = $request->session(self::COOKIE)){
      $data = json_decode(Helper::decrypt($session));     
    }
    
    // Return it
    if(isset($data->loggedin) && !empty($data->key)){      	 
      return self::$currentSession = [Helper::clean(substr($data->key,60)), Helper::clean(substr($data->key,0,60))]; 
    }     
    return false;  
  } 

  /**
   * Login user
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
  public static function check(){
  	if(self::session()) {
  		if(self::$user = User::where(['id' => self::$currentSession[0], User::AUTHKEY => self::$currentSession[1]])->first()){
  			return true;
  		}
  	}
  	return false;
  }
  /**
   * Current User
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
  public static function user(){
    return self::$user;
  }
  /**
   * Return User ID
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   */
  public static function id():int {
    return self::$user->id;
  }
  /**
   * Login User
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   string|null $username   [description]
   * @param   string|null $password   [description]
   * @param   int|integer $rememberme [description]
   * @return  [type]                  [description]
   */
  public static function login(string $username, string $password, int $rememberme = 0) {

    $request = new Request();

    if($user = User::where('email', $username)->first()){

      if(!Helper::validatePass($password, $user->password)) throw new \Exception(e("Wrong email and password combination."));

      session_regenerate_id();

      $newAuthKey = Helper::Encode($user->email.$user->id.uniqid().rand(0, 99999));

      $user->authkey = $newAuthKey;
      $user->save();

      // Set Session
      $data = Helper::encrypt(json_encode(["loggedin" => true, "key" => $newAuthKey.$user->id]));
      
      if($rememberme){
        // Set Cookie for 14 days
        $request->cookie(Auth::COOKIE, $data, 14*24*60);
      }else{
        $request->session(Auth::COOKIE, $data);
      }
      return true;
    }
    throw new \Exception(e("This user does not exist."));
  }
  /**
   * Login using ID
   *
   * @author GemPixel <https://gempixel.com> 
   * @version 6.0
   * @param integer $id
   * @return void
   */
  public static function loginId(int $id){
    
    if($user = User::where('id', $id)->first()){

      session_regenerate_id();
      // Set Session
      $data = Helper::encrypt(json_encode(["loggedin" => true, "key" => $user->auth_key.$user->id]));
      request() ->session(Auth::COOKIE, $data);

      return true;
      
    }

    return false;
  }
  /**
   * Auth user via API
   * @author GemPixel <https://gempixel.com> 
   * @version 6.0
   * @param string|null $key
   * @return void
   */
  public static function ApiUser(?string $key = null){

    if(!self::$user){
      if(!$user = User::where('api', clean($key))->first()){
        return false;
      }
      self::$user = $user;
    }
    return self::$user;
  }
  /**
   * Validate Login
   *
   * @author GemPixel <https://gempixel.com> 
   * @version 1.0
   * @param string $username
   * @param string $password
   * @return void
   */
  public static function validate(string $username, string $password){
    if($user = User::where('email', $username)->first()){
      if(!Helper::validatePass($password, $user->password)) throw new \Exception(e("Wrong email and password combination."));
      return true;
    }
    throw new \Exception(e("This user does not exist."));
  }
  /**
   * Log User Level
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $role [description]
   * @return  [type]        [description]
   */
  public static function logged($role = null){

    if(!Auth::check()) return false;

    if($role && method_exists(__CLASS__, $role)) return self::$role();

    if(isset(self::$user->role) && self::$user->role == $role) return true;

    return true;
  }  
  /**
   * Redirect after login
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $path [description]
   * @return  [type]       [description]
   */
  public function redirect($path = null, $message = []){
    if($path) return Helper::redirect($path, $message);
    return Helper::back($message);
  }

  /**
   * [logout description]
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
  public static function logout(){
    unset($_SESSION[Auth::COOKIE]);
    setcookie(Auth::COOKIE, NULL, -3600, "/", "", false, true);
    return true;
  }
}