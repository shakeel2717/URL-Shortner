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
 * @package Core\View
 * @author GemPixel (http://gempixel.com)
 * @copyright 2018 KBRmedia
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */

namespace Core;

use Gem;
use Core\Helper;

final class View extends Gem {
	/**
	 * Meta Data | Title | Description | Keywords | Canonical URL | OG:Image | metaData | customMeta
	 * @var string
	 */
	public static $title;
	public static $description;
	public static $keywords;
	public static $url;
  public static $image;
  public static $bodyClass;
  public static $type;
  public static $path;
  private static $metaData;
	private static $customMeta;
  private static $elementBlock = NULL;
  private static $selfInstance = NULL;
  private static $injectedContent  = ["footer" => "", "header" => ""];
  private static $extendable = null;

  // Assets folder name
  const ASSET = "static";

  // Uploads folder name
  const UPLOADS = "content";

  /**
   * View Constructor
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   */
  public function __construct(){}
  /**
   * Static Instance
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
  public static function getInstance(){
    self::$selfInstance = self::$selfInstance ?: new self();
    return self::$selfInstance;
  }

	/**
	 * Generate meta title
	 * @author GemPixel <http://gempixel.com>
	 * @version 1.0
	 * @param   string $separator
	 * @return  string           
	 */
  public static function title($separator = "-"){      
    if(empty(self::$title)){
      return self::$Config->title;
    }else{
      return self::$title." $separator ".self::$Config->title;
    }
  }
  /**
  * Generate meta description
  * @param none
  * @return description
  * @since 1.0
  */
  public static function description(){      
    if(empty(self::$description)){
      return strip_tags(str_replace("'", "&apos;",self::$Config->description));
    }else{
      return strip_tags(str_replace("'", "&apos;",self::$description));
    }
  }
  /**
  * Generate meta keywords
  * @param none
  * @return keywords
  * @since 1.0
  */
  public static function keywords(){
    if(empty(self::$keywords)){
      return self::$Config->keywords;
    }else{
      return self::$keywords;
    }
  }    
  /**
  * Generate URL
  * @param none
  * @return description
  * @since 1.0
  */
  public static function url(){      
    if(empty(self::$url)){
      return self::$Config->url;
    }else{
      return self::$url;
    }
  } 
  /**
  * Set OGP Type
  * @param none
  * @return description
  * @since 1.0
  */
  public static function type(){      
    if(empty(self::$type)){
      return "website";
    }else{
      return self::$type;
    }
  }     
  /**
  * Body Class inject
  * @param none
  * @return message
  * @since 1.0
  */     
  public static function bodyClass($prefix = ""){
    if(!empty(self::$bodyClass)) return " class=\"$prefix".self::$bodyClass."\"";
  }    
  /**
  * Generate URL
  * @param none
  * @return description
  * @since 1.0
  */
  public static function image(){      
    return self::$image;
  }
  /**
  * Set meta info
  * @param none
  * @return Formatted array
  * @since 1.0
  */
  public static function set($meta,$value){
    if(!empty($value)){
      self::$$meta=$value;
    }
  }       
  /**
   * Generate Meta tags
   * @author GemPixel <http://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
  public static function meta(){
    // Meta title
    echo "<title>".self::title()."</title>\n\t";

    self::set('url', parent::currentRouteURL());

    // Meta Description
    echo '<meta name="description" content="'.self::description().'">'."\n\t";
    if(!empty(self::$keywords)) echo '<meta name="keywords" content="'.self::keywords().'">'."\n\t";

    echo "<meta property='og:locale' content='".\Core\Localization::get('region')."' />\n\t";      
    echo "<meta property='og:type' content='".self::type()."' />\n\t";      
    echo "<meta property='og:url' content='".self::url()."' />\n\t"; 
    echo "<meta property='og:title' content='".self::title()."' />\n\t";
    echo "<meta property='og:description' content='".self::description()."' />\n\t";  
    echo "<meta property='og:site_name' content='".self::title()."' />\n\t";  
    if(!empty(self::$image)) {
      echo "<meta property='og:image' content='".self::image()."' />\n\t"; 
    }

    if(self::type() == "article"){        
      echo "<meta property='article:publisher' content='http://facebook.com/gempixel' />\n\t";
      echo "<meta property='article:section' content='".ucfirst(self::$metaData["section"])."' />\n\t";
      echo "<meta property='article:published_time' content='".date(DATE_ATOM, strtotime(self::$metaData["date"]))."' />\n\t";
      echo "<meta property='article:modified_time' content='".date(DATE_ATOM, strtotime(self::$metaData["lastmod"]))."' />\n\t";
      echo "<meta property='og:updated_time' content='".date(DATE_ATOM, strtotime(self::$metaData["lastmod"]))."' />\n\t";
    }

    echo "<meta name='twitter:card' content='summary_large_image'>\n\t"; 
    echo "<meta name='twitter:site' content='@".str_replace("https://twitter.com/","",str_replace("http://www.twitter.com/", "", self::$Config->twitter))."'>\n\t"; 
    echo "<meta name='twitter:title' content='".self::title()."'>\n\t"; 
    echo "<meta name='twitter:description' content='".self::description()."'>\n\t"; 
    echo "<meta name='twitter:creator' content='@".str_replace("https://twitter.com/","",str_replace("https://www.twitter.com/", "", self::$Config->twitter))."'>\n\t"; 
    if(!empty(self::$image)) echo "<meta name='twitter:image' content='".self::image()."'>\n\t"; 
    echo "<meta name='twitter:domain' content='".str_replace("http://", "", self::$Config->url)."'>\n\t"; 

    if(self::$Config->favicon){
      if(Helper::extension(self::$Config->favicon) == "ico"){
        echo "<link rel=\"icon\" type=\"image/x-icon\" href=\"".uploads(self::$Config->favicon)."\" sizes=\"32x32\" />\n\t";
      }else{
        echo "<link rel=\"icon\" type=\"image/png\" href=\"".uploads(self::$Config->favicon)."\" sizes=\"32x32\" />\n\t";
      }
    }
    echo '<link rel="canonical" href="'.self::url().'">'."\n";   
    echo self::$customMeta;     
  }   
  /**
   * Static resource
   * @author GemPixel <http://gempixel.com>
   * @version 1.0
   * @param   [type] $file [description]
   * @return  [type]       [description]
   */
  public static function assets($file){        
    
    if(CDNASSETS) return CDNASSETS."/{$file}";

    return self::$Config->url."/".self::ASSET."/{$file}";
  }
  /**
   * Upload resource
   * @author GemPixel <http://gempixel.com>
   * @version 1.0
   * @param   [type] $file [description]
   * @return  [type]       [description]
   */
  public static function uploads($file, $storage = null){
    
    if(CDNUPLOADS) return CDNUPLOADS."/{$file}";

    if($storage) return self::storage($file, $storage, true);

    return self::$Config->url."/".self::UPLOADS."/{$file}";
  }   
  /**
   * Return Storage File
   *
   * @author GemPixel <https://gempixel.com> 
   * @version 6.0
   * @param [type] $name
   * @param [type] $file
   * @return void
   */
  public static function storage($file, $name, $url = false){
    $storage = appConfig('app.storage');   
    if(isset($storage[$name])) return $url ? $storage[$name]['link']."/{$file}" :  $storage[$name]['path']."/{$file}";
    return null;
  }
  /**
   * Compile JS and CSS. CSS will be automatically added to header and js to footer 
   * unless you set the 3rd param to true. In that case, the method will return the link
   * 
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   array $source     
   * @param   NULL  $destination
   * @param   bool  $linkonly
   */
  public static function compile(array $source, $destination = NULL, $linkonly = FALSE){

    $typesAllowed = ["css", "js"];

    if(!in_array(Helper::extension($destination), $typesAllowed)) {
      foreach ($source as $file) {
        if(Helper::extension($file) == "css") {
          self::push(self::assets($file), "style")->toHeader();
        }
        if(Helper::extension($file) == "js") {
          self::push(self::assets($file), "script")->tofooter();
        }   
      }
      return false;
    }
    
    $lastmod = 0;
    $dmod = strtotime("now");
    $content = "";

    foreach ($source as $file) {
      if(file_exists(PUB."/".self::ASSET."/".$file)){

        $mod = filemtime(PUB."/".self::ASSET."/".$file);        
        if($mod > $lastmod) $lastmod = $mod;

        $content .= file_get_contents(PUB."/".self::ASSET."/".$file);
      }            
    }
  
    if(file_exists(PUB."/".self::ASSET."/".$destination)){
      $dmod = filemtime(PUB."/".self::ASSET."/".$destination);
      if($lastmod > $dmod){
        self::createFile($content, PUB."/".self::ASSET."/".$destination);
      }
    } else {
      self::createFile($content, PUB."/".self::ASSET."/".$destination);
    }
    
    if($linkonly == true) return self::assets($destination);

    if(Helper::extension($destination) == "css") {
      self::push(self::assets($destination."?".$dmod), "style")->toHeader();
    }
    if(Helper::extension($destination."?".$dmod) == "js") {
      self::push(self::assets($destination), "script")->tofooter();
    }            
  }
  /**
   * Create a file
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $content     [description]
   * @param   [type] $destination [description]
   * @return  [type]              [description]
   */
  public static function createFile($content, $destination){
    if($file = fopen($destination, 'w')){      
      $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
      $content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);      
      $content .= "\n/* Compiled on ".date("d-m-Y H:i")." */";
      fwrite($file, $content);
      fclose($file);
    }else{
      throw new \Exception("The folder ".self::ASSET." is not readible.", 1);    
    }
  }
  /**
   * Template Header
   * @author GemPixel <http://gempixel.com>
   * @version 1.0
   */
  protected static function header($data = []){  

    self::template(__FUNCTION__, $data);
  }
  /**
   * Template Footer
   * @author GemPixel <http://gempixel.com>
   * @version 1.0
   */
  protected static function footer($data = []){ 

    self::template(__FUNCTION__, $data);
  }   
  /**
   * Get Template
   * @author GemPixel <http://gempixel.com>
   * @version 1.0
   * @param   string $template
   */
  protected static function template(string $template, $data = []){
    
    $template = str_replace(".", "/", strtolower($template));

    if(!file_exists(self::$path."/{$template}.php")) {
      throw new \Exception("The theme file {$template}.php is missing from the active theme folder.");
    }
    
    if($data && is_array($data)) extract($data, EXTR_SKIP);

    include(self::$path."/{$template}.php");
  }   
  /**
   * Render Template
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $name [description]
   * @param   array  $data [description]
   * @return  [type]       [description]
   */
  public static function render($name, array $data = []) {

    self::header($data);
    self::template($name, $data);
    self::footer($data);
  }
  /**
   * Render only template without header
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $name [description]
   * @param   array  $data [description]
   * @return  [type]       [description]
   */
  public static function dryRender($name, array $data = []){
    self::template($name, $data);
  }
  /**
   * Render Error Template
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   [type] $code [description]
   * @return  [type]       [description]
   */
  public static function error($code, $title = "Error", $description = NULL){
    http_response_code($code);
    
    View::set("title", $title);
    View::set("description", $description);

    self::template("errors/{$code}");
  }

  /**
   * Creates block to dynamically push data
   * @author GemPixel <http://gempixel.com>
   * @version 1.0
   * @param   string $type [description]
   * @return  [type]        [description]
   */
  public static function block(string $type = "header"){
    if($type == "footer"){  
      echo self::$injectedContent["footer"];
    
    }elseif($type == "header"){
      echo trim(self::$injectedContent["header"], "\t");
    
    }else{
      echo self::$injectedContent[$type];
    }  

  }  
  /**
   * Push to header
   * @author GemPixel <http://gempixel.com>
   * @version 1.0
   * @param   string  $content    [description]
   * @param   string  $type   [description]
   */
  public static function push($content, $type = "css"){
    if($type == "css"){
      // Create stylesheet element
      self::$elementBlock = '<link rel="stylesheet" type="text/css" href="'.$content.'">';

    }elseif($type == "custom"){
      // Create custom stylesheet
      self::$elementBlock = $content;

    }else{
      // Create script element
      self::$elementBlock = '<script type="text/javascript" src="'.$content.'"></script>';      
    }

    return self::getInstance();
  }  
  /**
   * Push to Header
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @return  [type] [description]
   */
  public function toHeader() {
    self::$injectedContent["header"] .= "\t".self::$elementBlock."\n";
  }
  /**
   * Push to Footer
   * @author GemPixel <http://gempixel.com>
   * @version 1.0
   * @param   [type] $url  [description]
   * @param   string $type [description]
   */ 
  public function toFooter() {
    self::$injectedContent["footer"] .= "\t".self::$elementBlock."\n";
  }   
  /**
   * Push to Custom Block
   * @author GemPixel <https://gempixel.com>
   * @version 1.0
   * @param   string $name [description]
   * @return  [type]       [description]
   */
  public function toBlock(string $name) {
    
    if(!isset(self::$injectedContent[$name])) self::$injectedContent[$name] = "";

    self::$injectedContent[$name] .= "\t".self::$elementBlock."\n"; 
  }

  /**
   * Extend Template
   *
   * @author GemPixel <https://gempixel.com> 
   * @version 1.0
   * @param [type] $template
   * @return void
   */
  public static function with($template, $parameters = []){
    self::$extendable = ['template' => $template, 'parameters' => $parameters];
    return self::getInstance();
  }

  /**
   * Attach to Layout
   *
   * @author GemPixel <https://gempixel.com> 
   * @version 1.0
   * @param [type] $layout
   * @return void
   */
  public function extend($layout, $parameters = []){
    return self::dryRender($layout, $parameters);
  }

  /**
   * Output extendable
   *
   * @author GemPixel <https://gempixel.com> 
   * @version 1.0
   * @return void
   */
  public static function content(){
    
    if(is_callable(self::$extendable['template'])){
      return self::$extendable['template']();
    }

    return self::dryRender(self::$extendable['template'], self::$extendable['parameters']);
  }
  /**
   * Theme Settings
   *
   * @author GemPixel <https://gempixel.com> 
   * @version 6.0
   * @param [type] $var
   * @return void
   */
  public static function config($var = null){
    
    if(!file_exists(self::$path.'/config.json')) return null;

    $config = json_decode(file_get_contents(self::$path.'/config.json'), true);

    if($var) {
      if(isset($config[$var])) return $config[$var];
      return false;
    }
    return $config;
  }
}