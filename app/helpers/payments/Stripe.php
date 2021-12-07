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

use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\Request;
use Core\Response;
use Core\View;
use Core\Email;

class Stripe{

	/**
	 * Generate Payment Form
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public static function settings(){

		$config = config('stripe');

		if(!$config && !isset($config->enabled)){
					
			$settings = DB::settings()->create();

			$settings->config = 'stripe';
			$settings->var = json_encode(['enabled' => config('pt') == 'stripe', 'secret' => config('stsk'), 'public' => config('stpk'), 'sig' => config('stripesig')]);
			$settings->save();
			$config = json_decode($settings->var);
		}

		$html = '<div class="form-group">
					<label for="stripe[enabled]" class="form-label">'.e('Stripe Payments').'</label>
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" data-binary="true" id="stripe[enabled]" name="stripe[enabled]" value="1" '.($config->enabled ? 'checked':'').' data-toggle="togglefield" data-toggle-for="stripeholder">
						<label class="form-check-label" for="stripe">'.e('Enable').'</label>
					</div>
					<p class="form-text">'.e('Collect payments securely with Stripe.').'</p>
				</div>
				<div id="stripeholder" class="toggles '.(!$config->enabled ? 'd-none' : '') .'">
					<div class="form-group">
						<label for="stripe[public]" class="form-label">'.e('Stripe Publishable Key').'</label>
						<input type="text" class="form-control" name="stripe[public]" placeholder="" id="stripe[public]" value="'.$config->public.'">
						<p class="form-text">'.e('Get your stripe keys from here once logged in <a href="https://dashboard.stripe.com/account/apikeys" target="_blank">click here</a>').'</p>
					</div>
					<div class="form-group">
						<label for="stripe[secret]" class="form-label">'.e('Stripe Secret Key').'</label>
						<input type="text" class="form-control" name="stripe[secret]" placeholder="" id="stripe[secret]" value="'.$config->secret.'">
						<p class="form-text">'.e('Get your stripe keys from here once logged in <a href="https://dashboard.stripe.com/account/apikeys" target="_blank">click here</a>').'</p>
					</div>
					<div class="form-group">
						<label for="stripe[sig]" class="form-label">'.e('Webhook Signature Key').'</label>
						<input type="text" class="form-control" name="stripe[sig]" placeholder="whsec_..." id="stripe[sig]" value="'.$config->sig.'">
						<p class="form-text">'.e('Webhook signature is a security measure to verify the authenticity of the data incoming from Stripe. It is highly recommended that you add this for safety measure. You can find your key after adding a webhook. <a href="https://dashboard.stripe.com/account/webhooks" target="_blank">Click here to find your signature key.</a>').'</p>
					</div>
					<div class="form-group">
						<label for="webhook" class="form-label">'.e('Webhook URL').'</label>
						<input type="text" class="form-control" id="webhook" value="'.route('webhook', ['']).'" disabled>
						<p class="form-text">'.e('You can add your webhooks <a href="https://dashboard.stripe.com/account/webhooks" target="_blank">here</a>. For more info, please check the docs.').'</p>
					</div>
				</div>';
		return $html;
	}

	/**
	 * Checkout
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public static function checkout(){    

		if(!config('stripe') || !config('stripe')->enabled || !config('stripe')->public || !config('stripe')->secret) {            
            return false;
        }

		View::push("<script type='text/javascript'>     
					var stripe = Stripe('".config('stripe')->public."');

					var elements = stripe.elements();
					var style = {
					base: {
							color: '#32325d',
							fontFamily: '\"Helvetica Neue\", Helvetica, sans-serif',
							fontSmoothing: 'antialiased',
							fontSize: '16px',
							'::placeholder': {
								color: '#aab7c4'
							}
						},
						invalid: {
							color: '#fa755a',
							iconColor: '#fa755a'
						}
					};
					var card = elements.create('card', {hidePostalCode: true, style: style});
					card.mount('#card-element');			
					elements.getElement('card').on('change', function(event) {
						var displayError = document.getElementById('card-errors');
						if (event.error) {
							displayError.textContent = event.error.message;
						} else {
							displayError.textContent = '';
						}
					});			
					$('button[type=submit]').click(function(e){
						if($('input[name=payment]:checked').val() == 'stripe') {
							e.preventDefault();         
							stripe.createToken(card).then(function(result) {                
								if (result.error) {
									var errorElement = document.getElementById('card-errors');
									errorElement.textContent = result.error.message;		    
								} else {
									$('#stripeToken').attr('name', 'stripeToken').val(result.token.id);
									$('form').submit();
								}
							});
						}
					});
					</script>", "custom")->tofooter();
		
		echo '<div id="stripe" class="paymentOptions"><script src="https://js.stripe.com/v3/"></script>
				<input type="hidden" id="stripeToken">
				<div class="form-group" id="stripeElement">
					<label for="card-element">
						'.e("Credit or debit card").'
					</label>
					<div id="card-element" class="border p-3 rounded mt-2"></div>
					<div id="card-errors" role="alert" class="text-danger pt=2"></div>
				</div></div>';
	}
	/**
	 * Payment
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param Request $request
	 * @param integer $id
	 * @param string $type
	 * @return void
	 */
	public static function payment(Request $request, int $id, string $type){

		if(!config('stripe') || !config('stripe')->enabled || !config('stripe')->public || !config('stripe')->secret) {
            
            \GemError::log('Payment system "Stripe" not enabled or configured.');

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
  
		if(!$request->stripeToken) return back()->with("warning", e("An error ocurred, please try again. You have not been charged."));
  
		$user = Auth::user();

		$stripe = new \Stripe\StripeClient(config('stripe')->secret);
  
		if(!$user->customerid){

			try {

				$customer = $stripe->customers->create([
					"email" => $user->email,
					"description" => "$term - $text for {$user->email}",
					"name" => clean($request->name),
					"address" => [
						"line1" => clean($request->address),
						"city" => clean($request->city),
						"country" => clean($request->country),
						"postal_code" => clean($request->zip),
						"state" => clean($request->state)
					],				  
					"source" => $request->stripeToken
				]);

			} catch(\Stripe\Exception\CardException $e) {
				
				\GemError::log('Stripe Card Error:'.$e->getMessage());
				return back()->with("danger", e($e->getMessage()));

			} catch(\Exception $e) {
				\GemError::log('Stripe Error: '.$e->getMessage());
				return back()->with("warning", e("An error ocurred, please try again. You have not been charged."));
			}

			if(!isset($customer->id)) return back()->with("warning", e("An error ocurred, please try again. You have not been charged."));

			$user->customerid = $customer->id;			
			$user->save();		  
		}
		try{
			
			$stripe->customers->update($user->customerid, ['source' => $request->stripeToken]);

		} catch(\Stripe\Exception\CardException $e) {
				
			\GemError::log('Stripe Card Error:'.$e->getMessage());
			return back()->with("danger", e($e->getMessage()));

		} catch(\Exception $e) {
			\GemError::log('Stripe Error: '.$e->getMessage());
			return back()->with("warning", e("An error ocurred, please try again. You have not been charged."));
		}
  
		$uniqueid = Helper::rand(16);

		$sub = DB::subscription()->create();
		$sub->tid = null;
		$sub->userid = $user->id;
		$sub->plan = $type;
		$sub->planid = $plan->id;
		$sub->status = "Pending";
		$sub->amount = "0";
		$sub->date = Helper::dtime();
		$sub->expiry = Helper::dtime();
		$sub->lastpayment = Helper::dtime();
		$sub->data = NULL;
		$sub->uniqueid = $uniqueid;
		$sub->save();

		if($request->coupon && $coupon = DB::coupons()->where('code', clean($request->coupon))->first()){
			if(strtotime("now") < strtotime(date("Y-m-d 11:59:00", strtotime($coupon->validuntil)))) {
				$coupon->used++;
				$coupon->save();
				$price = round((1 - ($coupon->discount / 100)) * $price, 2);
				$sub->coupon = 1;
				$sub->save();
				$coupon->data = json_decode($coupon->data);
			}
		}

		if($type == "lifetime"){
			
			try{

				$charge = $stripe->charges->create([
					'source' => $request->stripeToken,
					'amount' => $price * 100,
					'currency' => strtolower(config('currency')),
					'description' =>  "$term - $text for {$user->email}",
				]);

				$charge->paymentmethod = 'Stripe';

				if($charge->status == 'succeeded'){
					$sub->status = 'Completed';
					$sub->amount = $price;
					$sub->expiry = Helper::dtime('+10 years');
					$sub->data = json_encode($charge);
					$sub->save();
				}
				
				if($charge->status != 'succeeded'){
					return back()->with("warning", e("An error ocurred, please try again. You have not been charged."));
				}
				  
			} catch(\Stripe\Exception\CardException $e) {
				
				\GemError::log('Stripe Card Error:'.$e->getMessage());
				return back()->with("danger", e($e->getMessage()));

			} catch (\Exception $e) {
				
				\GemError::log('Stripe Error: '.$e->getMessage());

				return back()->with("warning", e("An error ocurred, please try again. You have not been charged."));
			}			
		
		} else {
		
			try {
				$intent = [
					"customer" => $user->customerid,
					"items" => [
								[
									"plan" => $planid,
								],
							]
				];

				if(isset($coupon) && $coupon){
					$intent["coupon"] = $coupon->data->stripe;
				}
										
				$subscription = $stripe->subscriptions->create($intent);			

				if(!in_array($subscription->status, ['incomplete', 'active'])){
					return back()->with("warning", e("Your credit card was declined. Please check your credit card and try again later."));
				}
	
			} catch(\Stripe\Exception\CardException $e) {
				
				\GemError::log('Stripe Card Error:'.$e->getMessage());
				return back()->with("danger", e($e->getMessage()));

			} catch (\Exception $e) {

				\GemError::log('Stripe Error:'.$e->getMessage());
				return back()->with("warning", e("An error ocurred, please try again. You have not been charged."));

			}				
		}	
		
		$user->last_payment = Helper::dtime();
		$user->expiration = $type == "lifetime" ? Helper::dtime('+10 years') : Helper::dtime();
		$user->pro = 1;
		$user->planid = $plan->id;
		$user->address = json_encode([
				"address" 	=>	clean($request->address),
				"city" 		=>	clean($request->city), 
				"state" 	=>	clean($request->state),
				"zip" 		=>	clean($request->zip),
				"country" 	=>	clean($request->count)
			]);
		$user->name = clean($request->name);
		$user->save();

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
               ->template(View::$path.'/email.php');

		$message = '<p><strong>Congrats! You have a new subscription from '.$user->email.'</strong></p>
			   <p><strong>Subscription - '.$term.' '.$text.'</strong>: '.str_replace('$', '&#36;', \Helpers\App::currency(config('currency'), $price)).'</p>

			   '.(isset($coupon) ? '
			   <p>
				   <strong>Coupon - '.$coupon->name.':</strong> -'.str_replace('$', '&#36;', \Helpers\App::currency(config('currency'), $price*($coupon->discount/100))).'
			   </p>': '').'
			   <p>
				   <strong>Total:</strong> '.str_replace('$', '&#36;', \Helpers\App::currency(config('currency'), (isset($coupon) ? $price*(1-($coupon->discount/100)) : $price))).'
			   </p>																												
			   <p>
				   Charged on '.date("d-m-Y  H:i:s").'
			   </p>';

        $mailer->to(config('email'))
                ->send([
                    'subject' => e('You have a new Subscriber'),
                    'message' => function($template, $data) use ($message) {
                        if(config('logo')){
                            $title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                        } else {
                            $title = '<h3>'.config('title').'</h3>';
                        }
                        return Email::parse($template, ['content' => $message, 'brand' => $title]);
                    }
                ]);
		

	  	return Helper::redirect()->to(route('billing'))->with('success', e('You have been successfully subscribed.'));
	}
	/**
	 * Webhook
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public static function webhook($request){

		if(!config('stripe') || !config('stripe')->enabled || !config('stripe')->public || !config('stripe')->secret) {
            
            \GemError::log('Payment system "Stripe" not enabled or configured.');

            return null;
        }

		$stripe = new \Stripe\StripeClient(config('stripe')->secret);

		$payload = @file_get_contents("php://input");

		if(!$payload || empty($payload)) {
			http_response_code(400);
			exit;
		}

		if(!empty(config('stripe')->sig)){
			$sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
			$event = null;			
			try {
			  $event = \Stripe\Webhook::constructEvent(
			    $payload, $sig_header, config('stripe')->sig
			  );
			} catch(\UnexpectedValueException $e) {
			  // Invalid payload
				\GemError::log('Stripe Webhook: '.$e->getMessage());
				http_response_code(400);
				exit();
			} catch(\Stripe\Error\SignatureVerification $e) {
			  // Invalid signature				
				\GemError::log('Stripe Webhook: '.$e->getMessage());
				http_response_code(400);
				exit();
			}			
		}
		
		$e = json_decode($payload);
		$ey = $e->data->object;

		$ey->paymentmethod = "Stripe";

		if($ey->object == "charge"){	

			if(!$user = DB::user()->where("customerid", $ey->customer)->first()) return print("User does not exist");

			$subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('date')->first();

			if($ey->paid == true && $ey->status == "succeeded"){

				if($subscription->plan == "yearly"){

					$new_expiry = date("Y-m-d H:i:s", strtotime("+1 year", $e->created));

				}elseif($subscription->plan == "lifetime"){

					$new_expiry = date("Y-m-d H:i:s", strtotime("+10 year", $e->created));

				}else{

					$new_expiry = date("Y-m-d H:i:s", strtotime("+1 month", $e->created));
				}

				$payment = DB::payment()->create();
	    		$payment->date = Helper::dtime('now');
	    		$payment->cid = $ey->id;
	    		$payment->tid = Helper::rand(16);
	    		$payment->amount =  $ey->amount / 100;
	    		$payment->userid =  $user->id;
	    		$payment->status = "Completed";
	    		$payment->expiry =  $new_expiry;
	    		$payment->data =  json_encode($ey);

				$payment->save();

				$amount = $subscription->amount + ($ey->amount / 100);

				$subscription->amount = $amount;
				$subscription->expiry = $new_expiry;
				$subscription->status = "Active";
				$subscription->save();

				$user->expiration = $new_expiry;
				$user->pro = 1;
				$user->save();
	   			    		

			}elseif ($ey->status == "failed") {
				$payment = DB::payment()->create();
				$payment->date = Helper::dtime('now');
				$payment->cid = $ey->id;
				$payment->tid = Helper::rand(16);
				$payment->amount =  $ey->amount / 100;
				$payment->userid =  $user->id;
				$payment->status = "Failed";
				$payment->data =  json_encode($ey);			
				
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
					   ->template(View::$path.'/email.php');
		
				$message = '<table><tbody><tr>
								<td>Subscription - '.$subscription->plan.'</td>
								<td class="alignright">'.\Helpers\App::currency(config('currency'), $ey->amount / 100).'</td>
							</tr>
							<tr class="soustotal">
								<td class="alignright" width="80%">Subtotal</td>
								<td class="alignright">'.\Helpers\App::currency(config('currency'), $ey->amount / 100).'</td>
							</tr>																												
							<tr class="total">
								<td class="alignright" width="80%">Failed on '.$ey->source->brand.' ('.$ey->source->last4.')</td>
							</tr></tbody></table>';
		
				$mailer->to(config('email'))
						->send([
							'subject' => e('Payment failed'),
							'message' => function($template, $data) use ($message) {
								if(config('logo')){
									$title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
								} else {
									$title = '<h3>'.config('title').'</h3>';
								}
								return Email::parse($template, ['content' => $message, 'brand' => $title]);
							}
						]);	
			}
		}
		http_response_code(200);
	}
	/**
	 * Create Plan
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public static function createplan($plan){		

		$stripe = new \Stripe\StripeClient(config('stripe')->secret);

		try {
			$product = $stripe->products->create([
			  "name" => $plan->name,
			  "type" => "service",
			]);      
		} catch (\Exception $e) {
			back()->with('danger', $e->getMessage());
			exit;
		}

		try {
			$planMonthly = $stripe->plans->create([
				"amount" => $plan->price_monthly*100,
				"interval" => "month",
				"nickname" => "{$plan->name} - Monthly",
				"product" => $product->id,           
				"currency" => strtolower(config("currency")),
				"id" => $plan->slug."monthly"
			]);      
		} catch (\Exception $e) {
			back()->with('danger', $e->getMessage());
			exit;
		}
	  
		try {
			$planYearly = $stripe->plans->create([
				"amount" => $plan->price_yearly*100,
				"interval" => "year",
				"nickname" => "{$plan->name} - Yearly",
				"product" => $product->id,            
				"currency" => strtolower(config("currency")),
				"id" => $plan->slug."yearly"
			]);
			
		} catch (\Exception $e) {
			back()->with('danger', $e->getMessage());
			exit;         
		}

		return $product->id;
    }
	/**
	 * Update Plan
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
    public static function updateplan($request, $plan){
		
		$stripe = new \Stripe\StripeClient(config('stripe')->secret);

		if($request->price_monthly != $plan->price_monthly){
			$oldplan = $stripe->plans->retrieve($plan->slug."monthly");
			$productid = $oldplan->product;
			$oldplan->delete();
		
			try {
				$planMonthly = $stripe->plans->create([
					"amount" => $request->price_monthly*100,
					"interval" => "month",
					"nickname" => "{$plan->name} - Monthly",
					"product" => $productid,
					"currency" => strtolower(config("currency")),
					"id" => $plan->slug."monthly"
				]);      
			} catch (\Exception $e) {
				back()->with('danger', $e->getMessage());
				exit;
			}		  			                
		}

		if($request->price_yearly != $plan->price_yearly){
			$oldplan = $stripe->plans->retrieve($plan->slug."yearly");
			$productid = $oldplan->product;
			$oldplan->delete();
		
			try {
				$planYearly = $stripe->plans->create([
					"amount" => $request->price_yearly*100,
					"interval" => "month",
					"nickname" => "{$plan->name} - Yearly",
					"product" => $productid,
					"currency" => strtolower(config("currency")),
					"id" => $plan->slug."yearly"
				]);      
			} catch (\Exception $e) {
				back()->with('danger', $e->getMessage());
				exit;
			}
		  			                
		}

		return $productid;
    }
	/**
	 * Sync Plans
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param [type] $plan
	 * @return void
	 */
	public static function syncplan($plan){

		$stripe = new \Stripe\StripeClient(config('stripe')->secret);

		try {
			
			$product = $stripe->products->retrieve($plan->data->stripe);

		} catch (\Exception $e) {
			
			$product = $stripe->products->create([
				"name" => $plan->name,
				"type" => "service",
			]);
		}		

		try {
			$planMonthly = $stripe->plans->create([
				"amount" => $plan->price_monthly*100,
				"interval" => "month",
				"nickname" => "{$plan->name} - Monthly",
				"product" => $product->id,           
				"currency" => strtolower(config("currency")),
				"id" => $plan->slug."monthly"
			]);      
		} catch (\Exception $e) {
			
		}
	  
		try {

			$planYearly = $stripe->plans->create([
				"amount" => $plan->price_yearly*100,
				"interval" => "year",
				"nickname" => "{$plan->name} - Yearly",
				"product" => $product->id,            
				"currency" => strtolower(config("currency")),
				"id" => $plan->slug."yearly"
			]);
			
		} catch (\Exception $e) {
			
		}

		return $product->id;
	}
	/**
	 * Cancel User Subscription
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param [type] $user
	 * @param [type] $subscription
	 * @return void
	 */
	public static function cancel($user, $subscription){
		
		if($subscription->data->paymentmethod != 'Stripe') return null;

		$stripe = new \Stripe\StripeClient(config('stripe')->secret);
		
		try {

			$response = $stripe->subscriptions->retrieve($subscription->tid, []);

			if($response->plan->interval == "yearly"){
				$invoice = $stripe->invoices->all(["subscription" => $subscription->tid]);
				$charge = $invoice->data[0]->charge;
				$amount = $invoice->data[0]->total / 100;
	
				$start = $response->current_period_start;
				$end = $response->current_period_end;
	
				$yStart = date('Y', $start);
				$yEnd = date('Y', $end);
	
				$mStart = date('m', $start);
				$mEnd = date('m', $end);
	
				$diff = (($yEnd - $yStart) * 12) + ($mEnd - $mStart);
	
				$refund = round(($diff - 1) * $amount / 12, 2);
	
				$refund = $stripe->refunds->create([
				  "charge" => $charge,
				  "amount" => $refund * 100
				]);

				$response->cancel();
			
				return $refund;

			}else{

				$response->cancel_at_period_end = true;
				$response->save();

				return null;
			}

		} catch (Exception $e) {
			\GemError::log('Stripe Cancel Error: '.$e->getMessage(), ['userid' => $user->id]);
			return null;			
		}

		return null;
	}
	/**
	 * Create coupon
	 */
	public static function createcoupon($request){
		
		$stripe = new \Stripe\StripeClient(config('stripe')->secret);

		try{
			
			$coupon = $stripe->coupons->create([
				'name'  => $request->name,
				'percent_off' => $request->discount,
				'duration' => 'repeating',
				'duration_in_months' => 12,
			]);

			return $coupon->id;

		}catch (Exception $e) {
			\GemError::log('Stripe Coupon Error: '.$e->getMessage(), ['userid' => $user->id]);
			return null;			
		}
	}
	
}