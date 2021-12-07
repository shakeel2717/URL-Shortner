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
use Models\User;

class Teams {     

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){

        if(Auth::user()->has('team') === false){
            return \Models\Plans::notAllowed();
        }
    }
    
    /**
     * Membership page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){

        $teams = User::where('teamid', Auth::user()->rId())->findMany();

        $count = DB::user()->where('teamid', Auth::id())->count();

        $total = Auth::user()->hasLimit('team');    
        
        View::set('title', e('Manage Teams'));        

        return View::with('teams.index', compact('teams', 'count', 'total'))->extend('layouts.dashboard');
    }
    /**
     * Invite Member
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function invite(Request $request){

        \Gem::addMiddleware('DemoProtect');

        if(Auth::user()->teamid) return back()->with("danger",e("You do not have this permission. Please contact your team administrator."));

        $count = DB::user()->where('teamid', Auth::id())->count();

        $total = Auth::user()->hasLimit('team');        

        \Models\Plans::checkLimit($count, $total);

        if(!$request->email || !$request->validate($request->email, 'email')) return back()->with("danger",e("This is not a valid email address"));
        
        if(DB::user()->where('email', clean($request->email))->first()){
            return back()->with("danger",e("This user has already an account. Please use another email."));
        }

        if(DB::user()->where('email', clean($request->email))->where('teamid', Auth::id())->first()){
            return back()->with("danger",e("This email address has been invited."));
        }

        if(!$request->permissions) return back()->with("danger",e("No permission has been assigned for this user."));

        $permissions = \array_map('clean', $request->permissions);

        Helper::set("hashCost", 8);

        $user = DB::user()->create();
        $user->email = clean($request->email);

        $user->password = Helper::Encode(Helper::rand(16));
        $user->date = Helper::dtime();
        $user->api = Helper::rand(16);
        $user->uniquetoken = Helper::rand(32);
        $user->public = 0;
        $user->auth_key = Helper::Encode($user->email.Helper::dtime());
        $user->active = 0;   
        $user->teamid = Auth::id();
        $user->teampermission = json_encode($request->permissions);
        $user->save();

        \Helpers\Emails::invite($user);      
    	
        return back()->with("success",e("An invite has been sent to the email."));
    }
    /**
     * Edit Team
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){

        if(!$team = DB::user()->where('id', $id)->where('teamid', Auth::id())->first()){
            return back()->with('danger', 'Team member does not exist.');   
        }
        $team->teampermission = json_decode($team->teampermission, true);

        return View::with('teams.edit', compact('team'))->extend('layouts.dashboard');
    }
    /**
     * Update Team
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        if(!$team = DB::user()->where('id', $id)->where('teamid', Auth::id())->first()){
            return back()->with('danger', 'Team member does not exist.');   
        }

        $permissions = \array_map('clean', $request->permissions);

        $team->teampermission = json_encode($permissions);

        $team->save();

        return back()->with('success', 'Team member has been updated successfully.');

    }
    /**
     * Delete team member
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $team
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(int $team, int $id, string $nonce){
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'team.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$user = DB::user()->where('id', $id)->where('teamid', $team)->first()){
            return back()->with('danger', 'Team member does not exist.');
        }    

        $user->delete();

        return back()->with('success', 'Team member has been removed successfully.');
    }
}