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

namespace API;

use \Core\Helper;
use \Core\Request;
use \Core\Response;
use \Core\DB;
use \Core\Auth;
use \Models\User;

class Account {
    /**
     * Get User
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function get(){
        
        $user = Auth::ApiUser();

        $response = [
            'error' => 0,
            'data' => [
                'id' => (int) $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'avatar' => $user->avatar(),
                'status' => $user->pro ? 'pro' : 'free',
                'expires' => $user->expiry,
                'registered' => $user->date,
            ]
        ];

        return Response::factory($response)->json();
    }
    /**
     * Update User
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function update(Request $request){
        
        $data = $request->getJSON();

        $user = Auth::ApiUser();

        $update = false;
        
        if(isset($data->email)){

            $data->email = clean($data->email);
            
            if(!$request->validate($data->email, 'email')) return Response::factory(['error' => 1, 'message' => 'Please enter a valid email.'])->json();

            if(DB::user()->where('email', $data->email)->whereNotEqual('id', $user->id)->first()) return Response::factory(['error' => 1,  'message' => 'An account is already associated with this email.'])->json();

            $user->email = clean($data->email);

            $update = true;
        }

        if(isset($data->password)){

            $data->password = clean($data->password);
            
            if(strlen($data->password) < 5) return Response::factory(['error' => 1, 'message' => 'Password must be at least 5 characters.'])->json();
            
            Helper::set("hashCost", 8);
            $user->password = Helper::Encode($data->password);

            \Helpers\Emails::passwordChanged($user);

            $update = true;
        }

        if(!$update){
            return Response::factory(['error' => 0, 'message' => 'No changes were done to the account.'])->json();  
        }

        $user->save();
        return Response::factory(['error' => 0, 'message'=> 'Account has been successfully updated.'])->json();                
    }
}