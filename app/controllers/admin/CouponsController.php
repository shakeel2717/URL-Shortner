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

class Coupons {

    use \Traits\Payments;
    
    /**
     * Check License
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){
        if(!\Helpers\App::isExtended()){
            return Helper::redirect()->to(route('admin.settings.config', ['payments']))->with('danger', 'Please enter your extended purchase code to unlock payments');
        }
    }
    /**
     * Coupons
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){

        $coupons = DB::coupons()->orderByDesc('id')->paginate(15);

        CDN::load('datetimepicker');

        View::push("<script>
                    $('[data-toggle=updateFormContent]').click(function(){
                        
                        let content = $(this).data('content');
                        console.log(content['newvaliduntil']);
                        $('[data-datepicker]').datepicker({
                            autoPick: false,
                            date: content['newvaliduntil'],
                            format: 'yyyy-mm-dd'
                        });
                    });
                    </script>", 'custom')->tofooter();

        View::set('title', e('Coupons Manager'));

        return View::with('admin.coupons.index', compact('coupons'))->extend('admin.layouts.main');
    }   
    /**
     * Save coupon
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        \Gem::addMiddleware('DemoProtect');
        
        if(!$request->name || !$request->code || !$request->discount) return Helper::redirect()->back()->with('danger', e('The name, the promo code and the discount percentage are required.'));
        
        if(DB::coupons()->where('code', $request->code)->first()){
            return Helper::redirect()->back()->with('danger', e('The promo code already exists.'));
        }
        
        $data = [];

        foreach($this->processor() as $name => $processor){
            if(!config($name) || !config($name)->enabled || !$processor['createcoupon']) continue;
            $data[$name] = call_user_func($processor['createcoupon'], $request);
        }
        
        $coupon = DB::coupons()->create();
        $coupon->name = Helper::clean($request->name, 3, true);
        $coupon->code = clean($request->code);
        $coupon->description = clean($request->description);
        $coupon->discount = $request->discount;
        $coupon->validuntil = Helper::dtime($request->validuntil);
        $coupon->date = Helper::dtime();
        $coupon->data = json_encode($data);
        $coupon->save();

        \Core\Plugin::dispatch('admin.coupon.add', ['id' => $coupon->id]);

        return Helper::redirect()->to(route('admin.coupons'))->with('success', e('Coupon has been added successfully'));
    }    
    /**
     * Update Coupon
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        
        \Gem::addMiddleware('DemoProtect');
        
        if(!$request->newname) return Helper::redirect()->back()->with('danger', e('The name is required.'));
        
        if(!$coupon = DB::coupons()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('The promo code does not exist.'));
        }

        $coupon->name = Helper::clean($request->newname, 3, true);
        $coupon->description = clean($request->newdescription);
        $coupon->validuntil = Helper::dtime($request->newvaliduntil);
        $coupon->save();

        return Helper::redirect()->back()->with('success', e('Coupon has been updated successfully.'));
    }
    /**
     * Delete Coupon
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'coupon.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$coupon = DB::coupons()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Coupon not found. Please try again.'));
        }
        
        $coupon->delete();
        return Helper::redirect()->back()->with('success', e('Coupon has been deleted.'));
    }
}