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
 * @package GemFramework
 * @author GemPixel (http://gempixel.com) 
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */

namespace Models;

use Gem;
use Core\Model;

class Settings extends Model {

	public static $_table = DBprefix.'settings';
    
	/**
	 * Fetch and format settings from DB
	 * 
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  object Settings table results as associated object
	 */
	public static function getSettings() : object {
		
		\Core\Support\ORM::configure('id_column_overrides', array(
			self::$_table  => 'config'
		));

		$config = new \stdCLass;	

		foreach (\Core\DB::settings()->findMany() as $row) {
			$config->{$row->config} = parseIfJSON($row->var);
		}

		date_default_timezone_set(!empty($config->timezone) ? $config->timezone : TIMEZONE);


		$lang = $config->default_lang;

		$request = request();

        if($request->cookie('language')){
            $lang = $request->cookie('language');
        }

        if($request->lang && is_string($request->lang)){
            $request->cookie('language', $request->lang, 60*24);
            $lang = $request->lang;
        }
		
		\Core\Localization::setLocale($lang);

		return $config;		
	}	
	/**
	 * Update Settings
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public static function updateSettings(){	
		\Core\Helper::set("config", self::getSettings());
	}
}