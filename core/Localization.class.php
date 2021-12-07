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
 * @package Core\Middleware 
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */
namespace Core;

use Core\Helper;
use Core\Request;

class Localization {	
    /**
     * Current Locale
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    private static $locale = null;
    /**
     * Default File
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    private static $defaultFile = 'app';
    /**
     * Locale Name
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    private static $name = null;
    /**
     * Locale Code
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    private static $code = null;
    /**
     * Locale Region
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private static $region = null;
    /**
     * RTL
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private static $rtl = null;
    /**
     * Locale Author
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    private static $author = null;
    /**
     * Language List
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    private static $list;

    /**
     * Set App Locale
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param [type] $name
     * @return void
     */
    static function setLocale($locale){
        self::$locale = $locale;
    }
    /**
     * Set Default File
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param [type] $name
     * @return void
     */
    static function setFile($name){
        self::$defaultFile = $name;
    }
    /**
     * Return current Locale
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @return void
     */
    static function locale(){
        
        return self::$locale;
    }
    /**
     * Bootstrap
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    static function bootstrap(){

        if(is_null(self::$locale)){
            self::$locale = appConfig('app.language');
        }    

        if(file_exists(LOCALE."/".self::$locale."/".self::$defaultFile.".php")){
            $lang = include(LOCALE."/".self::$locale."/".self::$defaultFile.".php");
            self::$name = $lang['name'] ?? 'Unknown';
            self::$code = $lang['code'] ?? 'na';
            self::$region = $lang['region'] ?? 'na';
            self::$author = $lang['author'] ?? 'na';
            self::$rtl = $lang['rtl'] ?? false;
            self::$list = $lang['data'] ?? [];
        }
    }
    /**
     * Return variable
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $name
     * @return void
     */
    public static function get($name){
        return self::$$name;
    }
    /**
     * Update language
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @return void
     */
    static function update(){
        if(file_exists(LOCALE."/".self::$locale."/".self::$defaultFile.".php")){
            $lang = include(LOCALE."/".self::$locale."/".self::$defaultFile.".php");
            self::$name = $lang['name'] ?? 'Unknown';
            self::$code = $lang['code'] ?? 'na';
            self::$author = $lang['author'] ?? 'na';
            self::$list = $lang['data'] ?? [];
        }
    }
    /**
     * Get Locale String
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param string $string
     * @param mixed $count
     * @param array $variables
     * @return string Translated string
     */
    static function translate($string, $count = null, $variables = []){
        if(isset(self::$list[$string]) && !empty(self::$list[$string])){
            $e = self::$list[$string];            

            if(!is_null($count) && is_numeric($count)) {
                [$single, $multiple] = explode("|", $e);
                $e = ($count == 1) ? $single : $multiple;
            }
            $string = $e;
        }

        if($variables){
            foreach($variables as $key => $var){
                $var = str_replace('$', '&#x24;', $var);
                $string = preg_replace('#{\t?\s?\t?'.$key.'\t?\s?\t?}#', $var, $string);
            }
        }    
        
        return $string;
    }
    /**
     * Get List of language files
     *
     * @author GemPixel <https://gempixel.com>      
     * @version 1.0
     * @param $limit Number of language files
     * @return array list
     */
    static function list($limit = 5){
        $list = [];
        $count = 0;
        foreach (new \RecursiveDirectoryIterator(LOCALE) as $path){
            if($count > $limit) break;
            
            if(!$path->isDir() || in_array($path->getFilename(), ['.','..'])) continue;
            
            $list[] = ['code' => $path->getFilename(), 'path' => $path->getPathname()];
            $count++;
        }
        return $list;
    }
    /**
     * Get List of languages with data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @return void
     */
    static function listInfo(){
        $list = [];
        foreach(self::list() as $data){
            if(!file_exists(LOCALE.'/'.$data['code'].'/app.php')) continue;
            $array = include(LOCALE.'/'.$data['code'].'/app.php');
            $list[] = $data + ['name' => $array['name'], 'author' => $array['author']];
        }

        return $list;
    }
    /**
     * Get Language String 
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param [type] $string
     * @return void
     */
    static function lang($string){
        if(strpos($string, '.')){
            $data = explode('.', $string);
            $code = $data[0];
            $file = $data[1];
        } else {
            $code = $string;
            $file = 'app';
        }
        if(!file_exists(LOCALE.'/'.$code.'/'.$file.'.php')) return false;
        return include(LOCALE.'/'.$code.'/'.$file.'.php');
    }
}