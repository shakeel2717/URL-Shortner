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
 * @package AppConfig
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */

return [
  /**
   * Default Language
   */
  'language' => 'en',
  /**
   * Allow users to shorten already-shortened link
   */
  'self_shortening' => false,

  /**
	 * Anti-Flood Time
	 * @var integer Minutes, Stats will not be updated when the same visitor clicks the same url for this amount of time
	 */	
	'antiflood' => 15,

  /**
   * Automatically redirect splash page when a timer is set. Set to true for this to happen
   */
  'redirectauto' => false,

  /**
   * List of Executables
   */
  'executables' => ["exe","dll","bin","dat","osx"],
  
  /**
   * Storage Paths Configuration
   */
  'storage' => [
      'public' => [
        'path' => PUB,
        'link' => config('url')
      ],
      'uploads'  => [
        'path' => PUB.'/content',
        'link' => config('url').'/content'
      ],
      'blog' => [
        'path' => PUB.'/content/blog',
        'link' => config('url').'/content/blog'
      ],
      'avatar' => [
        'path' => PUB.'/content/avatar',
        'link' => config('url').'/content/avatar'        
      ],
      'images' => [
        'path' => PUB.'/content/images',
        'link' => config('url').'/content/images'
      ],
      'qr' => [
        'path' => PUB.'/content/qr',
        'link' => config('url').'/content/qr'        
      ],
      'profile' => [
        'path' => PUB.'/content/profiles',
        'link' => config('url').'/content/profiles'        
      ],
    ],
    
    /**
     * Geo Driver: api | maxmind | custom
     * api: Path to api with with {IP} as placeholder
     * maxmind: Path to database
     * custom: Fully qualified name of a class
     */
    'geodriver' => 'maxmind',
    'geopath' => STORAGE.'/app/GeoLite2-City.mmdb',
    // 'geopath' => 'https://freegeoip.app/json/{IP}',  
    // 'custom' => '\Helpers\MyClass::class',

    /**
     * Mail Drivers
     */
    'maildrivers' => [
      'mailgun' => \Core\Support\Mailgun::class,
    ],
    /**
     * Path to cache folder
     */
    'cachepath' => STORAGE.'/cache',

    /**
     * Route to the API
     */
    'apiroute' => '/api/',

    /** 
     * Throttle API X per Y minutes
     * @example [3, 10] = 3 requests per 10 minutes
     */
    'throttle' => [30, 1],

    /**
     * Enable debugger
     */
    'debug' => defined('DEBUG') ? DEBUG : 0,

    'log' => LOGS.'/'

  ];