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
 * @package Functions 
 * @author GemPixel (http://gempixel.com) @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */
  
use Core\Helper;
use Core\View;

/**
 * Autoload Core files
 * @author GemPixel <https://gempixel.com>
 * @version 1.0
 * @param   [type] $class [description]
 * @return  [type]        [description]
 */
function autoloadCore($class){
  if(strpos($class, "\\")) {
    $data = explode("\\", $class);
    $namespace = strtolower($data[0]);
    $name = end($data);
  
    if(!in_array($namespace, ["core","models", "middleware", "helpers", "traits"])) return;
    
    if($namespace == "core"){
      $filename = ROOT."/".$namespace;
    } else {
      $filename = APP."/".$namespace; 
    }

    array_pop($data);    
    foreach ($data as $i => $file ) {
      if($i == 0) continue;
      $filename .= "/".strtolower($file);
    }

    $filename .= "/".$name;
    if($namespace == "core") $filename .= ".class";

    $filename .= ".php";

    if (is_readable($filename)) {
      require_once($filename);
    } 
  }
}
spl_autoload_register("autoloadCore");

/**
 * Autoload Controllers
 * @author GemPixel <https://gempixel.com>
 * @version 1.0
 * @param   [type] $class [description]
 * @return  [type]        [description]
 */
function autoloadController($class){
  
  if(strpos($class, "\\")) {
    $data = explode("\\", $class);
    $name = end($data);    
    $filename = CONTROLLER. "/";
    array_pop($data);
    foreach ($data as $namespace) {
      $filename .= strtolower($namespace)."/";
    }
    $filename .= $name."Controller.php";
  } else {
    $filename = CONTROLLER. "/" . $class . "Controller.php";
  }

  if (is_readable($filename)) {
    require_once($filename);
  }else{      

    if(appConfig('app.debug')) return GemError::trigger(500, "{$class} not loaded: File {$filename} not found");
    error_log("{$class} not loaded: File {$filename} not found");
    return GemError::trigger(500);

  }
}
spl_autoload_register("autoloadController");

/**
 * Custom Error Handler
 * @author GemPixel <http://gempixel.com>
 * @version 1.0
 * @param   string $errno  
 * @param   string $errstr 
 * @param   string $errfile
 * @param   string $errline
 */
function GemError($errno, $errstr, $errfile, $errline) {
  return GemError::exception($errno, $errstr, $errfile, $errline);
}  

set_error_handler("GemError", E_ALL);

/**
 * Capture Fatal Error
 * @author GemPixel <https://gempixel.com>
 * @version 1.0
 */
function FatalError() {
  $error = error_get_last();
  if(isset($error["message"])) return GemError::log($error["message"]);
}  
register_shutdown_function("FatalError");

/**
 * Parse JSON
 * @author GemPixel <https://gempixel.com>
 * @version 1.0
 * @param   string $string
 * @return  string        
 */
function parseIfJSON($string){

  if(is_null($string) || empty($string) || is_numeric($string)) return $string;

  $json = json_decode($string);

  return (json_last_error() == JSON_ERROR_NONE) ? $json : $string;
}
/**
 * Current Page
 * @author GemPixel <http://gempixel.com>
 * @version 1.0
 */
function currentPage(){
  // Get Page
  if(isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"]>0) {
   return Helper::clean($_GET["page"]);    
  }
  return "1";
}
/**
 * Clean String
 *
 * @author GemPixel <https://gempixel.com> 
 * @version 6.0
 * @param [type] $string
 * @return void
 */
function clean($string){
  return Helper::clean($string, 3);
}

/**
 * Get Configuration
 * @author GemPixel <https://gempixel.com>
 * @version 1.0
 * @param   string|null $config [description]
 * @return  [type]              [description]
 */
function config(?string $config = NULL){
  
  if(!class_exists('Gem')) return false;

  if($config) return isset(Gem::$Config->{$config}) ? Gem::$Config->{$config} : false;

  return Gem::$Config;
}
/**
 * Get App Config in /config
 * @author GemPixel <https://gempixel.com>
 * @version 1.0
 * @param   string $path [description]
 * @return  [type]       [description]
 */
function appConfig(string $path){

  $file = explode('.', $path);

  if(file_exists(APP.'/config/'.$file[0].'.php')){
    $config = include(APP.'/config/'.$file[0].'.php'); 
    if(isset($file[1]) && !empty($file[1]) && isset($config[$file[1]])) return $config[$file[1]];
    return $config;
  }
  return false;
}
/**
 * Return User
 *
 * @author GemPixel <https://gempixel.com> 
 * @version 1.0
 * @return void
 */
function user(){
  return \Core\Auth::user();
}

include('helpers.php');