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

namespace Admin;

use Core\DB;
use Core\View;
use Core\Request;
use Core\Helper;
Use Helpers\CDN;
Use Models\User;

class Membership {
    /**
     * All Subscriptions
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function subscriptions(Request $request){

        if(!\Helpers\App::isExtended()){
            return Helper::redirect()->to(route('admin.settings.config', ['payments']))->with('danger', 'Please enter your extended purchase code to unlock payments');
        }
        
        View::set('title', e('Subscriptions'));

        $subscriptions = [];
        
        $query = DB::subscription();

        if($request->userid && \is_numeric($request->userid)) {
            $query->where('userid', $request->userid);
            View::set('title', e('Subscriptions for user'));
        }

        foreach($query->orderByDesc('id')->paginate(15) as $subscription){
            if(!$user = User::where('id', $subscription->userid)->first()) continue;
            
            if(_STATE == "DEMO") $user->email = "Hidden in demo to protect privacy";
            
            $subscription->user = $user->email;
            $subscription->useravatar = $user->avatar();

            if($plan = DB::plans()->where('id', $subscription->planid)->first()){
                $subscription->plan = $plan->name;
            }
            $subscriptions[] = $subscription;
        }

        return View::with('admin.subscriptions', compact('subscriptions'))->extend('admin.layouts.main');
    }
    /**
     * View Payments
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function payments(Request $request){
        
        View::set('title', e('Payments'));

        $payments = [];
        
        $query = DB::payment();

        if($request->userid && \is_numeric($request->userid)) {
            $query->where('userid', $request->userid);
            View::set('title', e('Payments for user'));
        }

        foreach($query->orderByDesc('id')->paginate(15) as $payment){
            if($user = DB::user()->where('id', $payment->userid)->first()){
                if(_STATE == "DEMO") $user->email="Hidden in demo to protect privacy";
                $payment->user = $user->email;
            }
            $payments[] = $payment;
        }        

        return View::with('admin.payments', compact('payments'))->extend('admin.layouts.main');
    }
    /**
     * Mark Payment As
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @param string $action
     * @return void
     */
    public function markAs(int $id, string $action){
        
        \Gem::addMiddleware('DemoProtect');

        if(!$payment = DB::payment()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Payment not found. Please try again.'));
        }

        if($action == "paid"){
            $payment->status = 'Completed';
        }
        if($action == "refunded"){
            $payment->status = 'Refunded';
        }

        $payment->save();

        return Helper::redirect()->back()->with('sucess', e('Payment status has been saved.'));
    }
    /**
     * Delete payment
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'payment.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$payment = DB::payment()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Payment not found. Please try again.'));
        }
        
        $payment->delete();
        return Helper::redirect()->back()->with('success', e('Payment has been deleted.'));
    }
    /**
     * View Payment Invoice
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function invoice(int $id){
        if(!$payment = DB::payment()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Payment not found. Please try again.'));
        }
        
        if(!$user = DB::user()->where('id', $payment->userid)->first()){
            return Helper::redirect()->back()->with('danger', e('User not found. Please try again.'));
        }

        $user->address = json_decode($user->address);

        if(!$user->address) {
            $user->address = new \stdCLass;
            $user->address->address = '';
            $user->address->city = '';
            $user->address->state = '';
            $user->address->zip = '';
            $user->address->country = '';
        }

        View::set('title', e('View Invoice'));

        return View::with('invoice', compact('payment', 'user'))->extend('admin.layouts.main');
    }
}