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
 * @package Gem\Core\Http
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 * @example Http::url("http://site.com")->withHeaders(["authorization" => "Token 123456"])->post();
 */
namespace Core;

use Core\Helper;
use GemError;

final class Http {
	/**
	 * URL to send request
	 * @var null
	 */
	private $_HTTPURL = NULL;
	/**
	 * CURL Response
	 * @var array
	 */
	private $_HTTPCURLRESPONSE = [];
	/**
	 * CURL Parameters
	 * @var array
	 */
	private $_HTTPCURLPARAMS = [];

	/**
	 * CURL SSL
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 */
	private $_HTTPCURLSSL = true;
	/**
	 * Build Http Request
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   string|null $url [description]
	 */
	public function __construct(?string $url = null){
		$this->_HTTPURL = $url;
		$this->_HTTPCURLPARAMS = [];
		$this->_HTTPCURLRESPONSE = [];		
		return $this;
	}
	/**
	 * Return Body
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  string [description]
	 */
	public function __toString(){
		return $this->getBody();
	}
	/**
	 * Call Statistically
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   string|null $url [description]
	 * @return  [type]           [description]
	 */
	public static function url(?string $url = null){
		return new self($url);
	}
	/**
	 * Get Request Body
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function getBody(){
		if(isset($this->_HTTPCURLRESPONSE["curlbody"]) && !empty($this->_HTTPCURLRESPONSE["curlbody"])) return $this->_HTTPCURLRESPONSE["curlbody"];
		return false;
	}
  /**
   * Get Body as Object
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
  public function bodyObject(){
    if(isset($this->_HTTPCURLRESPONSE["curlbody"]) && !empty($this->_HTTPCURLRESPONSE["curlbody"])) return json_decode($this->_HTTPCURLRESPONSE["curlbody"]);
    return false;    
  }
	/**
	 * Get HTTP Code
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 */
	public function httpCode($code = NULL){
		if(isset($this->_HTTPCURLRESPONSE["http_code"]) && !empty($this->_HTTPCURLRESPONSE["http_code"])) return (int) $this->_HTTPCURLRESPONSE["http_code"];
		return false;
	}	
  /**
   * Set Headers
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $name   [description]
   * @param   [type] $content [description]   
   */
  public function with($name, $content){

  	$this->_HTTPCURLPARAMS["headers"][ucwords($name, "-")] = $content;
  	return $this;
  }
  /**
   * Set headers with Array
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   array  $headers [description]
   * @return  [type]          [description]
   */
  public function withHeaders(array $headers){
  	foreach ($headers as $name => $content) {
  		$this->_HTTPCURLPARAMS["headers"][ucwords($name, "-")] = $content;
  	}
  	return $this;
  }
 /**
   * Request Auth
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $username [description]
   * @param   [type] $password [description]
   * @return  [type]           [description]
   */
  public function auth($username, $password){
		$this->_HTTPCURLPARAMS["auth"] = "{$username}:{$password}";
		return $this;
  }
  /**
   * Request Body
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $content [description]
   */
  public function body($content){

  	if(isset($this->_HTTPCURLPARAMS["headers"]["Content-Type"]) && $this->_HTTPCURLPARAMS["headers"]["Content-Type"] == "application/json"){
  		$content = json_encode($content);
  	}

  	$this->_HTTPCURLPARAMS["body"] = $content;
  	return $this;
  }
  /**
   * Send a get request
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   array  $options [description]
   * @return  [type]          [description]
   */
  public function get($options = []){

		if(isset($this->_HTTPCURLPARAMS["body"]) && !empty($this->_HTTPCURLPARAMS["body"])){
			
			$this->_HTTPURL .= strpos($this->_HTTPURL, "?") ? "&" : "?";

			if(is_array($this->_HTTPCURLPARAMS["body"])){
				$this->_HTTPURL .= http_build_query($this->_HTTPCURLPARAMS["body"]);
			} else{
				$this->_HTTPURL .= $this->_HTTPCURLPARAMS["body"];
			}
		}

		$curl = curl_init($this->_HTTPURL);

		if(defined('DEBUG') && DEBUG || $this->_HTTPCURLSSL == false) curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		if(isset($this->_HTTPCURLPARAMS["headers"])){
			$headers = [];
			foreach ($this->_HTTPCURLPARAMS["headers"] as $name => $value) {
				$headers[] = "{$name}:{$value}";
			}
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		}

		if(isset($this->_HTTPCURLPARAMS["auth"]) && !empty($this->_HTTPCURLPARAMS["auth"])){
			curl_setopt($curl, CURLOPT_USERPWD, $this->_HTTPCURLPARAMS["auth"]);  
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		
		$response = curl_exec($curl);

		$this->_HTTPCURLRESPONSE = curl_getinfo($curl);
		$this->_HTTPCURLRESPONSE["curlbody"] = $response;

		if($error = curl_error($curl)){
			GemError::log($error);
		}

		curl_close($curl);
		return $this;
  }
	/**
   * Send a POST request
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   array  $options [description]
   * @return  [type]          [description]
   */
  public function post($options = []){    	
		$curl = curl_init($this->_HTTPURL);

		if(defined('DEBUG') && DEBUG || $this->_HTTPCURLSSL == false) curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		if(isset($options["method"]) && in_array($options["method"], ["put", "patch", "delete"])){
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($options["method"]));
		}

		if(isset($this->_HTTPCURLPARAMS["headers"])){
			$headers = [];
			foreach ($this->_HTTPCURLPARAMS["headers"] as $name => $value) {
				$headers[] = "{$name}:{$value}";
			}
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		}

		if(isset($this->_HTTPCURLPARAMS["auth"]) && !empty($this->_HTTPCURLPARAMS["auth"])){
			curl_setopt($curl, CURLOPT_USERPWD, $this->_HTTPCURLPARAMS["auth"]);  
		}
			
		curl_setopt($curl, CURLOPT_POST, 1);

		if(isset($this->_HTTPCURLPARAMS["body"]) && !empty($this->_HTTPCURLPARAMS["body"])){  		
			if(is_array($this->_HTTPCURLPARAMS["body"])){
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->_HTTPCURLPARAMS["body"]));
			} else{
				curl_setopt($curl, CURLOPT_POSTFIELDS, $this->_HTTPCURLPARAMS["body"]);
			}
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		
		$response = curl_exec($curl);

		$this->_HTTPCURLRESPONSE = curl_getinfo($curl);
		$this->_HTTPCURLRESPONSE["curlbody"] = $response;

		if($error = curl_error($curl)){
			GemError::log($error);
		}

		curl_close($curl);
		return $this;
  }  
  /**
   * Delete Request
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   array  $options [description]
   * @return  [type]          [description]
   */
  public function delete($options = []){
  	return $this->post(["method" => "delete"]);
  }  
  /**
   * Put Request
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   array  $options [description]
   * @return  [type]          [description]
   */
	public function put($options = []){
  	return $this->post(["method" => "put"]);
  }  
  /**
   * Patch Request
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   array  $options [description]
   * @return  [type]          [description]
   */
	public function patch($options = []){
  	return $this->post(["method" => "patch"]);
  }  
  /**
   * Request Response
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
  public function response(?string $name = null){
  	if(!is_null($name)) return isset($this->_HTTPCURLRESPONSE[$name]) ? $this->_HTTPCURLRESPONSE[$name] : null;
  	return $this->_HTTPCURLRESPONSE;
  }
}  