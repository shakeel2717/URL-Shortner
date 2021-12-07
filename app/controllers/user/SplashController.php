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

class Splash {

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){

        if(User::where('id', Auth::user()->rID())->first()->has('splash') === false){
			return \Models\Plans::notAllowed();
		}
    }


    /**
     * List Splash Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){
        
        $splashpages = DB::splash()->where('userid', Auth::user()->rID())->orderByDesc('id')->find();

        $count = DB::splash()->where('userid', Auth::id())->count();
        
        $total = Auth::user()->hasLimit('splash');

        View::set('title', e('Custom Splash Pages'));

        return View::with('splash.index', compact('splashpages', 'count', 'total'))->extend('layouts.dashboard');

    }

    /**
     * Create Splash Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function create(Request $request){
        
        if(Auth::user()->teamPermission('splash.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        $count = DB::splash()->where('userid', Auth::id())->count();        
        $total = Auth::user()->hasLimit('splash');

        $request->clear();

        \Models\Plans::checkLimit($count, $total);

        View::set('title', e('Create a Custom Splash'));

        return View::with('splash.create', compact('count', 'total'))->extend('layouts.dashboard');
    }

    /**
     * Save Splash Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        if(Auth::user()->teamPermission('splash.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }
        
        $request->save('name', $request->name);
        $request->save('title', $request->title);
        $request->save('counter', $request->counter);
        $request->save('message', $request->message);
        $request->save('product', $request->product);

        if(!$request->name || !$request->message || !$request->title || !$request->name) return back()->with("danger", e("The name, title, message and link cannot be empty."));            

        if(!$request->validate($request->product, 'url')) return back()->with("danger", e("Please enter a valid URL."));
        if($request->counter && !$request->validate($request->counter, 'int')) return back()->with("danger", e("Please enter a valid counter time in seconds."));    

        $array = [
            "title" => clean(Helper::truncate($request->title, 50)),
            "message" => clean(Helper::truncate($request->message, 140)),
            "product" => clean($request->product),
            "counter" => clean($request->counter),
            "avatar" => '',
            "banner" => ''
        ];

        if($image = $request->file('avatar')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Avatar must be either a PNG or a JPEG (Max 300kb).'));

            if($image->sizekb >= 300) return back()->with("danger", e('Avatar must be either a PNG or a JPEG (Max 300kb).'));

            [$width, $height] = getimagesize($image->location);
            
            if(($width > 200 || $height > 200) ) return back()->with("danger", e("Avatar must be either a PNG or a JPEG with a recommended dimension of 200x200."));
            
			$filename = "customsplash_avatar_".Helper::rand(6).$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);

			$array['avatar'] = $filename;       
		}

        if($image = $request->file('banner')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Banner must be either a PNG or a JPEG (Max 500kb).'));

            if($image->sizekb >= 500) return back()->with("danger", e('Banner must be either a PNG or a JPEG (Max 500kb).'));

            [$width, $height] = getimagesize($image->location);
            
            if($width < 980 || ($height < 250 || $height > 500)) return back()->with("danger", e("Banner must be either a PNG or a JPEG with a recommended dimension of 980x300."));
            
			$filename = "customsplash_banner_".Helper::rand(6).$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);

			$array['banner'] = $filename;
		}

        $splash = DB::splash()->create();

        $splash->name = clean($request->name);
        $splash->data = json_encode($array);
        $splash->userid = Auth::id();
        $splash->date = Helper::dtime();
        $splash->save();    
        $request->clear();
        return Helper::redirect()->to(route('splash'))->with('success', e('Custom splash page has been created.'));
    }

    /**
     * Edit Splash
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        if(Auth::user()->teamPermission('splash.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        if(!$splash = DB::splash()->where('id', $id)->first()){
            return back()->with('danger', e('Custom splash page does not exist.'));
        }

        $splash->data = json_decode($splash->data);

        View::set('title', e('Update a Custom Splash'));

        return View::with('splash.edit', compact('splash'))->extend('layouts.dashboard');
    }
    
    /**
     * Update Existing Splash
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        if(Auth::user()->teamPermission('splash.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        if(!$splash = DB::splash()->where('id', $id)->first()){
            return back()->with('danger', e('Custom splash page does not exist.'));
        }

        if(!$request->name || !$request->message || !$request->title || !$request->name) return back()->with("danger", e("The name, title, message and link cannot be empty."));            

        if(!$request->validate($request->product, 'url')) return back()->with("danger", e("Please enter a valid URL."));
        if($request->counter && !$request->validate($request->counter, 'int')) return back()->with("danger", e("Please enter a valid counter time in seconds."));
        
        $data = json_decode($splash->data);

        $array = [
            "title" => clean(Helper::truncate($request->title, 50)),
            "message" => clean(Helper::truncate($request->message, 140)),
            "product" => clean($request->product),
            "counter" => clean($request->counter),
            "avatar" => $data->avatar,
            "banner" => $data->banner            
        ];

        if($image = $request->file('avatar')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Avatar must be either a PNG or a JPEG (Max 300kb).'));

            if($image->sizekb >= 300) return back()->with("danger", e('Avatar must be either a PNG or a JPEG (Max 300kb).'));

            [$width, $height] = getimagesize($image->location);
            
            if(($width > 200 || $height > 200) ) return back()->with("danger", e("Avatar must be either a PNG or a JPEG with a recommended dimension of 200x200."));
            
			$filename = "customsplash_avatar_".Helper::rand(6).$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);

			$array['avatar'] = $filename;

            if(file_exists(appConfig('app.storage')['uploads']['path'].'/'.$data->avatar )){
                unlink( appConfig('app.storage')['uploads']['path'].'/'.$data->avatar );
            }            
		}

        if($image = $request->file('banner')){
			
			if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Banner must be either a PNG or a JPEG (Max 500kb).'));

            if($image->sizekb >= 500) return back()->with("danger", e('Banner must be either a PNG or a JPEG (Max 500kb).'));

            [$width, $height] = getimagesize($image->location);
            
            if($width < 980 || ($height < 250 || $height > 500)) return back()->with("danger", e("Banner must be either a PNG or a JPEG with a recommended dimension of 980x300."));
            
			$filename = "customsplash_banner_".Helper::rand(6).$image->name;
			$request->move($image, appConfig('app.storage')['uploads']['path'], $filename);

			$array['banner'] = $filename;

            if(file_exists(appConfig('app.storage')['uploads']['path'].'/'.$data->banner )){
                unlink( appConfig('app.storage')['uploads']['path'].'/'.$data->banner);
            }
		}

        $splash->name = clean($request->name);
        $splash->data = json_encode($array);
        $splash->save();    
        return back()->with('success', e('Custom splash page has been updated.'));
    }

    /**
     * Delete Splash
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function delete(int $id){

        if(Auth::user()->teamPermission('splash.delete') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        if(!$splash = DB::splash()->where('id', $id)->first()){
            return back()->with('danger', e('Custom splash page does not exist.'));
        }

        $data = json_decode($splash->data);

        if(file_exists(appConfig('app.storage')['uploads']['path'].'/'.$data->avatar )){
            unlink( appConfig('app.storage')['uploads']['path'].'/'.$data->avatar);
        }

        if(file_exists(appConfig('app.storage')['uploads']['path'].'/'.$data->banner )){
            unlink( appConfig('app.storage')['uploads']['path'].'/'.$data->banner);
        }

        DB::url()->where("type", $splash->id)->update(['type' => '']);

        $splash->delete();
        
        return back()->with('success', e('Custom splash page has been deleted.'));
    }

}