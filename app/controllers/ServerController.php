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

use Core\Request;
use Core\Response;
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\View;
use Core\Email;
use Models\User;

class Server {
    /**
     * Contact
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function contact(Request $request){				

        $integrity = explode(".", base64_decode($request->integrity))[1];
        
        $captcha = new \Helpers\Captcha;

		try{
			
            $captcha->validate($request);

        } catch(\Exception $e){
            return Response::factory(['error' => true, "danger" => $e->getMessage(), "csrf" => csrf_token()])->json();
        }

        if($contact = DB::overlay()->where('id', $integrity)->first()){
            
            $contact->data = json_decode($contact->data);

            $name = clean($request->name, 3, true);
            $email = clean($request->email, 3, true);
            $message = clean($request->message, 3, true);

            if(!empty($contact->data->webhook)){

                \Core\Http::url($contact->data->webhook)
                    ->body(["type" => "contact", "data" => ["name" => $name, "email" => $email, "message" => $message, "date" => date("Y-m-d H:i")]])
                    ->with('content-type', 'application/json')
                    ->post();
            }
            $message = "<p><strong>Contact Data</strong></p>Name: {$name}<br>Email: {$email}<br>Message: {$message}";

            if(config('smtp')->user){
                $mailer = Email::factory('smtp', [
                    'username' => config('smtp')->user,
                    'password' => config('smtp')->pass,
                    'host' => config('smtp')->host,
                    'port' => config('smtp')->port
                ]);
            } else {
                $mailer = Email::factory();
            }
    
            $mailer->from([config('email'), config('title')])
                    ->replyto([$email])
                    ->template(\Core\View::$path.'/email.php');
        
            $mailer->to($contact->data->email)
                    ->send([
                        'subject' => $contact->data->subject,
                        'message' => function($template, $data) use ($message) {
                            if(config('logo')){
                                $title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                            } else {
                                $title = '<h3>'.config('title').'</h3>';
                            }
                            return Email::parse($template, ['content' => $message, 'brand' => '<a href="'.config('url').'">'.$title.'</a>']);
                        }
                    ]);

        }

        return Response::factory(['error' => false, "msg" => "Success", "csrf" => csrf_token()])->json();
    }
    /**
     * Subscribe
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function subscribe(Request $request){
        $integrity = explode(".", base64_decode($request->integrity))[1];
        
        $captcha = new \Helpers\Captcha;

		try{
			
            $captcha->validate($request);

        } catch(\Exception $e){
            return Response::factory(['error' => true, "danger" => $e->getMessage(), "csrf" => csrf_token()])->json();
        }

        if($contact = DB::overlay()->where('id', $integrity)->first()){
            
            $data = json_decode($contact->data);

            $data->emails[] = clean($request->email, 3, true);

            $contact->data = json_encode($data);
            
            $contact->save();

            if(!empty($contact->data->webhook)){

                \Core\Http::url($contact->data->webhook)
                    ->body(["type" => "newsletter", "data" => [ "email" => $email, "date" => date("Y-m-d H:i")]])
                    ->with('content-type', 'application/json')
                    ->post();
            }
        }

        return Response::factory(['error' => false, "message" => $data->success, "csrf" => csrf_token()])->json();
    }
}