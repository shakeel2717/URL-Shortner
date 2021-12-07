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
 * @package Gem\Error
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */

use Core\View;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class GemError {
	/**
	 * Enable Logger
	 * @var null
	 */
	private static $logger = NULL;

	/**
	 * [__construct description]
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 */
	public function __construct(){
	}
	/**
	 * Enable Logger
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public static function logger(string $path = ""){
		if(empty($path)) $path = appConfig('app.log');

		ob_start();

		self::$logger["system"] = new Logger("system");

		$format = new LineFormatter("[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n\n", null, true, true);		
		$handler = new StreamHandler($path."/Log-".date("m-d-Y").".log", Logger::ERROR);
		$handler->setFormatter($format);
		self::$logger["system"]->pushHandler($handler);
	}
	/**
	 * Log Error
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $error [description]
	 * @param   array  $data  [description]
	 * @param   string $type  [description]
	 * @return  [type]        [description]
	 */
	public static function log($error, $data = [], $channel = "system", $type = "error"){
		if($type == "error") error_log($error);
		if(empty($error)) return null;
		if(isset($_SERVER["REQUEST_URI"])){
			$error .= " -> http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
		}
		if(!isset(self::$logger[$channel]) && $channel == "system") self::logger();
		if(!isset(self::$logger[$channel])) self::channel($channel);
		self::$logger[$channel]->{$type}($error, $data);
	}	

	/**
	 * System error handler
	 * @author GemPixel <http://gempixel.com>
	 * @version 1.0
	 */
	public static function exception(int $code, string $message, string $file, int $line){
		$error = "$message occurred in $file:$line";		
		self::log($error);
		if(function_exists("xdebug_print_function_stack") && appConfig('app.debug')) {
			xdebug_print_function_stack($message);
		}
	}
	/**
	 * Fatal Error
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 */
	public static function fatal($message){
		self::log($message);
		if(!appConfig('app.debug')) return self::cleanError("Error 500", "An unexpected error occurred. We will be fixing this very soon.", 500);
	}
	/**
	 * Channel
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $name [description]
	 * @param   [type] $path [description]
	 * @return  [type]       [description]
	 */
	public static function channel($name, string $path = ""){
		if(empty($path)) $path = appConfig('app.log');

		if($name == "system") throw new \Exception("System channel is reserved. Cannot create a system logging channel.");

		self::$logger[$name] = new Logger($name);
		
		$format = new LineFormatter("[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n\n", null, true, true);		
		$handler = new StreamHandler($path."/{$name}.log", Logger::DEBUG);
		$handler->setFormatter($format);
		self::$logger[$name]->pushHandler($handler);		
	}
	/**
	 * Log to channel
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $name  [description]
	 * @param   [type] $error [description]
	 * @param   array  $data  [description]
	 * @param   string $type  [description]
	 * @return  [type]        [description]
	 */
	public static function toChannel($name, $error, $data = [], $type = "info"){
		return self::log($error, $data, $name, $type);
	}
	/**
	 * Custom Error
	 * @author GemPixel <http://gempixel.com>
	 * @version 1.0
	 */
	public static function trigger($code, $error = "", $uri = null){

		http_response_code($code);

		// if($uri && strpos($uri, appConfig('app.app.apiroute')) !== false){
		// 	die(json_encode(['error' => 1, 'message' => 'Unknown endpoint or http request method.']));
		// }

		if(file_exists(View::$path."/errors/{$code}.php")){
			if($code != '404') self::log($error);
			return View::error($code);
		}

		if(appConfig('app.debug') > 0) return self::template($code, $error);

		return self::cleanError("Error $code", "The page you are looking for is not available.", $code);
	}
	/**
	 * Error Template
	 * @author GemPixel <http://gempixel.com>
	 * @version 1.0
	 */
	public static function template($title, $error){
		if(!appConfig('app.debug')){
			return print("<h1>An unexpected error occurred</h1><p>We are aware of the error and are working to fixing this asap. If you are missing something, please contact us.</p>");
		}
		$e = new \Exception;
		$log = $e->getTraceAsString();
		self::log($error."\n".$log);
		error_log($error."\n".$log);
		ob_end_clean();

		echo '<!DOCTYPE html>
				<html lang="en">
				<head>
				    <meta charset="utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta name="viewport" content="width=device-width, initial-scale=1" />
				    <title>'.$title.'</title>
				    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro&display=swap" rel="stylesheet">
				    <style type="text/css">html{font-family:sans-serif;line-height:1.15;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}body,html{width:100%;height:100%;background-color:#f3f3f3}body{color:#02061A;text-align:center;padding:0;min-height:100%;display:table;font-family: \'Source Code Pro\', monospace;}h1{font-family:inherit;font-weight:700;line-height:1.1;color:inherit;font-size:36px}h1 small{font-weight:700;line-height:1;color:#FF037A}a{text-decoration:none;color:#9c9898;font-size:inherit;border-bottom:dotted 1px #707070}.lead{color:silver;font-size:21px;line-height:1.8;}.cover{display:table-cell;vertical-align:middle;padding:0 20px;font-weight:700}footer{position:fixed;width:100%;height:40px;left:0;bottom:0;color:#a0a0a0;font-size:14px}a.contact{position: absolute;right: 10px;bottom: 10px;color: #9c9898;text-decoration: none;border: 0;font-weight: 700;font-size: 13px;}table{margin:0 auto}ul{list-style: none;background: #fff;border: 1px solid #ff097a;max-width: 800px;margin: 0 auto;width: 100%;text-align: left;padding: 10px;border-radius: 8px;}ul li {margin-bottom: 15px;}</style>
				</head>
				<body>
    			<div class="cover"><h1><small>>_</small> '.$title.'</h1>';
				
		if(function_exists("xdebug_print_function_stack")) {
			xdebug_print_function_stack($error);
		} else{
			$logs = explode("\n", $log);

			echo '<ul>';
				foreach($logs as $log){;
					echo '<li>'.str_replace('): ', "):<br>", $log).'</li>';
				}
			echo '</ul>';
		}

		echo '</div></body>
				</html>';
		exit;
	}
	/**
	 *  formattedTemplate description]
	 * @author GemPixel <http://gempixel.com>
	 * @version 1.0
	 * @param   [type] $title [description]
	 * @param   [type] $error [description]
	 */
	public static function cleanError($title, $error, $code){

		die('<!DOCTYPE html>
				<html lang="en">
				<head>
				    <meta charset="utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta name="viewport" content="width=device-width, initial-scale=1" />
				    <title>'.$title.'</title>
				    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro&display=swap" rel="stylesheet">
				    <style type="text/css">html{font-family:sans-serif;line-height:1.15;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}body,html{width:100%;height:100%;background-color:#f3f3f3}body{color:#02061A;text-align:center;padding:0;min-height:100%;display:table;font-family: \'Source Code Pro\', monospace;}h1{font-family:inherit;font-weight:700;line-height:1.1;color:inherit;font-size:36px}h1 small{font-weight:700;line-height:1;color:#FF037A}a{text-decoration:none;color:#9c9898;font-size:inherit;border-bottom:dotted 1px #707070}.lead{color:silver;font-size:21px;line-height:1.8;}.cover{display:table-cell;vertical-align:middle;padding:0 20px;font-weight:700}footer{position:fixed;width:100%;height:40px;left:0;bottom:0;color:#a0a0a0;font-size:14px}a.contact{position: absolute;right: 10px;bottom: 10px;color: #9c9898;text-decoration: none;border: 0;font-weight: 700;font-size: 13px;}</style>
				</head>
				<body>
    			<div class="cover"><h1><small>>_</small> '.$title.'</h1><p class="lead">'.$error.'</p></div>		    
    			<a href="/contact" class="contact">Contact us</a>
				</body>
				</html>');
	}	
}