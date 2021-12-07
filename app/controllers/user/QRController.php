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

use Core\Request;
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\View;
use Models\User;

class QR {
    
    use \Traits\Links;

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){

        if(User::where('id', Auth::user()->rID())->first()->has('qr') === false){
			return \Models\Plans::notAllowed();
		}
    }
    /**
     * QR Generator
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function index(Request $request){

        $qrs = [];

        $count = DB::qrs()->where('userid', Auth::user()->rID())->count();

        $total = Auth::user()->hasLimit('qr');

        foreach(DB::qrs()->where('userid', Auth::user()->rID())->orderByDesc('id')->paginate(15) as $qr){
            $qr->data = json_decode($qr->data);
            
            if($qr->urlid && $url = DB::url()->where('id', $qr->urlid)->first()){
                $qr->scans = $url->click;
            }

            $qrs[] = $qr;
        }

        View::set('title', e('QR Codes'));

        return View::with('qr.index', compact('qrs', 'count', 'total'))->extend('layouts.dashboard');
    }
    /**
     * Create QR Code
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function create(Request $request){        

        $count = DB::qrs()->where('userid', Auth::user()->rID())->count();

        $total = Auth::user()->hasLimit('qr');

        \Models\Plans::checkLimit($count, $total);
        
        View::set('title', e('Create QR'));

        \Helpers\CDN::load("spectrum");
		
		View::push('<script type="text/javascript">																			    						    				    
						$("#bg").spectrum({
					        color: "rgb(255,255,255)",					        
					        preferredFormat: "rgb"
						});	
                        $("#fg").spectrum({
					        color: "rgb(0,0,0)",					        
					        preferredFormat: "rgb"
						});
                    </script>', 'custom')->tofooter();  

        if(\Helpers\QR::hasImagick()){
            View::push('<script type="text/javascript">
                            $("#gbg").spectrum({
                                color: "rgb(255,255,255)",                                
                                preferredFormat: "rgb"
                            });	
                            $("#gfg").spectrum({
                                color: "rgb(0,0,0)",                                
                                preferredFormat: "rgb"
                            });
                            $("#gfgs").spectrum({
                                color: "rgb(0,0,0)",                                
                                preferredFormat: "rgb"
                            });
                            $("#eyecolor").spectrum({
                                preferredFormat: "rgb",
                                allowEmpty:true                            
                            });
                        </script>', 'custom')->tofooter();                 
        }

        if($request->link){
            View::push('<script type="text/javascript">
                            $(document).ready(function(){
                                $("a[href=#link]").click();
                            });
                        </script>', 'custom')->tofooter();
        }

        return View::with('qr.new')->extend('layouts.dashboard');
    }
    /**
     * Preview QR Codes
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function preview(Request $request){
        
        if(!$request->name) return \Core\Response::factory('<div class="alert alert-danger p-3">'.e('Please enter a name for your QR code.').'</div>')->send(); 

        if(!\Helpers\QR::typeExists($request->type)) return \Core\Response::factory('<div class="alert alert-danger p-3">'.e('Invalid QR format or missing data').'</div>')->send(); 
 
        try{
            $data = \Helpers\QR::factory($request, 400)->format('png');
            
            if($request->mode == 'gradient'){
                $data->gradient([$request->gradient['start'], $request->gradient['stop']], $request->gradient['bg'], $request->gradient['direction'], $request->eyecolor ?? null);
            } else {
                $data->color($request->fg, $request->bg, $request->eyecolor ?? null);
            }

            if($request->matrix){
                $data->module($request->matrix);
            }

            if($request->eye){
                $data->eye($request->eye);
            }

            if($request->selectlogo){
                $data->withLogo(PUB.'/static/images/'.$request->selectlogo.'.png', 80);
            }

            if($image = $request->file('logo')){
                $data->withLogo($image->location, 80);
            }

            $qr = $data->create('uri');

        } catch(\Exception $e){
            return \Core\Response::factory('<div class="alert alert-danger p-3">'.$e->getMessage().'</div>')->send();
        }

        $response = '<img src="'.$qr.'" class="img-responsive w-100 mw-50">';

        return \Core\Response::factory($response)->send();
    }
    /**
     * Generate and Save QR Code
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
    
        if(!\Helpers\QR::typeExists($request->type)) return back()->with('danger',  e('Invalid QR format or missing data'));

        $count = DB::qrs()->where('userid', Auth::user()->rID())->count();

        $total = Auth::user()->hasLimit('qr');

        \Models\Plans::checkLimit($count, $total);
        $input = $request->{$request->type} ? $request->{$request->type} : $request->text;
        $data = call_user_func([\Helpers\QR::class, 'type'.ucfirst($request->type)], clean($input));

        $qrdata = [];

        $qrdata['type'] = clean($request->type);

        $qrdata['data'] = $input;

        if($request->mode == 'gradient'){
            $qrdata['gradient'] = [
                [clean($request->gradient['start']), clean($request->gradient['stop'])], 
                clean($request->gradient['bg']), 
                clean($request->gradient['direction'])
            ];
        } else {
            $qrdata['color'] = ['bg' => clean($request->bg), 'fg' => clean($request->fg)];
        }


        if($request->selectlogo){
            $qrdata['definedlogo'] = $request->selectlogo.'.png';
        }
        

        if($image = $request->file('logo')){
            
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            $filename = "qr_logo".Helper::rand(6).$image->name;

			$request->move($image, appConfig('app.storage')['qr']['path'], $filename);

            $qrdata['custom'] = $filename;
        }

        if($request->matrix){
            $qrdata['matrix'] = clean($request->matrix);
        }

        if($request->eye){
            $qrdata['eye'] = clean($request->eye);
        }

        $url = null;
        $alias = \substr(md5($data), 0, 6);

        if(!in_array($request->type, ['text', 'vcard'])){
            $url = DB::url()->create();
            $url->userid = Auth::user()->rID();
            $url->url = $data;
            $url->alias = \substr(md5($data), 0, 6);
            $url->date = Helper::dtime();
            $url->save();
        }

        $qr = DB::qrs()->create();        
        $qr->userid = Auth::user()->rID();
        $qr->alias = $alias;
        $qr->urlid = $url ? $url->id : null;
        $qr->name = clean($request->name);
        $qr->data = json_encode($qrdata);
        $qr->status = 1;
        $qr->created_at = Helper::dtime();
        $qr->save();

        if($url){
            $url->qrid = $qr->id;
            $url->save();
        }
        
        return Helper::redirect()->to(route('qr.edit', [$qr->id]))->with('success',  e('QR Code has been successfully generated.'));
    }   
    /**
     * Edit QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        if(!$qr = DB::qrs()->where('id', $id)->where('userid', Auth::user()->rId())->first()){
            return back()->with('danger', 'QR does not exist.');
        }    
        
        $qr->data = json_decode($qr->data);

        \Helpers\CDN::load("spectrum");
		
		View::push('<script type="text/javascript">																			    						    				    
						$("#bg").spectrum({
					        color: "'.(isset($qr->data->color->bg) ? $qr->data->color->bg : 'rba(255,255,255)').'",
					        showInput: true,
					        preferredFormat: "rgb"
						});	
                        $("#fg").spectrum({
					        color: "'.(isset($qr->data->color->fg) ? $qr->data->color->fg : 'rgb(0,0,0)').'",
					        showInput: true,
					        preferredFormat: "rgb"
						});
                    </script>', 'custom')->tofooter(); 

        if(\Helpers\QR::hasImagick()){
            View::push('<script type="text/javascript">
                            $("#gbg").spectrum({
                                color: "'.(isset($qr->data->gradient) ? $qr->data->gradient[1] : 'rgb(255,255,255)').'",
                                showInput: true,
                                preferredFormat: "rgb"
                            });	
                            $("#gfg").spectrum({
                                color: "'.(isset($qr->data->gradient) ? $qr->data->gradient[0][0] : 'rgb(0,0,0)').'",
                                showInput: true,
                                preferredFormat: "rgb"
                            });
                            $("#gfgs").spectrum({
                                color: "'.(isset($qr->data->gradient) ? $qr->data->gradient[0][1] : 'rgb(0,0,0)').'",
                                showInput: true,
                                preferredFormat: "rgb"
                            });
                            $("#eyecolor").spectrum({
                                color: "'.(isset($qr->data->eye) ? $qr->data->eye : '').'",
                                preferredFormat: "rgb",
                                allowEmpty:true                            
                            });
                        </script>', 'custom')->tofooter();                 
        }

        View::set('title', e("Edit QR").' '. $qr->name);

        return View::with('qr.edit', compact('qr'))->extend('layouts.dashboard');
    }    
    /**
     * Update QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        \Gem::addMiddleware('DemoProtect');

        if(!$qr = DB::qrs()->where('id', $id)->where('userid', Auth::user()->rId())->first()){
            return back()->with('danger', 'QR does not exist.');
        }

        $input = $request->{$request->type} ? $request->{$request->type} : $request->text;
        $data = call_user_func([\Helpers\QR::class, 'type'.ucfirst($request->type)], clean($input));

        $qr->data = json_decode($qr->data);
        
        $qr->data->data = $input;

        if($request->mode == 'gradient'){
            $qr->data->gradient = [
                [clean($request->gradient['start']), clean($request->gradient['stop'])], 
                clean($request->gradient['bg']), 
                clean($request->gradient['direction'])
            ];
        } else {
            $qr->data->color = ['bg' => clean($request->bg), 'fg' => clean($request->fg)];
        }


        if($request->selectlogo){
            $qr->data->definedlogo = $request->selectlogo.'.png';
        }
        

        if($image = $request->file('logo')){
            
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            $filename = "qr_logo".Helper::rand(6).$image->name;

			$request->move($image, appConfig('app.storage')['qr']['path'], $filename);

            $qr->data->custom = $filename;

            unlink( appConfig('app.storage')['qr']['path'].'/'.$qr->data->custom);
        }

        if($request->matrix){
            $qr->data->matrix = clean($request->matrix);
        }

        if($request->eye){
            $qr->data->eye = clean($request->eye);
        }
        
        if($qr->urlid && $url = DB::url()->where('id', $qr->urlid)->first()){
            $url->url = $data;
            $url->save();
        }

        $qr->name = clean($request->name);
        $qr->data = json_encode($qr->data);

        $qr->save();     

        unlink( appConfig('app.storage')['qr']['path'].'/'.$qr->filename);
        
        return Helper::redirect()->to(route('qr.edit', [$qr->id]))->with('success',  e('QR Code has been successfully updated.'));
    }
    /**
     * Delete QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(int $id, string $nonce){
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'qr.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$qr = DB::qrs()->where('id', $id)->where('userid', Auth::user()->rId())->first()){
            return back()->with('danger', 'QR does not exist.');
        }
        
        unlink( appConfig('app.storage')['qr']['path'].'/'.$qr->filename);

        $qr->delete();

        if($url = DB::url()->where('qrid', $id)->where('userid', Auth::user()->rId())->first()){
            $this->deleteLink($url->id);
        }
        
        return back()->with('success', 'QR has been successfully deleted.');
    }
}