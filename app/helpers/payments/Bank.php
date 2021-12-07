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

namespace Helpers\Payments;

use \Core\DB;
use \Core\Helper;
use \Core\Auth;

class Bank{
    /**
     * Generate Payment Form
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function settings(){
        
        $config = config('bank');

        if(!$config && !isset($config->enabled)){
                    
            $settings = \Core\DB::settings()->create();

            $settings->config = 'bank';
            $settings->var = json_encode(['enabled' => false, 'info' => '']);
            $settings->save();
            $config = json_decode($settings->var);
        }

        $html = '<div class="form-group">
                    <label for="bank[enabled]" class="form-label">'.e('Bank Transfer').'</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" data-binary="true" id="bank[enabled]" name="bank[enabled]" value="1" '.($config->enabled ? 'checked':'').' data-toggle="togglefield" data-toggle-for="bankinfo">
                        <label class="form-check-label" for="bank[enabled]">'.e('Enable').'</label>
                    </div>
                    <p class="form-text">'.e('Transfer payments via your bank.').'</p>
                </div>
                <div class="form-group '.(!$config->enabled ? 'd-none':'').'">
                    <label for="bankinfo" class="form-label">'.e('Bank Info').'</label>
                    <textarea class="form-control" name="bank[info]" placeholder="" id="bankinfo">'.($config ? $config->info : '').'</textarea>
                    <p class="form-text">'.e('Enter the full information where your users can send payments to via their bank.').'</p>
                </div>';
        return $html;
    }
    /**
     * Generate Checkout Form
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function checkout(){

        if(!config('bank') || !config('bank')->enabled){
            return null;
        }

        echo '<div id="bank" class="paymentOptions mb-5">
                <h6 class="card-title">'.e('Bank Information').'</h6>
                '.config('bank')->info.'
              </div>';
    }
    /**
     * Bank Payment
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @param [type] $id
     * @param [type] $type
     * @return void
     */
    public static function payment($request, $id, $type){
        
        if(!config('bank') || !config('bank')->enabled){
            return back()->with('danger', e('An error ocurred, please try again. You have not been charged.'));
        }
        

        if(!$plan = DB::plans()->first($id)){
			return back()->with('danger', e('An error ocurred, please try again. You have not been charged.'));
	  	}			
		
		$term = e($plan->name);
		$text = e("First month");
		$price = $plan->price_monthly;
		$planid = $plan->slug."monthly";
	
		if($type == "yearly" && $plan->price_yearly){
			$term = e($plan->name);
			$text = e("First year");
			$price = $plan->price_yearly;
			$planid = $plan->slug."yearly";				
		}

		if($type == "lifetime" && $plan->price_lifetime){
			$term = e($plan->name);
			$text = e("Lifetime");
			$price = $plan->price_lifetime;
			$planid = $plan->slug."lifetime";			
		}
  

		$user = Auth::user();		
  
		$uniqueid = Helper::rand(16);

		$sub = DB::subscription()->create();
		$sub->tid = null;
		$sub->userid = $user->id;
		$sub->plan = $type;
		$sub->planid = $plan->id;
		$sub->status = "Pending";
		$sub->amount = $price;
		$sub->date = Helper::dtime();
		$sub->expiry = Helper::dtime();
		$sub->lastpayment = Helper::dtime();
		$sub->data = json_encode(['type' => 'bank']);
		$sub->uniqueid = $uniqueid;
		$sub->save();

        return Helper::redirect()->to(route('billing'))->with('success', e('Your subscription is currently pending. Once we receive the money, we will activate your subscription.'));
    }

}