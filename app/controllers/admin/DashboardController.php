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
use Core\Response;
use Core\Helper;
use Core\Email;
use Models\User;

class Dashboard {
	
    /**
     * Index
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){        

        $urls = new \stdClass;        
        $urls->latest = DB::url()->whereNull('qrid')->whereNull('profileid')->orderByDesc('date')->limit(5)->findMany();
        $urls->top = DB::url()->whereNull('qrid')->whereNull('profileid')->orderByDesc('click')->limit(5)->findMany();

        $users = User::orderByDesc('date')->limit(5)->findMany();

        $reports = DB::reports()->orderByDesc('date')->limit(5)->findMany();
        
        $payments = \Helpers\App::isExtended() ? DB::payment()->orderByDesc('date')->limit(5)->findMany() : [];

        $subscriptions = \Helpers\App::isExtended() ? DB::subscription()->orderByDesc('date')->limit(5)->map(function($subscription){
            if($user = User::where('id', $subscription->userid)->first()){
                if(_STATE == "DEMO") $user->email = "Hidden in demo to protect privacy";
                $subscription->user = $user->email;
                $subscription->useravatar = $user->avatar();
            }
            if($plan = DB::plans()->where('id', $subscription->planid)->first()){
                $subscription->plan = $plan->name;
            }
            return $subscription;
        }) : [];

        $counts = [];
        $counts['urls'] = ['name' => e('Links'), 'count' => DB::url()->count(), 'count.today' => DB::url()->whereRaw('`date` >= CURDATE()')->count()];
        $counts['users'] = ['name' => e('Users'), 'count' => DB::user()->count(), 'count.today' => DB::user()->whereRaw('`date` >= CURDATE()')->count()];

        if(\Helpers\App::isExtended()){
            $counts['subscriptions'] =['name' => e('Subscriptions'), 'count' => DB::subscription()->count(), 'count.today' => DB::subscription()->whereRaw('`date` >= CURDATE()')->count()];
            $counts['payments'] = ['name' => e('Payments'), 'count' => DB::payment()->sum('amount'), 'count.today' => DB::subscription()->whereRaw('`date` >= CURDATE()')->sum('amount')];
        }

        View::set('title', e('Admin Dashboard'));
        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();        

        return View::with('admin.index', compact('urls', 'users', 'reports', 'payments', 'subscriptions', 'counts'))->extend('admin.layouts.main');
    }    
    /**
     * Search database
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function search(Request $request){

        $urls = $users = $payments = [];

        if(strlen($request->q) > 3) {

            $urls = DB::url()->whereAnyIs([
                ['url' => "%{$request->q}%"],
                ['custom' => "%{$request->q}%"],
                ['alias' => "%{$request->q}%"],
                ['meta_title' => "%{$request->q}%"],
            ], 'LIKE ')->limit(10)->findMany();
    
            $users = DB::user()->whereAnyIs([
                ['username' => "%{$request->q}%"],
                ['email' => "%{$request->q}%"],
            ], 'LIKE ')->limit(10)->findMany();
    
            $payments = DB::payment()->whereAnyIs([
                ['tid' => "%{$request->q}%"],
            ], 'LIKE ')->limit(10)->findMany();
        }

        View::set('title', e('Search for ').$request->q);

        return View::with('admin.search', compact('urls', 'users', 'payments'))->extend('admin.layouts.main');
    }
    /**
     * Email page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function email(Request $request){
        
        $newsletterusers = DB::user()->where('newsletter', 1)->count();
        $activeusers = DB::user()->where('active', 1)->count();
        $allusers = DB::user()->count();
        
        View::push(assets('frontend/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'), 'js')->toFooter();
        \Helpers\CDN::load('editor');

        View::push("<script>                        
                        CKEDITOR.replace('editor');
                    </script>", "custom")->toFooter();

        return View::with('admin.email', compact('newsletterusers', 'activeusers', 'allusers'))->extend('admin.layouts.main');
    }
    /**
     * Send Email
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function emailSend(Request $request){

        if(!$request->sendto) return Helper::redirect()->back()->with('danger', e('Please add an email or a list to send emails.'));
        if(!$request->content || !$request->subject) return Helper::redirect()->back()->with('danger', e('You are trying to send an empty email'));

        $lists = explode(',', $request->sendto);
        $emails = [];

        if(in_array('list.newsletter', $lists)){
            foreach(DB::user()->where('newsletter', 1)->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;                
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }

        if(in_array('list.active', $lists)){
            foreach(DB::user()->where('active', 1)->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }

        if(in_array('list.all', $lists)){
            foreach(DB::user()->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }

        foreach($lists as $list){
            if(!Helper::Email($list)) continue;
            if(in_array($list, $emails)) continue;
            $emails[] = ['email' => $list];
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

        $message = $request->content;
        $i = 0;
        foreach($emails as $email){
            if(isset($email['username'])){
                $message = str_replace("{username}", $email['username'], $message);
            }
            if(isset($email['email'])){
                $message = str_replace("{email}", $email['email'], $message);
            }
            if(isset($email['date'])){
                $message = str_replace("{date}", date("F-m-d H:i", strtotime($email['date'])), $message);
            }

            $mailer->to($email['email'])
                   ->send([
                       'subject' => Helper::clean($request->subject),
                       'message' => function($template, $data) use ($message) {

                            if(config('logo')){
                                $title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                            } else {
                                $title = '<h3>'.config('title').'</h3>';
                            }
                            return Email::parse($template, ['content' => $message, 'brand' => $title]);
                       }
                   ]);
            $i++;
        }

        return Helper::redirect()->back()->with('success', e('Emails were sent successfully', null, ['n' => $i]));
    }
    /**
     * Update Email Templates
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function emailTemplates(Request $request){
        
        if($request->isPost()){
            
                           
            foreach ($request->all() as $key => $value) {
                $key = str_replace("_",".", $key);
        
                if(in_array($key, ["email.registration", "email.activation", "email.activated", "email.reset", "email.invitation"])){
                    
                    $setting = DB::settings()->where('config', $key)->first();
                    $setting->var = $value;
                    $setting->save();
                }
            }

            return Helper::redirect()->back()->with('success', e('Emails templates were saved successfully.'));
        }

        View::set('title', e('Email Templates'));

        \Helpers\CDN::load('simpleeditor');    
        View::push("<script>
                         CKEDITOR.replace('email.registration');
                         CKEDITOR.replace('email.activation');
                         CKEDITOR.replace('email.activated');
                         CKEDITOR.replace('email.reset');
                         CKEDITOR.replace('email.invitation');
                    </script>", "custom")->toFooter();  

        return View::with('admin.email_templates')->extend('admin.layouts.main');
    }
    /**
     * Tools
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function tools(){
        
        \Helpers\CDN::load('datetimepicker');
        
        View::set('title', e('Tools'));

        return View::with('admin.tools')->extend('admin.layouts.main');
    }
    /**
     * Tools Action
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param string $action
     * @param [type] $nonce
     * @return void
     */
    public function toolsAction(Request $request, string $action, $nonce = null){
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'tools')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        $fn = 'tool_'.$action;
        
        if(\method_exists(__CLASS__, $fn)) return $this->{$fn}($request);

        return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
    }
    /**
     * Delete Inactive links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    private function tool_deleteurls($request){

        $urls = DB::url()->where('click', 0)->where_raw('date < (CURDATE() - INTERVAL 30 DAY)')->findMany();

        $ids = [];

        foreach($urls as $url){
            $ids[] = $url->id;
        }
        DB::url()->whereIdIn($ids)->deleteMany();
        
        return Helper::redirect()->back()->with('success', e('Inactive links have been removed from the database.'));
    }
    /**
     * Delete Users
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    private function tool_deleteusers($request){
     
        DB::user()->where('active', 0)->where('admin', 0)->deleteMany();
     
        return Helper::redirect()->back()->with('success', e('Inactive users have been removed from the database.'));
    }
    /**
     * Flush links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    private function tool_flushurls($request){
        $urls = DB::url()->where('userid', '0');
        if($request->date){
            $urls->where_raw('DATE(date) < ?', [$request->date]);
        }
        $urls->deleteMany();

        $stats = DB::stats()->where('urluserid', '0');
        if($request->date){
            $stats->where_raw('DATE(date) < ?', [$request->date]);
        }
        $stats->deleteMany();

        return Helper::redirect()->back()->with('success', e('All links by anonymous users have been removed from the database.'));
    }
    /**
     * Export Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function tool_exporturls(){
        $content = "Short URL, Long URL, Date, Clicks, Unique Clicks, User ID\n";
        foreach(DB::url()->findMany() as $url){
            $content .= ($url->domain ? $url->domain : config('url'))."/".$url->alias.$url->custom.",\"{$url->url}\",{$url->date},{$url->click},{$url->uniqueclick},{$url->userid}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=linkslist_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }
    /**
     * Export Users
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function tool_exportusers(){
        $content = "Username (empty=none), Email, Registration Date, Auth Method (empty=system), Pro, Plan ID, Expiration, Trial\n";

        foreach(DB::user()->findMany() as $user){
            $content .= "{$user->username},{$user->email},{$user->date},{$user->auth},{$user->pro},{$user->planid},{$user->expiration},{$user->trial}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=userslist_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }
    /**
     * Export Payments
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function tool_exportpayments(){
        $content = "Transaction ID, User ID, Status, Amount, Date\n";

        foreach(DB::payment()->findMany() as $payment){
            $content .= "{$payment->tid},{$payment->userid},{$payment->status},{$payment->amount},{$payment->date}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=paymentlist_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }
    /**
     * Update Script
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function update(Request $request){
        
        if($request->newcode){
            \Gem::addMiddleware('DemoProtect');
                        
            $setting = DB::settings()->where('config', 'purchasecode')->first();
    
            $setting->var = Helper::RequestClean($request->newcode);
            $setting->save();

            return Helper::redirect()->back()->with('success', e('Purchase code has been updated successfully.')); 
        }

        $update = \Helpers\App::newUpdate(true);
        $log = \Helpers\App::updateChangelog();

        $changes = [];

        $label = ["Added" => "primary", "Improved" => "success", "Fixed" => "warning", "Removed" => "danger"];
        if($log){
            foreach($log->log as $change){
                $change->date = $log->date;
                $change->class = $label[$change->type];
                $changes[] = $change;
            }
        }
        
        View::set("title", e("Update Script"));

        return View::with('admin.update', compact('update', 'changes'))->extend('admin.layouts.main'); 
    }
    /**
     * Process Update
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function updateProcess(Request $request){

        $purchasecode = trim(Helper::RequestClean($request->code));

        $update = new \Helpers\Autoupdate($purchasecode);

        try {

            $update->install();
            
            $setting = DB::settings()->where('config', 'purchasecode')->first();

            $setting->var = $purchasecode;
            $setting->save();

            return Helper::redirect()->back()->with("success", e("Script has been successfully updated."));

        }catch(\Exception $e){
            return Helper::redirect()->back()->with("danger", $e->getMessage());
        }
    }
    /**
     * View PHP Info 
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function phpinfo(){
        return phpinfo();
    }
    /**
     * Backup Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function data(){

        View::set("title", e("Import/Export Data"));

        return View::with('admin.backup')->extend('admin.layouts.main');         
    }
    /**
     * Backup Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function backup(Request $request){

        $data = [];

        if($request->ads){
            $data['ads'] = DB::ads()->findArray();
        }
        if($request->affiliates){
            $data['affiliates'] = DB::affiliates()->findArray();
        }
        if($request->bundle){
            $data['bundle'] = DB::bundle()->findArray();
        }
        if($request->coupons){
            $data['coupons'] = DB::coupons()->findArray();
        }
        if($request->domains){
            $data['domains'] = DB::domains()->findArray();
        }
        if($request->faqs){
            $data['faqs'] = DB::faqs()->findArray();
        }
        if($request->overlay){
            $data['overlay'] = DB::overlay()->findArray();
        }
        if($request->page){
            $data['page'] = DB::page()->findArray();
        }
        if($request->payment){
            $data['payment'] = DB::payment()->findArray();
        }
        if($request->pixels){
            $data['pixels'] = DB::pixels()->findArray();
        }
        if($request->plans){
            $data['plans'] = DB::plans()->findArray();
        }
        if($request->posts){
            $data['posts'] = DB::posts()->findArray();
        }
        if($request->profiles){
            $data['profiles'] = DB::profiles()->findArray();
        }
        if($request->qrs){
            $data['qrs'] = DB::qrs()->findArray();
        }
        if($request->reports){
            $data['reports'] = DB::reports()->findArray();
        }
        if($request->settings){
            $data['settings'] = DB::settings()->findArray();
        }
        if($request->splash){
            $data['splash'] = DB::splash()->findArray();
        }
        if($request->stats){
            $data['stats'] = DB::stats()->findArray();
        }
        if($request->subscription){
            $data['subscription'] = DB::subscription()->findArray();
        }
        if($request->url){
            $data['url'] = DB::url()->findArray();
        }
        if($request->user){
            $data['user'] = DB::user()->findArray();
        }
        
        \Core\File::contentDownload('backup-'.date('Y-m-d').'.gem', function() use ($data){
            return serialize($data);
        });
    }
    /**
     * Restore Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function restore(Request $request){

        if(!$file = $request->file('file')){
            return back()->with('danger', e('Incorrect format or empty file. Please upload .gem file.'));
        }

        if($file->ext != 'gem'){
            return back()->with('danger', e('Incorrect format or empty file. Please upload .gem file.'));
        }

        $content = unserialize(file_get_contents($file->location));

        foreach($content as $table => $data){

            DB::truncate($table);
        
            foreach($data as $rows){
                $record = DB::table($table)->create($rows);                
                $record->save();
            }
        }
        return back()->with('success', e('Data has been successfully restored.'));
    }

    /**
     * Cron Jobs
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function crons(){    
        
        View::set('title', e('Cron Jobs'));

        return View::with('admin.crons')->extend('admin.layouts.main');
    }
}