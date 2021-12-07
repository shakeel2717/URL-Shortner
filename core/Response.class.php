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
 * @package Core\Response
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */
namespace Core;

use Core\Helper;

final class Response {

	/**
	 * Headers variable
	 * @var array
	 */
	private $headers = [];

	/**
	 * Content Body
	 * @var null
	 */
	private $body = NULL;

	/**
	 * Response Type
	 * @var null
	 */
	private $type = NULL;

	/**
	 * Actionnable content types
	 * @var array
	 */
	private $actionnableTypes = ["application/json", "application/javascript"];

	/**
	 * Set Charset
	 * @var string
	 */
	private static $charset = "utf-8";

	/**
	 * Response Constructor
	 * 
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   mixed     $response
	 * @param   int|integer $code    
	 * @param   array       $headers 
	 */
	public function __construct($response = null, int $code = 200, array $headers = []){

		$this->setHeaders($headers)
				->setStatusCode($code)
				->setBody($response);
		return $this;
	}
	/**
	 * Call Statically
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param [type] $response
	 * @param integer $code
	 * @param array $headers
	 * @return void
	 */
	public static function factory($response = null, int $code = 200, array $headers = []){
		return new self($response, $code, $headers);
	}
	/**
	 * Print Results
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  string [description]
	 */
	public function send(){

		if(is_array($this->body)){
			
			print_r($this->body);

		} elseif (is_object($this->body)){
			
			print(json_encode($this->body));

		} else {

			print($this->body);

		}	
	}
	/**
	 * Set Headers 
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   array $headers
	 */
	private function setHeaders(array $headers){

		foreach ($headers as $name => $value) {
			
			if(empty($name) && empty($value)) continue;

			$name = Helper::clean($name);

			if(strtolower($name) == "content-type" && in_array($value, $this->actionnableTypes)) $this->type = "json";						

			header("{$name}:{$value}");
		}

		return $this;
	}
	/**
	 * [json description]
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function json(){
		header("Content-Type: application/json");
		return print(json_encode($this->body));
	}

	/**
	 * Set Single Header
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   array $header
	 */
	public function setHeader(array $header){
		
		[$name, $value] = $header;
		
		$name = Helper::clean($name);

		header("{$name}:{$value}");

		return $this;
	}

	/**
	 * Set Charset
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   string $charset
	 */
	public static function setCharset(string $charset) {
    
		self::$charset = trim($charset);

	}	
	/**
	 * Set Status Code
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   int $code
	 */
	public function setStatusCode(int $code){

		if($code < 100 || $code > 511) $code = 200;

		http_response_code($code);

		return $this;

	}
	/**
	 * Set Response
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $response
	 */
	public function setBody($response){

		$this->body = $response;

		if($this->type == "json"){		
			$this->body = json_encode($this->body);
		} 

		return $this;
	}
	/**
	 * Convert to array
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $data [description]
	 * @return  [type]       [description]
	 */
	public static function toArray($data){
		$newData = [];
		foreach ($data as $object) {
			$newData[] = $object->asArray();
		}
		return $newData;
	}
}