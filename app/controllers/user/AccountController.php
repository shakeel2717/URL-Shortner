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

namespace User;

use Core\Helper;
use Core\View;
use Core\DB;
use Core\Auth;
use Core\Request;
use Core\Email;

class Account {     

    use \Traits\Payments;
    
    /**
     * Membership page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function billing(){

        $user = Auth::user();

        $plan = $user->plan();
        $plan["urls"] = $plan['numurls'];
        $plan["clicks"] = $plan['numclicks'];
        $plan["permission"] = json_decode($plan['permission']);
        
        $subscriptions = \Helpers\App::isExtended() ? DB::subscription()->where('userid', $user->id)->orderByDesc('date')->findMany() : [];
        $payments =  DB::payment()->where('userid', $user->id)->orderByDesc('date')->findMany();

        View::set('title', e('Billing'));

        return View::with("user.billing", compact('user', 'plan', 'subscriptions', 'payments'))->extend('layouts.dashboard');
    }

    /**
     * Cancel Billing
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function billingCancel(Request $request){
        
        $user = Auth::user();

        if($user->admin){
            return Helper::redirect()->back()->with('danger', e("Wow there. You are an admin. You can't cancel your membership."));
        }

        if(!$user->pro()) {
            return Helper::redirect()->back()->with('danger', e('Something went wrong, please try again.'));
        }

        if(strlen($request->password) < 5) {
            return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
        }
        
        Helper::set("hashCost", 8);

        if(!Helper::validatePass($request->password, $user->password)){
            return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
        }

        if($user->trial){
            $user->expiration = Helper::dtime();
            $user->pro = 0;
            $user->trial = 0;
            $user->save();
            return Helper::redirect()->back()->with('success', e("Your trial has been canceled."));
        }
        
        $response = null;
        if(\Helpers\App::isExtended()){
            if($subscription = DB::subscription()->where('userid', $user->id)->first()){
                foreach($this->processor() as $name => $processor){
                    if(!config($name) || !config($name)->enabled || !$processor['cancel']) continue;
                    $response = call_user_func_array($processor['cancel'], [$user, $subscription]);
                }
        
                $subscription->expiry = Helper::dtime();
                $subscription->status = 'Canceled';
                $subscription->reason = clean($request->reason);
                $subscription->save();
            }
        }

        $payment = DB::payment()->create();
        $payment->date = Helper::dtime();
        $payment->tid = isset($subscription) && $subscription ? "r_{$subscription->uniqueid}" : "r_".Helper::rand(12);
        $payment->amount =  $response;
        $payment->status =  "Refunded";
        $payment->userid =  $user->id;
        $payment->expiry =  null;
        $payment->data  =  null;

        $payment->save();

        $user->pro = 0;
        $user->planid = null;
        $user->expiration = Helper::dtime('');
        $user->save();

        return Helper::redirect()->back()->with('success', e('Your subscription has been canceled.'));
    }

    /**
     * View Payment Invoice
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $id
     * @return void
     */
    public function invoice(string $id){

        $user = Auth::user();

        if(!$payment = DB::payment()->where('tid', $id)->where('userid', $user->id)->first()){
            return Helper::redirect()->back()->with('danger', e('Payment not found. Please try again.'));
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

        return View::with('invoice', compact('payment', 'user'))->extend('layouts.dashboard');
    }

    /**
     * Terminate Account and Delete Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function terminate(Request $request){

        if(!config("allowdelete")) return stop(404);
        
        $user = Auth::user();
        $id = Auth::id();


        if($user->admin){
            return Helper::redirect()->back()->with('danger', e('As an admin, you cannot delete your account form this page.'));
        }
        
        if(strlen($request->cpassword) < 5) {
            return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
        }
        
        Helper::set("hashCost", 8);

        if(!Helper::validatePass($request->cpassword, $user->password)){
            return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
        }

        if($user->pro()){
            if(\Helpers\App::isExtended()){
                $subscription = DB::subscription()->where('userid', $user->id)->first();
            
                foreach($this->processor() as $name => $processor){
                    if($plan->free || !config($name) || !config($name)->enabled || !$processor['cancel']) continue;
                    call_user_func_array($processor['cancel'], [$user, $subscription]);
                }
        
                $subscription->expiry = Helper::dtime();
                $subscription->status = 'Canceled';
                $subscription->reason = clean($request->reason);
                $subscription->save();
            }
    
            $payment = DB::payment()->create();
            $payment->date = Helper::dtime();
            $payment->tid = "r_{$subscription->uniqueid}";
            $payment->amount =  null;
            $payment->status =  "Refunded";
            $payment->userid =  $user->id;
            $payment->expiry =  null;
            $payment->data  =  null;
    
            $payment->save();
    
            $user->pro = 0;
            $user->expiration = Helper::dtime();
            $user->save();            
        }

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
               ->template(\Core\View::$path.'/email.php');

        $message = e('Your account has been deleted successfully and your data has been wiped out. If you have any questions please don\'t hesitate to contact us.');

        $mailer->to(Auth::user()->email)
                ->send([
                    'subject' => e('Your account has been terminated.'),
                    'message' => function($template, $data) use ($message) {
                        if(config('logo')){
                            $title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                        } else {
                            $title = '<h3>'.config('title').'</h3>';
                        }
                        return Email::parse($template, ['content' => $message, 'brand' => $title]);
                    }
                ]);
          

        DB::url()->where('userid', $id)->deleteMany();
        DB::stats()->where('urluserid', $id)->deleteMany();
        //DB::payment()->where('userid', $id)->deleteMany();
        DB::domains()->where('userid', $id)->deleteMany();
        DB::splash()->where('userid', $id)->deleteMany();
        DB::overlay()->where('userid', $id)->deleteMany();
        DB::bundle()->where('userid', $id)->deleteMany();
        //DB::subscription()->where('userid', $id)->deleteMany();
        $user->delete();
        Auth::logout();
        
        return Helper::redirect()->to(route('login'))->with('success', e('Your account has been successfully terminated.'));
    }
    
    /**
     * Verify Account
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function verify(){
        
    }

    /**
     * Account Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function settings(){
        
        $user = Auth::user();

        $QR2FA = null;

        if($user->secret2fa){
            $gAuth = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
            $title = explode(" ", config("title"));
            $QR2FA = \Helpers\QR::factory(['type' => 'oauth', 'data' => ['label' => $user->email, 'secret' => $user->secret2fa, 'issuer' => $title[0]]])->format('png')->create('uri');
        }
        
        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        View::set('title', e('Settings'));
        return View::with("user.settings", compact('user', 'QR2FA'))->extend('layouts.dashboard');
    }
    /**
     * Save Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function settingsUpdate(Request $request){

        \Gem::addMiddleware('DemoProtect');

        $user = Auth::user();

        $errors = '';

        if(!$request->email || !$request->validate($request->email, 'email')) $errors .= e("Please enter a valid email."). '</br>';
        
        // Validate email
        if($request->email != $user->email){
            if(DB::user()->where('email', Helper::RequestClean($request->email))->first()){
                $errors .= e("An account is already associated with this email."). '</br>';
            }
            
            if(config('user_activate')){
                $user->active = 0;
            }

            $user->email = Helper::RequestClean($request->email);
        }

        // Validate username
        if($request->username && empty($user->username) && $request->username != $user->username){

            if($request->validate($request->username, 'username')) $errors .= e("Please enter a valid username."). '</br>';

            if(DB::user()->where('username', Helper::RequestClean($request->username))->first()) $errors .= e("This username has already been used. Please try again.").'</br>';

            $user->username = Helper::RequestClean($request->username);
        }	

        // Check Password
        $passwordchanged = false;

        if($request->password){        

            if(strlen($request->password) < 5) $errors .= e("Password must contain at least 5 characters.").'</br>';

            if(!$request->cpassword || $request->password != $request->cpassword) $errors .= e("Passwords don't match.").'</br>';
        
            Helper::set("hashCost", 8);
            
            if(Helper::validatePass($request->password, $user->password)) $errors .= e("Passwords is the same as the old password.").'</br>';
            
            //Update Password
            if(!$error){
                $user->password = Helper::Encode($request->password);
                $passwordchanged = true;
            }            
        }

        // Update Avatar
        if($image = $request->file('avatar')){
            
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Avatar must be either a PNG or a JPEG (Max 500kb).'));

            if($image->sizekb >= 500) $errors .= e('Avatar must be either a PNG or a JPEG (Max 500kb).');

            [$width, $height] = getimagesize($image->location);
            
            if(($width < 100 && $height < 100) || ($width > 500 && $height > 500)) $errors .= e("Avatar must be either a PNG or a JPEG with a recommended dimension of 200x200.").'</br>';
            
            if(empty($errors)){
                if(file_exists(appConfig('app.storage')['avatar']['path'].'/'.$user->avatar)){
                    unlink(appConfig('app.storage')['avatar']['path'].'/'.$user->avatar);
                }
                $filename = Helper::rand(6)."_".$image->name;

                $request->move($image, appConfig('app.storage')['avatar']['path'], $filename);
                $user->avatar = $filename;
            }
        }
        
        if($errors) return Helper::redirect()->back()->with('danger', $errors);

        $user->name =  Helper::RequestClean($request->name);
        $user->media = in_array($request->media, array("0","1")) ? Helper::RequestClean($request->media) : 0;
        $user->public = in_array($request->public, array("0","1")) ? Helper::RequestClean($request->public) : 0;
        $user->newsletter = in_array($request->newsletter, array("0","1")) ? Helper::RequestClean($request->newsletter) : 0;

        if($user->pro()){
            $user->domain = clean($request->domain);
            $user->defaulttype = clean($request->defaulttype);
        }

        if($user->active == 0){
            
            $user->uniquetoken = Helper::rand(32);
            $user->save();

            \Helpers\Emails::renewEmail($user);

            return Helper::redirect()->back()->with('success', e('Account has been successfully updated.').' '.e('You have changed your email. Please check your email before logging out and activate your account.'));
        }

        if($passwordchanged) {
            \Helpers\Emails::passwordChanged($user);
        }
        
        $user->save();

        return Helper::redirect()->back()->with('success', e('Account has been successfully updated.'));
    }
    /**
     * Toggle 2FA
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $action
     * @param string $nonce
     * @return void
     */
    public function twoFA(string $action, string $nonce){

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, '2fa'.Auth::id())){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if($action == 'enable'){

            $gAuth = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

            $user = Auth::user();
            $user->secret2fa = $gAuth->generateSecret();            
            $user->save();

            return Helper::redirect()->back()->with('success', e('2FA has been activated on your account. Please make sure to backup the secret key or the QR code.'));
        }

        if($action == 'disable'){

            $user = Auth::user();
            $user->secret2fa = null;
            $user->save();

            return Helper::redirect()->back()->with('success', e('2FA has been disabled on your account.'));

        }
        return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
    }
    /**
     * Regenerate API Key
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function regenerateApi(){

        \Gem::addMiddleware('DemoProtect');

        $user = Auth::user();

        $user->api = Helper::rand(15).$user->id;

        $user->save();

        return back()->with('success', e('API key has been regenerated successfully. Please do not forget to update your application.'));

    }
}