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


  // Framework Version
  define("_VERSION","1.1");
	
  // InApp Safety
  define("_INAPP", TRUE);
  define("_STATE", "PROD");

  // Path Constants
  define("ROOT", dirname(dirname(__FILE__)));
  define("APP", ROOT.'/app');
  define("PUB", ROOT."/public");
  define("CORE", ROOT."/core");

  define("CONTROLLER", APP."/controllers");
  define("MODELS", APP."/models");
  define("MIDDLEWARE", APP."/middleware");
  define("LIBRARY", ROOT."/vendor");
  define("UPLOADS", PUB."/content");
  define("STORAGE", ROOT."/storage");
  define("LOGS", STORAGE."/logs");
  define("LOCALE", STORAGE."/languages");
  define("PLUGIN", STORAGE."/plugins");


  include(CORE."/functions/core.php"); 

  include(CORE."/GemError.class.php");

  include(LIBRARY."/autoload.php");  

  include(CORE."/Gem.class.php");

  Gem::preload();  

  include(ROOT."/config.php");

  include(APP."/routes.php");
