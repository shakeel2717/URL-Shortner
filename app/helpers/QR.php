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

namespace Helpers;

class QR {
    /**
     * Instance of the writer
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $writer = null;
    /**
     * Add Logo
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $logo = null;
    /**
     * Get Extension
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $extension = null;    
    /**
     * Instance of the QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $QR = null;    

    /**
     * Generate QR Code
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public static function factory($request, $size = 200, $margin = 0){

        if(is_array($request)){
            $data = call_user_func([self::class, 'type'.ucfirst($request['type'] )], clean($request['data']));
        }

        if(is_object($request)){
            $input = $request->{$request->type} ? $request->{$request->type} : $request->text;
            $data = call_user_func([self::class, 'type'.ucfirst($request->type)], clean($input));
        }

        if(is_string($request)){
            $data = call_user_func([self::class, 'typeText'], clean($request));
        }
    

        if(self::hasImagick()){
            return new QrImagick($data, $size, $margin);
        }

        return new QrGd($data, $size, $margin);        
    }
    /**
     * Check if can use Imagick
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return boolean
     */
    public static function hasImagick(){
        return class_exists('Imagick', false);
    }    
    /**
     * Check if Type Exists
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $type
     * @return void
     */
    public static function typeExists($type){
        return \method_exists(__CLASS__, 'type'.ucfirst($type));
    }
    /**
     * Generate String
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $data
     * @return string
     */
    public static function typeText(string $data){
        if(empty($data)) throw new \Exception(e('QR data cannot be empty. Please fill the appropriate field.'));
        return $data;
    }
    /**
     * Get Link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $data
     * @return void
     */
    public static function typeLink(string $data){
        if(empty($data)) throw new \Exception(e('QR data cannot be empty. Please fill the appropriate field.'));
        return $data;
    }
    /**
     * Generate Email QR Codes
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return string
     */
    public static function typeEmail($data){
        
        if(is_string($data)) return "mailto:".clean($data); 
        
        $data = (array) $data;

        $response = "mailto:".clean($data['email']);

        $query = [];

        if(isset($data['subject'])) {
            $query['subject'] = clean($data['subject']);
        }

        if(isset($data['body'])) {            
            $query['body'] = strip_tags(str_replace("\n", "", clean($data['body'])));
        }

        return $response.($query ? '?'.\urldecode(http_build_query($query)) : '');
    }
    /**
     * Call Phone
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return string
     */
    public static function typePhone($data){
        $data = str_replace('+', '', $data);
        
        if(!is_numeric($data)) throw new \Exception(e('Invalid phone number. Please try again.'));

        return 'tel:'.$data;
    }
    /**
     * Generate SMS
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param arrays $data
     * @return string
     */
    public static function typeSms(array $data){
        
        $data = (array) $data;

        if(!is_numeric($data['phone'])) throw new \Exception(e('Invalid phone number. Please try again.'));        

        return 'smsto:'.(is_array($data) ? $data['phone'].":{$data['message']}": $data);
    }
    /**
     * Generate Vcard
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return string
     */
    public static function typeVcard($data){
                
        $data = (array) $data;

        $data = array_map('clean', $data);
        
        $builder = '';

        if($data['fname'] || $data['lname']){
            $builder .= "N:{$data['lname']};{$data['fname']}\r\n";
        }

        if($data['org']){
            $builder .= "ORG:{$data['org']}\r\n";
        }

        if($data['phone']){
            $builder .= "TEL;TYPE=work,voice:{$data['phone']}\r\n";
        }

        if($data['email']){
            $builder .= "EMAIL;TYPE=INTERNET;TYPE=WORK;TYPE=PREF:{$data['email']}\r\n";
        }

        if($data['site']){
            $builder .= "URL;TYPE=work:{$data['site']}\r\n";
        }

        if($data['facebook']){
            $builder .= "URL;TYPE=facebook:{$data['facebook']}\r\n";
        }

        if($data['instagram']){
            $builder .= "URL;TYPE=instagram:{$data['instagram']}\r\n";
        }

        if($data['twitter']){
            $builder .= "URL;TYPE=twitter:{$data['twitter']}\r\n";
        }

        if($data['linkedin']){
            $builder .= "URL;TYPE=linkedin:{$data['linkedin']}\r\n";
        }

        if($data['street'] || $data['city'] || $data['state'] || $data['zip'] || $data['country']){

            $builder .= "ADR;TYPE=work:;;{$data['street']};{$data['city']};{$data['state']};{$data['zip']};{$data['country']}\r\n";
        }

        if(empty($builder)) throw new \Exception(e('vCard data cannot be empty. Please fill some fields'));

        $vcard = "BEGIN:VCARD\r\nVERSION:3.0\r\n";
        $vcard .= $builder;
        $vcard .= "\r\nREV:" . date("Ymd") . "T195243Z\r\nEND:VCARD";
        

        return $vcard;
    }
    /**
     * Generate OAuth
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return void
     */
    public static function typeOauth($data){
        
        $data = (array) $data;

        $string = 'otpauth://totp/';
        $string .= $data['label'].'?secret=';
        $string .= $data['secret'];
        if(isset($data['issuer'])){
            $string .= '&issuer='.trim($data['issuer']);
        }
        return $string;
    }

    /**
     * Generate Wifi string
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return string WIFI:S:<SSID>;T:<WPA|WEP|>;P:<password>;;
     */
    public static function typeWifi($data){
        
        if(is_string($data)) throw new \Exception(e('Invalid QR format or missing data'));
        
        $data = (array) $data;

        $string = "WIFI:";

        if(empty($data['ssid'])) throw new \Exception(e('Please enter the Wifi SSID'));
        
        $string .= "S:".clean($data['ssid']).";";

        if($data['pass'] && $data['encryption']){
            $string .= "T:".clean($data['encryption']).";";
        }

        if($data['pass'] && $data['encryption']){
            $string .= "P:".clean($data['pass']).";;";
        }

        return $string;
    }
    /**
     * Generate Geodata
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return string geo:LAT,LONG
     */
    public static function typeGeo($data){
        if(is_string($data)) throw new \Exception(e('Invalid QR format or missing data'));
        
        $data = (array) $data;

        return 'geo:'.$data['lat'].','.$data['long'];
    }
}