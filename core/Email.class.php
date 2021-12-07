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
 * @package Gem\Core\Email
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */
namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use GemError;

final class Email {
	/**
	 * Debug Mailer
	 */
	const DEBUG = false;

	/**
	 * SMTP Confiugration
	 * @var array
	 */
	static $smtp = [];
	/**
	 * Mailgun API Configuration
	 */
	static $mailgun = [];
	/**
	 * Mailer Mode
	 * @var string
	 */
	private $mode = "phpmail";

	/**
	 * Mailer object
	 * @var null
	 */
	private $mailer = NULL;

	/**
	 * Template Content
	 * @var null
	 */
	private $template = NULL;
	/**
	 * Array of data
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 */
	private $data = [];

	/**
	 * Load Mailer
	 *
	 * @example send email via phpmail 		   Email::factory()->to([email, name])->from([email, name])->send(array)
	 * @example send email via smtp 		   Email::factory('smtp', config)->to([email, name])->from([email, name])->send(array)
	 * @example send email via smtp + template Email::factory('smtp', config)->to([email, name])->from([email, name])->template(path)->send(array)
	 * @example send email via sendmail		Email:factory('sendmail')->to([email, name])->from([email, name])->send(array)
	 * @example send email via mailgun API		Email:factory('mailgun')->to([email, name])->from([email, name])->send(array)
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param  string $transport
	 * @param  mixed $config 
	 */
	public static function factory($transport = NULL, $config = NULL){

		$mail = new self();

		$mail->data['transport'] = $transport;
		
		// Use SMTP Transport
		if($transport == 'smtp' && (is_array($config) || is_object($config))){
			$mail->mailer = new PHPMailer;
			$mail->setSMTPConfig($config);
			$mail->via("smtp");
		}	
		
		// Use Sendmail Transport
		if($transport == 'sendmail'){
			$mail->mailer = new PHPMailer;
			$mail->via('sendmail');
		}
		
		// Use PHP native mail
		if(is_null($transport)){
			$mail->mailer = new PHPMailer;
		}
		
		if(key_exists($transport, appConfig('app.maildrivers'))){
			$list = appConfig('app.maildrivers');
			$driver = $list[$transport];
			return new $driver($config);
		}

		return $mail;
	}	
	/**
	 * Set SMTP Configuration
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $config [description]
	 */
	public function setSMTPConfig($config) {
		if(is_array($config)) {

			self::$smtp = [				
				"host"		=> $config["host"],
				"port"		=> $config["port"],
				"username"	=> $config["username"],
				"password"	=> $config["password"],
			];

		}

		if(is_object($config)){

			self::$smtp = [				
				"host" 		=> $config->host,
				"port"		=> $config->port,
				"username" 	=> $config->username,
				"password" 	=> $config->password,				
			];

		}		
	}
	/**
	 * Set mailer mode
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $mode [description]
	 * @return  [type]       [description]
	 */
	public function via($mode){

		if($mode == "smtp") {

			$this->mailer->isSMTP();
			$this->mailer->Host = self::$smtp["host"];
			$this->mailer->Port = self::$smtp["port"];

			if(isset(self::$smtp["security"]) && \in_array(self::$smtp["security"], ['ssl', 'tls'])){
				$this->mailer->SMTPSecure = self::$smtp["security"];
			} else {
				if(self::$smtp["port"] == 465){
					$this->mailer->SMTPSecure = "ssl";
				}else{
					$this->mailer->SMTPSecure = "tls";
				}
			}
			
			$this->mailer->SMTPAuth = true;			
			$this->mailer->Username = self::$smtp["username"];
			$this->mailer->Password = self::$smtp["password"];	
		
		}

		if($mode == 'sendmail'){
			$this->mailer->isSendmail();
		}

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
		
		$this->data['to'][] = $user;
		
		if(is_array($user)){
			$this->mailer->AddAddress($user[0], $user[1]);
		} else {
			$this->mailer->AddAddress($user);
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
		
		$this->data['from'][] = $sender;
		
		if(is_array($sender)){
			$this->mailer->setFrom($sender[0], $sender[1]);
		} else {
			$this->mailer->setFrom($sender);
		}
		return $this;
	}
	/**
	 * Reply To
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param array $contact
	 * @return void
	 */
	public function replyto(array $contact){
		if(isset($contact[1])){
			$this->mailer->AddReplyTo($contact[0], $contact[1]);
		} else {
			$this->mailer->AddReplyTo($contact[0]);
		}    	
		return $this;
	}
	/**
	 * Fetch Template - using this method requires a closure as $data["message"] using $this->template
	 * Email::parse can be used to replace placeholders in templates
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $name [description]
	 * @return  [type]       [description]
	 */
	public function template($name){
		if(file_exists($name)){
			$this->template = file_get_contents($name);
		}
		return $this;
	}

	/**
	 * Send Email
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   array  $data [description]
	 * @return  [type]       [description]
	 */
	public function send(array $data){		

		$this->mailer->CharSet = "utf-8";

	    $this->mailer->IsHTML(true); 
					
		$this->mailer->Subject = $data["subject"];

		if(is_callable($data["message"]))	{
			$this->mailer->Body = $data["message"]($this->template, $data);	
		} else {
			$this->mailer->Body = $data["message"];	
		}

		if(DEBUG == 2) {
			$this->mailer->SMTPOptions = [
				'ssl' => [
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				]
			];	
		}
			
		if(self::DEBUG == true) {
			$this->mailer->SMTPDebug = true;
		}

		if(!$this->mailer->send()) {		
			GemError::log("SMTP Error: {$this->mailer->ErrorInfo}");
			$data['message'] = $this->mailer->Body;
			$this->fallback($data);
		}    
	}
	/**
	 * Fallback using php mail()
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   array  $data [description]
	 * @return  [type]       [description]
	 */
	public function fallback(array $data){

		if(isset($this->data["from"][0][1])){
			$headers  = "From:  {$this->data["from"][0][0]} <{$this->data["from"][0][1]}>\r\n";
		} else {
			$headers  = "From:  {$this->data["from"][0]}\r\n";
		}

		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";

		if(is_array($this->data["to"][0])){
			$data["to"] = $this->data["to"][0][1];
		} else {
			$data["to"] = $this->data["to"][0];
		}

		mail($data["to"], $data["subject"], $data["message"], $headers);
	}
	/**
	 * Parse template shortcodes: {{ shortcode }}
	 * 
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @param   string $template
	 * @param   array  $parseArray  
	 * @return  string            
	 */
	public static function parse($template, array $parseArray) : string {

		foreach ($parseArray as $key => $value) {
			$template = preg_replace('#{{\t?\s?\t?'.$key.'\t?\s?\t?}}#', $value, $template);
		}

		return $template;
	}
}