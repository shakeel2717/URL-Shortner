<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this sofware and contact gempixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com)
 * @copyright 2020 GemPixel
 * @license https://gempixel.com/license
 * @link https://gempixel.com  
 */
use Core\DB;
use Core\Email;
use Core\Helper;
use Core\Request;
use Core\Response;
use Core\View;
use Core\Localization;

class Gem {	
    /**
     * Route Separator
     */
    const SEPARATOR  =  "@";
    /**
     * Controllers Array
     * @var array
     */
    static private $controllers = [];
    /**
     * Routing data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    static private $routing = [];

    // Base URL
    static private $Base = "";

    // Route name
    static private $Name = "";

    // Middlewares
    static private $Middleware 	= "";

    // Router Prefix
    static private $routePrefix = "";

    // Configuration
    public static $Config = [];
    
    // Variable Reserved to the app
    public static $App = [];

    // Route Dispatcher
    static protected $dispatcher = null;	
    
    // Static Instance of Class
    static protected $Instance 	= null;

    // Config
    protected $config = [];

    /**
     * __construct
     * @author GemPixel <http://gempixel.com>
     * @version 1.0
     */
    public function __construct(){
        $this->config = self::$Config;
    }
    /**
     * [getInstance description]
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @return  Gem
     */
    public static function getInstance(){		
        if(is_null(self::$Instance)) {
            self::$Instance = new self();
        }	

        return self::$Instance;
    }
    /**
     * Start Application
     * @author GemPixel <http://gempixel.com>
     * @version 1.0
     */
    public static function preload(){
        // Start Session
        session_start();

        foreach(appConfig('boot') as $boot){
            if( call_user_func($boot) === false) exit;
        }       
    }
    /**
     * Bootstrap Routes
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     */
    public static function Bootstrap(){
                
        // Boot Database
        DB::Connect();

        // Connect to database & get settings
        self::$Config = \Models\Settings::getSettings();

        if(BASEPATH == "AUTO"){
            self::$Base   = self::basePath();
        } else {
            self::$Base   = BASEPATH;				
        }

        GemError::logger(LOGS);

        Helper::cacheConfig(appConfig('app.cachepath'));

        if(FORCEURL == false) {			
            self::$Config->url = (new Request())->host().rtrim(self::$Base, "/");
        }		

        Helper::set("config", self::$Config);

        View::set('path', STORAGE."/themes/".self::$Config->theme);
        
        Localization::bootstrap();

        \Core\Plugin::preload();

        self::$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            foreach (self::$controllers as $name => $data) {
                $data["handler"] = ['controller' => $data["handler"], 'name' => $data["name"]];
                if(isset($data["middleware"]) && !is_callable($data["handler"])) $data["handler"]['middleware'] = $data["middleware"];
                try{
                    
                    $r->addRoute($data["method"], $data["path"], $data["handler"]);

                } catch(FastRoute\BadRouteException $e){                

                    GemError::log($e->getMessage());
                    continue;

                } catch(\Exception $e){

                    return GemError::trigger(500, $e->getMessage());
                    
                }
            }
        });

        self::Dispatch();
    }

    /**
     * Dispatch manager
     * @author GemPixel <http://gempixel.com>
     * @version 1.0
     */
     public static function Dispatch(){			

        $request = new Request();

        // self::setBase();		

        $method = $request->server("REQUEST_METHOD");

        $uri = preg_replace("#".self::$Base."#", "", trim($request->server("REQUEST_URI")), 1);

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rtrim(rawurldecode($uri), "/");

        self::$routing = self::$dispatcher->dispatch($method, $uri);

        $code = self::$routing[0];

        if($code == FastRoute\Dispatcher::NOT_FOUND)  return GemError::trigger(404, "Page not found: ".$uri);

        if($code == FastRoute\Dispatcher::METHOD_NOT_ALLOWED) return GemError::trigger(405, "Method not allowed", $uri);

        if($code == FastRoute\Dispatcher::FOUND) {

            [$code, $handler, $variables] = self::$routing;        

            $variables = array_map("\Core\Helper::RequestClean", $variables);
            $request->_HTTPPARAMETERS = (object) $variables;
                       
            $controller = $handler['controller'] ?? $handler;

            if(is_array($handler) && isset($handler['middleware'])){

                $pieces = $handler['middleware'];            

                foreach ($pieces as $middleware) {
                    
                    if(strpos($middleware, self::SEPARATOR)) {
                        [$middlewareClass, $middlewareMethod] = explode(self::SEPARATOR, $middleware);
                    } else {
                        $middlewareClass = $middleware;
                    }

                    if(file_exists(MIDDLEWARE."/{$middlewareClass}.php")){
                        $middlewareClassName = "\Middleware\\{$middlewareClass}";
                        if(isset($middlewareMethod)) {
                            if((new $middlewareClassName())->{$middlewareMethod}($request) === false) return false;
                        } else {
                            if((new $middlewareClassName())->handle($request) === false) return false;
                        }
                        unset($middlewareClass, $middlewareMethod);
                    }	 
                } 			
            }

            if($controller instanceof Closure){
                return $controller();
            }

            [$class, $method] = explode(self::SEPARATOR, $controller);

            $thisController = new $class();

            if(!method_exists($thisController, $method)){
                // Trigger error
                return GemError::trigger(404, "404 Not Found");
            }


            // Detect Type Hint and Instantiate the Class
            $reflector = new ReflectionMethod($thisController, $method);
            $varlist = [];
            if($reflectorParameters = $reflector->getParameters()){
                foreach($reflectorParameters as $reflectorParameter){
                    $reflectionClass = $reflectorParameter->getType();
                    if($reflectionClass && $reflectionClass->isBuiltin() === false) {	
                        if(phpversion() < 8.0){
                            $reflectionClass = $reflectionClass->getName();
                        }
                        if( $reflectionClass == "Core\Request") {
                            $varlist[] = $request;
                        } else {
                            $varlist[] = new $reflectionClass();
                        }

                    }
                }
            }
            $varlist += $variables;

            // Call method and send variables
            try{			

                return call_user_func_array([$thisController, $method], array_values($varlist));					

            } catch (ArgumentCountError | TypeError $e){		
            
                return GemError::trigger(500, $e->getMessage()); 

            }  catch (Exception $e) {

                return GemError::trigger(500, $e->getMessage());

            }	
        }

      return GemError::trigger(500, "Internal Server Error");
    }
    /**
     * Group Routing
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param   string   $prefix     Prefix name
     * @param   callable $function 	 Callback function
     */
    public static function group(string $prefix, callable $function){		
        
        self::$routePrefix = $prefix;
        
        $function();

        self::$Middleware 	= NULL;
        self::$routePrefix 	= NULL;
    }

    /**
    * Object URI Generator
    * @author GemPixel <https://gempixel.com>
    * @version 1.0
    */
     public static function route(array $method, string $path, $handler, $name = NULL){
        self::$Name = $name ?: self::$routePrefix.$path;

        self::$controllers[self::$Name] = ["method" => $method, "path" => rtrim(self::$routePrefix.$path, "/"), "handler" => $handler, "name" => self::$Name];

        if(self::$Middleware && !is_null(self::$Middleware)) self::$controllers[self::$Name]["middleware"] = self::$Middleware;

        return self::getInstance();
    }	
    /**
     * Append GET Data
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param   string $path    URI path to match
     * @param   $handler Class callback
     * @param   string $name    Group name
     */
    public static function get(string $path, $handler, string $name = NULL){

        self::$Name = $name ?: self::$routePrefix.$path;

        self::$controllers[self::$Name] = ["method" => "GET", "path" => rtrim(self::$routePrefix.$path, "/"), "handler" => $handler, "name" => self::$Name];

        if(self::$Middleware && !is_null(self::$Middleware)) self::$controllers[self::$Name]["middleware"] = self::$Middleware;

        return self::getInstance();
    }
    /**
     * Append POST Data
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param   string $path    URI path to match
     * @param   $handler Class callback
     * @param   string $name    Group name
     */
    public static function post(string $path, $handler, string $name = NULL){
        
        self::$Name = $name ?: self::$routePrefix.$path;

        self::$controllers[self::$Name] = ["method" => "POST", "path" => rtrim(self::$routePrefix.$path, "/"), "handler" => $handler, "name" => self::$Name];

        if(self::$Middleware && !is_null(self::$Middleware)) self::$controllers[self::$Name]["middleware"] = self::$Middleware;

        if(!isset(self::$controllers[self::$Name]["middleware"]) || !in_array("CSRF", self::$controllers[self::$Name]["middleware"])) self::$controllers[self::$Name]["middleware"][] = "CSRF";

        return self::getInstance();
    }
    /**
     * Append PUT Data
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param   string $path    URI path to match
     * @param   $handler Class callback
     * @param   string $name    Group name
     */
    public static function put(string $path, $handler, string $name = NULL){
        
        self::$Name = $name ?: self::$routePrefix.$path;

        self::$controllers[self::$Name] = ["method" => "PUT", "path" => rtrim(self::$routePrefix.$path, "/"), "handler" => $handler, "name" => self::$Name];

        if(self::$Middleware && !is_null(self::$Middleware)) self::$controllers[self::$Name]["middleware"] = self::$Middleware;

        return self::getInstance();
    }
    /**
     * Append DELETE Data
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param   string $path    URI path to match
     * @param   $handler Class callback
     * @param   string $name    Group name
     */
    public static function delete(string $path, $handler, string $name = NULL){
        
        self::$Name = $name ?: self::$routePrefix.$path;

        self::$controllers[self::$Name] = ["method" => "DELETE", "path" => rtrim(self::$routePrefix.$path, "/"), "handler" => $handler, "name" => self::$Name];

        if(self::$Middleware && !is_null(self::$Middleware)) self::$controllers[self::$Name]["middleware"] = self::$Middleware;

        return self::getInstance();
    }		
    /**
     * Set base URL
     * @author GemPixel <http://gempixel.com>
     * @version 1.0
     * @param   stringGem
     */
    public static function setBase(){
        if(!empty(BASEPATH)) self::$Base = BASEPATH;
    }
    /**
     * Sanitize requests
     * @author GemPixel <http://gempixel.com>
     * @version 1.0
     */
    public static function Sanitize(){
        $_GET 	 = array_map("\Core\Helper::RequestClean", $_GET);
        $_SERVER = array_map("\Core\Helper::RequestClean", $_SERVER);
    }	
     /**
      * [Controllers description]
      * @author GemPixel <https://gempixel.com>
      * @version 1.0
      */
     public static function Controllers(){
        return self::$controllers;
     }
     /**
      * Routing URI Generator
      * @author GemPixel <https://gempixel.com>
      * @version 1.0
      */
    public static function href($name, $param = NULL){

        if(isset(self::$controllers[$name])){
             
            $path = self::$controllers[$name]["path"];            
            
            preg_match_all("~\[(.*)\]~", $path, $optional);
            if($optional[0]){
                if($param){
                    $path = preg_replace("~\[(.*)\]~", "$1", $path);
                } else {
                    $path = preg_replace("~\[(.*)\]~", "", $path);
                }
            }

            if(!$param && preg_match("~({(.*)})~", $path)) throw new \Exception("Route requires 1 parameter, none given for {$name}");

            if(is_array($param)){
                preg_match_all("~{+(.*?)}~", $path, $data);
                if($data[0]){
                    foreach ($data[0] as $i => $key) {
                        $path = str_replace($key, $param[$i], $path)."/";
                    }
                } else {
                    $path .= "?".http_build_query($param);
                }            
                // foreach($param as $name => $value){
                // 	$path = str_replace('{'.$name.'}', $value, $path);
                // }
            } else {
                $path = preg_replace("~({(.*)})~", $param, $path);
            }

            return trim(self::$Config->url.$path, '/');
        }	
        return false;
    }
    /**
    * Set Name
    * @author GemPixel <https://gempixel.com>
    * @version 1.0
    * @param   string $name [description]
    * @return  [type]       [description]
    */
    public function name(string $name){
        self::$controllers[$name] = self::$controllers[self::$Name];
        self::$controllers[$name]['name'] = $name;
        unset(self::$controllers[self::$Name]);
        self::$Name = $name;	
        return $this;	
    }
    /**
     * [middleware description]
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param   [type] $handler [description]
     */
    public function middleware($handler){
        self::$controllers[self::$Name]["middleware"][] = $handler;
        return $this;
    }
    /**
     * Set Middleware Statically
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     */
    public static function setMiddleware($handler){
        
        if(!is_array($handler)) {
            $middlewares[] = $handler;
        } else {
            $middlewares = $handler;
        }

        self::$Middleware = $middlewares;
    }
    /**
     * Return Base Path
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @return void
     */
    public static function basePath(){
        $base = (new Request())->server('PHP_SELF');
        return str_replace(['/public/index.php', '/index.php'], '', $base);
    }
    /**
     * Return Current Route
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function currentRoute(){        
        return self::$routing[1]['name'];
    }
    /**
     * Get Current Route URL
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function currentRouteURL(){        
        return self::href(self::$routing[1]['name'] ?? null, isset(self::$routing[2]) && self::$routing[2] ? array_values(self::$routing[2]) : null);
    }
    /**
     * Add Middleware
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param   [type] $middleware [description]
     */
    public static function addMiddleware($middleware){
        $request = new Core\Request;
                    
        if(strpos($middleware, self::SEPARATOR)) {
            [$middlewareClass, $middlewareMethod] = explode(self::SEPARATOR, $middleware);
        } else {
            $middlewareClass = $middleware;
        }

        if(file_exists(MIDDLEWARE."/{$middlewareClass}.php")){
            $middlewareClassName = "\Middleware\\{$middlewareClass}";
            if(isset($middlewareMethod)) {
                if((new $middlewareClassName())->{$middlewareMethod}($request) === false) return false;
            } else {
                if((new $middlewareClassName())->handle($request) === false) return false;
            }
            unset($middlewareClass, $middlewareMethod);
        }	 						
    }
}