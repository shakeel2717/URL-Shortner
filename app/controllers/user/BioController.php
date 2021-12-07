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
use Core\Response;
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\View;
use Models\User;

class Bio {
    
    use \Traits\Links;

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){

        if(User::where('id', Auth::user()->rID())->first()->has('bio') === false){
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
        $bios = [];

        $count = DB::profiles()->where('userid', Auth::user()->rID())->count();

        $total = Auth::user()->hasLimit('domain');

        foreach(DB::profiles()->where('userid', Auth::user()->rID())->orderByDesc('id')->paginate(15) as $bio){
            $bio->data = json_decode($bio->data);
            
            if($bio->urlid && $url = DB::url()->where('id', $bio->urlid)->first()){
                $bio->views = $url->click;
                $bio->url =  \Helpers\App::shortRoute($url->domain, $url->alias);
            }

            $bios[] = $bio;
        }
        $user = Auth::user();
        if(isset($user->profiledata) && $data = json_decode($user->profiledata)){

            if($request->importoldbio == 'true'){
                return $this->importBio();
            }

            View::push('<script>$(".col-md-9").prepend("<div class=\"card\"><div class=\"card-body text-center\">'.e('We have detected that you have an old bio page. Do you want to import it?<br><br><a href=\"?importoldbio=true\" class=\"btn btn-primary\">'.e('Import').'</a>').'</div></div>")</script>', 'custom')->toFooter();
        }

        View::set('title', e('Bio Pages'));
        
        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        return View::with('bio.index', compact('bios', 'count', 'total'))->extend('layouts.dashboard');
    }

     /**
     * Create Bio
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function create(){

        $count = DB::profiles()->where('userid', Auth::user()->rID())->count();

        $total = Auth::user()->hasLimit('domain');

        \Models\Plans::checkLimit($count, $total);

        $domains = [];
        foreach(\Helpers\App::domains() as $domain){
            $domains[] = $domain;
        }    
        
        View::set('title', e('Create Bio'));

        \Helpers\CDN::load('spectrum');
        
        View::push(assets('bio.min.js'), 'script')->toFooter();

        View::push('<style>#preview .card{ 
            background: #fff;
        }
        #preview .card .btn-custom{
            background: #000;
            color: #fff;
        }
        #preview .card .btn-custom:hover{
            opacity: 0.8;
        }
        </style>', 'custom')->toHeader();

        return View::with('bio.new', compact('domains'))->extend('layouts.dashboard');
    }
    /**
     * Save Biolink
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        $count = DB::profiles()->where('userid', Auth::user()->rID())->count();

        $total = Auth::user()->hasLimit('bio');

        \Models\Plans::checkLimit($count, $total);        

        $user = Auth::user();

        if(!$request->name) return Response::factory(['error' => true, 'message' => e('Please enter a name for your profile.'), 'token' => csrf_token()])->json();
    
        $data = [];

        if(!$request->data){
            return Response::factory(['error' => true, 'message' => e('Please add at least one link.'), 'token' => csrf_token()])->json();
        }

        foreach($request->data as $key => $value){
            
            if($value['type'] == 'link'){
                $url = DB::url()->create();
                $url->url = $value['link'];
                $url->alias = 'P'.Helper::rand(3).'B'.Helper::rand(3);
                $url->type = 'direct';
                $url->userid = $user->id;
                $url->date = Helper::dtime();
                $url->save();
                $value['urlid'] = $url->id;
            }

            $data['links'][$key] = array_map('clean', $value);
        }
        
        foreach($request->social as $key => $value){
            $data['social'][$key] = clean($value);
        }

        if($image = $request->file('avatar')){
            
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Response::factory(['error' => true, 'message' => e('Avatar must be either a PNG or a JPEG (Max 500kb).')]);

            $filename = "profile_avatar".Helper::rand(6).$image->name;

			$request->move($image, appConfig('app.storage')['profile']['path'], $filename);

            $data['avatar']= $filename;
        }

        $data['style']['bg'] = $request->bg;
        $data['style']['gradient'] = array_map('clean', $request->gradient);

        $data['style']['buttoncolor'] = clean($request->buttoncolor);
        $data['style']['buttontextcolor'] = clean($request->buttontextcolor);
        $data['style']['textcolor'] = clean($request->textcolor);        

        if($request->custom){			
			if(strlen($request->custom) < 3){
				 return Response::factory(['error' => true, 'message' =>e('Custom alias must be at least 3 characters.'), 'token' => csrf_token()])->json();
                
			}elseif($this->wordBlacklisted($request->custom)){
				 return Response::factory(['error' => true, 'message' =>e('Inappropriate aliases are not allowed.'), 'token' => csrf_token()])->json();

			}elseif(DB::url()->where('custom', Helper::slug($request->custom))->whereRaw('(domain = ? OR domain = ?)', [$request->domain, ''])->first()){
				 return Response::factory(['error' => true, 'message' =>e('That alias is taken. Please choose another one.'), 'token' => csrf_token()])->json();

			}elseif(DB::url()->where('alias', Helper::slug($request->custom))->whereRaw('(domain = ? OR domain = ?)', [$request->domain, ''])->first()){
				 return Response::factory(['error' => true, 'message' =>e('That alias is taken. Please choose another one.'), 'token' => csrf_token()])->json();

			}elseif($this->aliasReserved($request->custom)){
				 return Response::factory(['error' => true, 'message' =>e('That alias is reserved. Please choose another one.'), 'token' => csrf_token()])->json();

			}elseif(!$user->pro && $this->aliasPremium($request->custom)){
				 return Response::factory(['error' => true, 'message' =>e('That is a premium alias and is reserved to only pro members.'), 'token' => csrf_token()])->json();
			}
		}

        $alias = $request->custom && !empty($request->custom) ? $request->custom : $this->alias();

        $url = DB::url()->create();
        $url->userid = $user->rID();
        $url->url = null;
        $url->domain = clean($request->domain);
        $url->alias = $alias;
        $url->date = Helper::dtime();
        $url->save();

        $profile = DB::profiles()->create();        
        $profile->userid = $user->rID();
        $profile->alias = $alias;
        $profile->urlid = $url ? $url->id : null;
        $profile->name = clean($request->name);
        $profile->data = json_encode($data);
        $profile->status = 1;
        $profile->created_at = Helper::dtime();
        $profile->save();

        if($url){
            $url->profileid = $profile->id;
            $url->save();
        }

        return Response::factory(['error' => false, 'message' => e('Profile has been successfully created.'), 'token' => csrf_token(), 'html' => '<script>window.location="'.route('bio').'"</script>'])->json();
    }
    /**
     * Delete Profile
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $id
     * @return void
     */
    public function delete(int $id, string $nonce){
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'bio.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$bio = DB::profiles()->where('id', $id)->where('userid', Auth::user()->rId())->first()){
            return back()->with('danger', e('Profile does not exist.'));
        }

        $bio->delete();

        if($url = DB::url()->where('profileid', $id)->where('userid', Auth::user()->rId())->first()){
            $this->deleteLink($url->id);
        }
        return back()->with('success', e('Profile has been successfully deleted.'));
    }
    /**
     * Edit bio Link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){

        if(!$bio = DB::profiles()->where("userid", Auth::user()->rId())->where('id', $id)->first()){
            return back()->with('danger', e('Profile does not exist.'));
        }

        $domains = [];
        foreach(\Helpers\App::domains() as $domain){
            $domains[] = $domain;
        }   

        $url = DB::url()->first($bio->urlid);

        $bio->data = json_decode($bio->data);

        View::set('title', e('Update Bio').' '.$bio->name);

        \Helpers\CDN::load('spectrum');
        
        View::push(assets('bio.min.js'), 'script')->toFooter();
        View::push('<script> var biodata = '.json_encode($bio->data->links).'; bioupdate();</script>', 'custom')->toFooter();
        View::push('<script>$(document).ready(function() { changeTheme("'.$bio->data->style->bg.'","'.($bio->data->style->gradient->start ?? '').'","'.($bio->data->style->gradient->stop ?? '').'","'.$bio->data->style->buttoncolor.'","'.$bio->data->style->buttontextcolor.'","'.$bio->data->style->textcolor.'") } ); </script>', 'custom')->toFooter();

        View::push('<style>#preview .card{ 
                background: '.$bio->data->style->bg.';
                background:linear-gradient(0deg, '.$bio->data->style->gradient->start.' 0%, '.$bio->data->style->gradient->stop.' 100%);
                color: '.$bio->data->style->textcolor.';
            }
            #preview .card h3{
                color: '.$bio->data->style->textcolor.';
            }
            #preview .card .btn-custom{
                background: '.$bio->data->style->buttoncolor.';
                color: '.$bio->data->style->buttontextcolor.';                    
            }
            #preview .card .btn-custom:hover{
                opacity: 0.8;
            }
        </style>', 'custom')->toHeader();

        return View::with('bio.edit', compact('bio', 'domains', 'url'))->extend('layouts.dashboard');

    }  
    /**
     * Update Biolink
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        
        \Gem::addMiddleware('DemoProtect');

        if(!$profile = DB::profiles()->where('id', $id)->where('userid', Auth::user()->rId())->first()){
            return Response::factory(['error' => true, 'message' => e('Profile does not exist.')]);
        }
        
        $user = Auth::user();

        if(!$request->name) return Response::factory(['error' => true, 'message' => e('Please enter a name for your profile.'), 'token' => csrf_token()])->json();
    
        $data = json_decode($profile->data, true);

        if(!$request->data){
            return Response::factory(['error' => true, 'message' => e('Please add at least one link.'), 'token' => csrf_token()])->json();
        }
        
        $links = [];

        foreach($data['links'] as $id => $olddata){
            if($olddata['type'] != 'link') continue;
            $links[$olddata['link']] = $olddata['urlid'];

        }

        $data['links'] = [];
        foreach($request->data as $key => $value){
            if($value['type'] == 'link'){
                if(isset($links[$value['link']])){                    
                    $value['urlid'] = $links[$value['link']];
                } else {
                    $url = DB::url()->create();
                    $url->url = $value['link'];
                    $url->userid = $user->id;
                    $url->alias = 'P'.Helper::rand(6);
                    $url->type = 'direct';
                    $url->save();
                    $value['urlid'] = $url->id;
                }
            }

            $data['links'][$key] = array_map('clean', $value);
        }
        
        foreach($request->social as $key => $value){
            $data['social'][$key] = clean($value);
        }

        $data['style']['bg'] = $request->bg;
        $data['style']['gradient'] = array_map('clean', $request->gradient);

        $data['style']['buttoncolor'] = clean($request->buttoncolor);
        $data['style']['buttontextcolor'] = clean($request->buttontextcolor);
        $data['style']['textcolor'] = clean($request->textcolor);        

        if($request->custom && $request->custom != $profile->alias){		
            $url = DB::url()->first($profile->urlid);

            if(strlen($request->custom) < 3){
                return Response::factory(['error' => true, 'message' =>e('Custom alias must be at least 3 characters.'), 'token' => csrf_token()])->json();
                
            }elseif($this->wordBlacklisted($request->custom)){
                return Response::factory(['error' => true, 'message' =>e('Inappropriate aliases are not allowed.'), 'token' => csrf_token()])->json();

            }elseif(DB::url()->where('custom', Helper::slug($request->custom))->whereRaw('(domain = ? OR domain = ?)', [$url->domain, ''])->first()){
                return Response::factory(['error' => true, 'message' =>e('That alias is taken. Please choose another one.'), 'token' => csrf_token()])->json();

            }elseif(DB::url()->where('alias', Helper::slug($request->custom))->whereRaw('(domain = ? OR domain = ?)', [$url->domain, ''])->first()){
                return Response::factory(['error' => true, 'message' =>e('That alias is taken. Please choose another one.'), 'token' => csrf_token()])->json();

            }elseif($this->aliasReserved($request->custom)){
                return Response::factory(['error' => true, 'message' =>e('That alias is reserved. Please choose another one.'), 'token' => csrf_token()])->json();

            }elseif(!$user->pro() && $this->aliasPremium($request->custom)){
                return Response::factory(['error' => true, 'message' =>e('That is a premium alias and is reserved to only pro members.'), 'token' => csrf_token()])->json();
            }                     

            $profile->alias = Helper::slug($request->custom);

            $url->alias = $profile->alias;
            $url->save();
        }

        if($image = $request->file('avatar')){
            
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Response::factory(['error' => true, 'message' => e('Avatar must be either a PNG or a JPEG (Max 500kb).')]);

            $filename = "profile_avatar".Helper::rand(6).$image->name;

            $request->move($image, appConfig('app.storage')['profile']['path'], $filename);

            if($data['avatar']){
                unlink(appConfig('app.storage')['profile']['path']."/".$data['avatar']);
            }

            $data['avatar']= $filename;
        }  

        $profile->userid = $user->rID();
        $profile->name = clean($request->name);
        $profile->data = json_encode($data);
        $profile->save();

        return Response::factory(['error' => false, 'message' => e('Profile has been successfully updated.'), 'token' => csrf_token()])->json();
    }
    /**
     * Set bio as default
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function default(int $id){
        
        $user = Auth::user();

        if(!$profile = DB::profiles()->where('id', $id)->where('userid', $user->rId())->first()){
            return Helper::redirect()->back()->with('danger', e('Profile does not exist.'));
        }

        $user->defaultbio = $profile->id;
        $user->save();

        if($user->public){
            return Helper::redirect()->back()->with('success', e('Profile has been set as default and can now be access via your profile page.'));
        } else {
            return Helper::redirect()->back()->with('info', e('Profile has been set as default and can now be access via your profile page. Your profile setting is currently set on private.'));
        }        
    }
    /**
     * Import Old Bio
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function importBio(){

        \Gem::addMiddleware('DemoProtect');

        $user = Auth::user();

        $old = json_decode($user->profiledata);

        $data = [];

        foreach($old->links as $link){
            if(!isset($link->link) || empty($link->link)) continue;
            if(!$url = DB::url()->where('userid', $user->id)->where('url', $link->link)->first()){
                $url = DB::url()->create();
                $url->url = $link->link;
                $url->alias = 'P'.Helper::rand(3).'M'.Helper::rand(3);
                $url->type = 'direct';
                $url->userid = $user->id;
                $url->date = Helper::dtime();
                $url->save();
            }
    
            $data['links'][Helper::slug($link->link)] = ['text' => $link->text, 'link' => $link->link, 'urlid' => $url->id, 'type' => 'link'];
        }

        $data["social"] = ["facebook" => "","twitter" => "","instagram" => "","tiktok" => "","linkedin" => ""];

        $data["style"] = ["bg" => "#FDBB2D","gradient" => ["start" => "#0072ff","stop" => "#00c6ff"],"buttoncolor" => "#ffffff","buttontextcolor" => "#00c6ff","textcolor" => "#ffffff"];

        $profile = DB::profiles()->create();

        $alias = $this->alias();

        $url = DB::url()->create();
        $url->userid = $user->rID();
        $url->url = null;
        $url->domain = clean($request->domain);
        $url->alias = $alias;
        $url->date = Helper::dtime();
        $url->save();

        $profile = DB::profiles()->create();        
        $profile->userid = $user->rID();
        $profile->alias = $alias;
        $profile->urlid = $url ? $url->id : null;
        $profile->name = clean($old->name);
        $profile->data = json_encode($data);
        $profile->status = 1;
        $profile->created_at = Helper::dtime();
        $profile->save();
        $url->profileid = $profile->id;
        $url->save();

        $user->defaultbio = $profile->id;
        $user->profiledata = null;
        $user->save();
        

        return Helper::redirect()->back()->with('success', 'Migration complete.');
    }
}    