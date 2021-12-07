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
  * Generate url
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   [type] $path [description]
  * @return  [type]       [description]
  */
if(!function_exists('url')){
  function url($path = NULL){
	  return Gem::$Config->url."/".$path;
  }
}
  
/**
  * Generate a link from route
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   string $name 
  * @param   string $param
  */
if(!function_exists('route')){
  function route($name, $param = NULL){
	  return Gem::href($name, $param);
  }
}
/**
  * Shorthand to Helper::CSRF()
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  */
if(!function_exists('csrf')){
  function csrf(){
	  return Helper::CSRF();
  }
}
/**
  * Shorthand to Helper::CSRF(false)
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  */
if(!function_exists('csrf_token')){
  function csrf_token(){
	  return Helper::CSRF(false);
  }
}
/**
  * Shorthand to View::meta()
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  */
if(!function_exists('meta')){
  function meta(){
	  return View::meta();
  }
}
/**
  * Shorthand to View::block()
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   string $type
  */
if(!function_exists('block')){
  function block(string $type){
	  return View::block($type);
  }
}
/**
  * Push content to blocks
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   string $content
  * @param   string $type        
  */
if(!function_exists('push')){
  function push(string $content, string $type = "style"){
	  return View::push($content, $type);
  }
}
/**
  * Shorthand to render
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   string $name
  * @param   array  $data
  */
if(!function_exists('render')){
  function render(string $name, array $data = []){
	  return View::render($name, $data);
  }
}
/**
  * DryRender
  *
  * @author GemPixel <https://gempixel.com> 
  * @version 6.0
  * @param string $name
  * @param array $data
  * @return void
  */
if(!function_exists('view')){
  function view(string $name, array $data = []){
	  return View::dryRender($name, $data);
  }
}
/**
  * View Extended Content
  *
  * @author GemPixel <https://gempixel.com> 
  * @version 6.0
  * @return void
  */
if(!function_exists('section')){
  function section(){
	  return View::content();
  }
}
/**
  * Return Body Class
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @return  [type] [description]
  */
if(!function_exists('bodyClass')){
  function bodyClass(){
	  echo View::bodyClass();
  }
}
/**
  * Assets shorthand
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   [type] $name [description]
  * @return  [type]       [description]
  */
if(!function_exists('assets')){
  function assets($name){
	  return View::assets($name);
  }
}
/**
  * Uploads shorthand
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   [type] $name [description]
  * @return  [type]       [description]
  */
if(!function_exists('uploads')){
  function uploads($name, $storage = null){
	  return View::uploads($name, $storage);
  }
}
/**
 * Redirect back
 *
 * @author GemPixel <https://gempixel.com> 
 * @version 6.0
 * @return void
 */
if(!function_exists('back')){
  function back(){
	return Helper::redirect()->back();
  }
}
/**
  * Plugin
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   [type] $name [description]
  * @return  [type]       [description]
  */
if(!function_exists('plug')){
  function plug($name){
	  return \Core\Plugin::dispatch($name);
  }
}
/**
  * Return timeago
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   [type] $time [description]
  * @return  [type]       [description]
  */
if(!function_exists('timeago')){
  function timeago($time){
	  return Helper::timeago($time);
  }
}
/**
  * Full Pagination
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   string $class [description]
  * @return  [type]        [description]
  */
if(!function_exists('pagination')){
  function pagination($class = "pager", $liclass = null, $aclass = null){
	  return Helper::pagination($class, $liclass, $aclass);
  }
}
/**
  * Return Simple Pagination
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @return  [type] [description]
  */
if(!function_exists('simplePagination')){
  function simplePagination($class = "pager", $liclass = null, $aclass = null){
	  return Helper::simplePagination($class, $liclass, $aclass);
  }
}
/**
  * Stop Execution
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   int    $code [description]
  * @return  [type]       [description]
  */
if(!function_exists('stop')){
  function stop(int $code, $text = "Page not found"){
	  GemError::trigger($code, $text);
	  exit;
  }
}
/**
  * Activate Middleware
  * @author GemPixel <https://gempixel.com>
  * @version 1.0
  * @param   [type] $middleware [description]
  * @return  [type]             [description]
  */
if(!function_exists('middleware')){
  function middleware($middleware){  
	  return Gem::addMiddleware($middleware);
  }
}
/**
  * Return message
  *
  * @author GemPixel <https://gempixel.com> 
  * @version 6.0
  * @return void
  */
if(!function_exists('message')){
  function message(){
	  echo Helper::message();
  }
}
/**
  * Translation text
  * @author GemPixel <http://gempixel.com>
  * @version 1.0
  * @param   string $string
  */
if(!function_exists('e')){
  function e($string, $count = null, $variables = []){
	  return \Core\Localization::translate($string, $count, $variables);
  }
}
/**
  * Echo e()
  *
  * @author GemPixel <https://gempixel.com> 
  * @version 1.0
  * @param [type] $string
  * @param [type] $count
  * @param array $variables
  * @return void
  */
if(!function_exists('ee')){
  function ee($string, $count = null, $variables = []){
	  echo e($string, $count, $variables);
  }
}
/**
 * Request Helper
 *
 * @author GemPixel <https://gempixel.com> 
 * @version 6.0
 * @return void
 */
if(!function_exists('request')){
  function request(){
	  return new \Core\Request;
  }
}
/**
  * Get Session
  *
  * @author GemPixel <https://gempixel.com> 
  * @version 1.0
  * @return void
  */
if(!function_exists('old')){
  function old($name){
	return (new \Core\Request)->session('TEMP_'.$name);
  }
}
/**
 * Custom var Dump
 *
 * @author GemPixel <https://gempixel.com> 
 * @version 6.0
 * @return void
 */
if(!function_exists('gvd')){
  function gvd(){
	var_dump(...func_get_args());
	exit;
  }
}

/**
 * IDN to UTF8
 */
if(!function_exists('idn_to_utf8')){
  function idn_to_utf8($string){
	  return $string;
  }
}
/**
 * IDN to ASCii
 */
if(!function_exists('idn_to_ascii')){
  function idn_to_ascii($string){
	  return $string;
  }
}
/**
 * Shortcut to plugin
 */
if(!function_exists('plugin')){
  function plugin($string){
  }
}
/**
 * Add to admin menu
 */
if(!function_exists('adminmenu')){
  function adminmenu(array $link){
	  return '<li class="sidebar-item"><a class="sidebar-link" href="'.$link['route'].'">'.$link['title'].'</a></li>';
  }
}
/**
 * Append Query
 *
 * @author GemPixel <https://gempixel.com> 
 * @version 6.0
 * @param array $query
 * @return void
 */
if(!function_exists('appendquery')){
  function appendquery(array $query){
	return http_build_query((request()->query() ?? []) + $query);
  }
}