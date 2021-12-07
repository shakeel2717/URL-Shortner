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

use Core\View;
use Core\Auth;
use Core\Helper;
use Core\Request;
use Core\Response;
use Core\Localization;
use Core\DB;

class Subscription {

    use Traits\Payments;
    /**
     * Construtor
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){
        if(!config('pro')) stop(404);
    }
    /**
     * Pricing Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function pricing(){
            
        $plans = [];

        $settings = ['monthly' => false, 'yearly' => false, 'lifetime' =>  false, 'discount' => 0];

        foreach(DB::plans()->where('status', 1)->where('free', 1)->find() as $plan){
            $plans[$plan->id] = [
                "free" => $plan->free,
                "name" => $plan->name,
                "description" => $plan->description,
                "icon" => $plan->icon,
                "trial" => $plan->trial_days,
                "price_monthly" => $plan->price_monthly,
                "price_yearly" => $plan->price_yearly,
                "price_lifetime" => $plan->price_lifetime,
                "urls" => $plan->numurls,
                "clicks" => $plan->numclicks,
                "permission" => json_decode($plan->permission)
            ];   

            if(Auth::logged()){
                if(Auth::user()->planid == $plan->id){
                    $plans[$plan->id]['planurl'] = '#';
                    $plans[$plan->id]['plantext'] = e('Current');
                } else {
                    $plans[$plan->id]['planurl'] =  route('checkout', [$plan->id, 'monthly']).($plan->trial_days && !DB::payment()->where('userid', Auth::id())->whereNotNull('trial_days')->first() ? '?trial=1': '');
                    $plans[$plan->id]['plantext'] = ($plan->trial_days && !DB::payment()->where('userid', Auth::id())->whereNotNull('trial_days')->first() ? '<span class="mb-2 d-block">'.e('{d}-Day Free Trial', null, ['d' => $plan->trial_days ]).'</span>': '').e('Upgrade');
                }
            } else {
                $plans[$plan->id]['planurl'] =  route('checkout', [$plan->id, 'monthly']).($plan->trial_days ? '?trial=1': '');
                $plans[$plan->id]['plantext'] = ($plan->trial_days ? '<span class="mb-2 d-block">'.e('{d}-Day Free Trial', null, ['d' => $plan->trial_days ]).'</span>': '').e('Get Started');
            }
        }

        foreach(DB::plans()->where('status', 1)->where('free', 0)->orderByAsc('price_monthly')->find() as $plan){

            $settings['monthly'] = true;
            
            if($plan->price_monthly == 0) $plan->price_monthly = 1;
            
            if($plan->price_yearly && $plan->price_yearly != "0.00"){
                $settings['yearly'] = true;
                $discountAmount = round((($plan->price_monthly*12)-$plan->price_yearly)*100/($plan->price_monthly*12),0);
            }

            if($plan->price_lifetime && $plan->price_lifetime != "0.00") {
                $settings['lifetime'] = true;
            }

            if($discountAmount > $settings['discount']) $settings['discount'] = $discountAmount;                
            $plans[$plan->id] = [                
                "free" => $plan->free,
                "name" => $plan->name,
                "description" => $plan->description,
                "icon" => $plan->icon,
                "trial" => $plan->trial_days,
                "price_monthly" => $plan->price_monthly,
                "price_yearly" => $plan->price_yearly,
                "price_lifetime" => $plan->price_lifetime,
                "urls" => $plan->numurls,
                "clicks" => $plan->numclicks,
                "permission" => json_decode($plan->permission),
            ];

            if(Auth::logged()){
                if(Auth::user()->planid == $plan->id){
                    $plans[$plan->id]['planurl'] = '#';
                    $plans[$plan->id]['plantext'] = e('Current');
                } else {
                    $plans[$plan->id]['planurl'] =  route('checkout', [$plan->id, 'monthly']).($plan->trial_days && !DB::payment()->where('userid', Auth::id())->whereNotNull('trial_days')->first() ? '?trial=1': '');
                    $plans[$plan->id]['plantext'] = ($plan->trial_days && !DB::payment()->where('userid', Auth::id())->whereNotNull('trial_days')->first() ? '<span class="mb-2 d-block">'.e('{d}-Day Free Trial', null, ['d' => $plan->trial_days ]).'</span>': '').e('Upgrade');
                }
            } else {
                $plans[$plan->id]['planurl'] =  route('checkout', [$plan->id, 'monthly']).($plan->trial_days ? '?trial=1': '');
                $plans[$plan->id]['plantext'] = ($plan->trial_days ? '<span class="mb-2 d-block">'.e('{d}-Day Free Trial', null, ['d' => $plan->trial_days ]).'</span>': '').e('Get Started');
            }
        }
        $class = 'col-lg-3';
        $count = count($plans);
        if($count == 3){
            $class = 'col-md-4';
        }
        if($count <= 2){
            $class = 'col-md-6';
        }
        
        View::set('title', e('Premium Plan Pricing'));

        return View::with('pricing.index', compact('plans', 'settings', 'class'))->extend('layouts.main');
    }    
   /**
    * Checkout
    *
    * @author GemPixel <https://gempixel.com> 
    * @version 6.0
    * @param \Core\Request $request
    * @param integer $id
    * @param string $type
    * @return void
    */
    public function checkout(Request $request, int $id, string $type){
                
        if(!Auth::logged()){
            $request->session('redirect', route('checkout', [$id, $type]));
            return Helper::redirect()->to(route('register'));
        }
        
        $user = Auth::user();

        if(!$plan = DB::plans()->where('id', Helper::RequestClean($id))->first()) return stop(404);

        if($plan->free){
            $user->pro = "0";
            $user->planid = $plan->id;
            $user->last_payment = date("Y-m-d H:i:s");
            $user->expiration = null;
			$user->save();   
            
            return Helper::redirect()->to(route('dashboard'))->with('success', e('You have been successfully subscribed.'));
        }

        if($request->trial && $plan->trial_days){
            
            if(DB::payment()->whereNotNull('trial_days')->where('userid', $user->id)->first()){
                return Helper::redirect()->to(route('pricing'))->with("danger", e("You have already used a trial."));
            }


            $user->trial = "1";
            $user->pro = "1";
            $user->planid = $plan->id;
            $user->last_payment = date("Y-m-d H:i:s");
            $user->expiration = date("Y-m-d H:i:s", strtotime("+ {$plan->trial_days} days"));
			$user->save();
            
			$payment             = DB::payment()->create();
    		$payment->date       = Helper::dtime();
    		$payment->tid        = Helper::rand(16);
    		$payment->amount     = "0.00";
    		$payment->trial_days = $plan->trial_days;
    		$payment->userid     = $user->id;
    		$payment->status     = "Completed";
    		$payment->expiry     = date("Y-m-d H:i:s", strtotime("+ {$plan->trial_days} days"));
    		$payment->data       = null;
            $payment->save();

            return Helper::redirect()->to(route('dashboard'))->with("success", e("Free trial has been activated! Your trial will expire in {$plan->trial_days} days."));
		}

        $user->address = json_decode($user->address);
        
        if($user->planid == $id) return Helper::redirect()->to(route('dashboard'))->with('danger', e('You already subscribed to this plan. If you want to upgrade, please choose another plan.'));

        View::set('title', 'Checkout');

        \Core\View::push("<script type='text/javascript'>

        $('input[name=payment]').change(function(){
            $('.paymentOptions').hide();
            $('#'+$(this).val()).show();            
        });
        $('.paymentOptions').hide();
        $('.paymentOptions').filter(':first').show();
        
        </script>", "custom")->tofooter();

        $name = 'price_'.$type;

        $plan->price = $plan->$name;

        if(!\Helpers\App::isExtended()){
            $processors['paypal'] = $this->processor('paypal');
        } else {
            $processors = $this->processor();
        }        

        return View::with('pricing.checkout', compact('plan', 'type', 'user', 'processors'))->extend('layouts.main');
    }
    /**
     * Process Payment
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $type
     * @return void
     */
    public function process(Request $request, int $id, string $type){

        \Gem::addMiddleware('DemoProtect');

        $process = $this->processor($request->payment, 'payment');

        if(!empty(config('saleszapier'))){
            \Core\Http::url(config('saleszapier'))
                        ->with('content-type', 'application/json')
                        ->body([
                                "type" 			=> "sales",
                                "email"			=> user()->email,
                                "country" 	    => $request->country()['country'],
                                "plan"			=> $id,
                                "type"          => $type,
                                "date"			=> date("Y-m-d H:i:s")
                        ]);
        }

        return call_user_func_array($process, [$request, $id, $type]);
    }
    /**
     * Add coupon
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $type
     * @return void
     */
    public function coupon(Request $request, int $id, string $type){

        if($coupon = DB::coupons()->where("code", clean($request->code))->first()){
            
            if(strtotime("now") > strtotime(date("Y-m-d 11:59:00", strtotime($coupon->validuntil)))) return Response::factory(['error' => true, 'message' => e('Promo code has expired. Please try again.')])->json();
            
            if(!$plan = DB::plans()->first($id)){
                return Response::factory(['error' => true, 'message' => e('Please enter a valid promo code.')])->json();
            }
            $name = 'price_'.$type;

            $price = $plan->$name;

            $discountedprice = round((1 - ($coupon->discount/100))*$price, 2);

            $discount = round(($coupon->discount/100)*$price, 2);

            return Response::factory(['error' => false, 'message' => $coupon->description, 'newprice' => Helpers\App::currency(config('currency'), $discountedprice), 'discount' =>  Helpers\App::currency(config('currency'), $discount)])->json();
        }
        return Response::factory(['error' => true, 'message' => e('Please enter a valid promo code.')])->json();
    }
}