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
 * @package Gem\Core\Email
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */
namespace Core\Support;

use Core\Http;
use GemError;

final class Mailgun {

    private $url = null;
    /**
     * Sending Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    private $domain = null;
    /**
     * Private Key
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    private $key = null;    

    /**
     * Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     */
    private $data = ['to' => '', 'from' => ''];

    /**
     * Send as Mailgun
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param string $domain
     * @param string $key
     */
    public function __construct($config, $endpoint = null){

        if(is_array($config)) {
            $this->domain = $config['domain'];
            $this->key = $config['key'];
		}

		if(is_object($config)){
            $this->domain = $config->domain;
            $this->key = $config->key;
		}

        $this->url = $endpoint ?? 'https://api.mailgun.net/v3';
        return $this;
    }

	/**
	 * To user
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param mixed $user
	 * @return void
	 */
	public function to($user){				
		if(is_array($user)){
            $this->data['to'] .= "{$user[1]} <{$user[0]}>";
        } else {
            $this->data['to'] .= $user;
        }
		return $this;
	}
	/**
	 * Sender information
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param mixed $sender
	 * @return void
	 */
	public function from($sender){		
		if(is_array($sender)){
            $this->data['from'] .= "{$sender[1]} <{$sender[0]}>";
        } else {
            $this->data['from'] .= $sender;
        }
		return $this;
	}
   /**
    * Send as Mailgun
    *
    * @author GemPixel <https://gempixel.com> 
    * @version 1.0
    * @param array $data
    * @return void
    */
    public function send(array $data){

        $content = \http_build_query([
            'from' => $this->data['from'],
            'to' => $this->data['to'],
            'subject' => $data['subject'],
            'html' => $data['message']
        ]); 

        $http = Http::url($this->url.'/'.$this->domain.'/messages')->auth('api', $this->key)->body($content)->post();
        

        if($http->httpCode() == 200) return true;

        GemError::log('Mailgun API Error: '.$http->httpCode().' '.$http->getBody());

        return false;
    }

}