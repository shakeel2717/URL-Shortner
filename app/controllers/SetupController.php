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

use Core\Request;
use Core\DB;
use Core\Helper;

class Setup {

    /**
     * Current version
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.1.5
     */
    private $version = '6.1.5';

    /**
     * Error
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $error = false;

    /**
     * Check if install is required
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function check(){

        if(file_exists(ROOT."/config.php")) return true;

        new self();

        return false;
    }
    /**
     * Upgrade
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function __construct(){
        
        $request = new Request;

        $step = $request->segment(1);

        $fn = "step{$step}";

        if(!method_exists(__CLASS__, $fn)) return \GemError::cleanError(404, 'The page you are looking for cannot be found.', 404);

        $this->{$fn}($request);
    }

    /**
     * Step 1
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param Request $request
     * @return void
     */
    private function step(Request $request){
        
        $this->header($request);

        echo '<h1>Installation of Premium URL Shortener</h1> 
            '.message().'
            <h2>1.0 Requirement Check</h2>
            <p>
                These are some of the important requirements for this software. "Red" means it is vital to this script, "Orange" means it is required but not vital and "Green" means it is good. If one of the checks is "Red", you will not be able to install this script because without that requirement, the script will not work.
            </p>
            <div class="content">
                <p>
                PHP Version (v7.4+)
                '.$this->verify('version').'
                </p>
                It is very important to have at least PHP Version 7.4. It is highly recommended that you use 7.4 or later for best performance.
            </div>
            <div class="content">
                <p>PDO Driver must be enabled 
                    '.$this->verify('pdo').'
                </p>
                PDO driver is very important so it must enabled. Without this, the script will not connect to the database hence it will not work at all. If this verify fails, you will need to contact your web host and ask them to either enable it or configure it properly.
            </div>					
            <div class="content">
                <p><i>config_sample.php</i> must be accessible. 
                    '.$this->verify('config').'
                </p>
                This installation will open that file to put values in so it must be accessible. Make sure that file is there in the root folder and is writable.
            </div>	
            <div class="content">
                <p><i>storage/</i> folder and its subfolder must be writable. 
                    '.$this->verify('storage').'
                </p>
                Many things will be uploaded to that folder so please make sure it has the proper permission.
            </div>		
            <div class="content">
                <p><i>public/content/</i> folder must be writable. 
                    '.$this->verify('content').'
                </p>
                Many things will be uploaded to that folder so please make sure it has the proper permission.
            </div>
            <div class="content">
                <p>cURL Enabled '.$this->verify('curl').'</p>
                cURL is used to interact with external server or APIs.
            </div>';
            if(!$this->error) echo '<p><a href="validate" class="button">Proceed</a></p>';
        $this->footer();
    }
    /**
     * Validate
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function stepvalidate($request){

        define('DEBUG', 1);

        if($request->isPost()){

            if(!$request->code || strlen($request->code) < 10){
                return back()->with('danger', 'Please enter a valid purchase code');
            }

            $http = \Core\Http::url('https://cdn.gempixel.com/verify/')->withHeaders([
                    "X-Authorization" => "TOKEN {$request->code}",
                    "X-Script" => "Premium URL Shortener",
                    "X-Version" => _VERSION
                ])->body(['install' => '1'])->post();

            if($http->getBody() !== 'Valid'){
                return back()->with('danger', 'Please enter a valid purchase code'); 
            }

            $request->session('code', $request->code);

            return Helper::redirect()->to('database')->with('success', 'Your purchase code has been successfully validated.'); 
        }

        $this->header($request);

        echo '<h2>2.0 Validate Purchase Code</h2>
        '.message().'
        <p>
            Please enter your Envato purchase code. To learn how to find your Envato purchase code, please visit <a href="https://gempixel.com/solutions/how-to-find-your-envato-purchase-code" target="_blank">https://gempixel.com/solutions/how-to-find-your-envato-purchase-code</a>
        </p>
        <form method="post" action="" class="form" autocomplete="off">
            <label>Envato Purchase Code</label>
            <input type="text" name="code" class="input" placeholder="e.g. 10101010-10aa-0101-0101-a1b010a01b10">
             
            <button type="submit" class="button">Proceed</button>    
        </form>';
        $this->footer();
    }
    /**
     * Dump Database
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function stepdatabase(Request $request){

        if(!$request->session('code')){
            return Helper::redirect()->to('validate')->with('danger', 'Please enter a valid purchase code');
        }

        if($request->isPost()){
            
            $this->error = '';

            if(!$request->host){                
                $this->error .= 'Please enter a database host.<br>';
            }
    
            if(!$request->name){
                $this->error .= 'Please enter a database name.<br>';
            }
    
            if(!$request->user){
                $this->error .= 'Please enter a database user.<br>';
            }                	
            
            if($this->error || !empty($this->error)){

                \Core\Helper::setMessage('danger', $this->error);

            } else {

                try{

                    new PDO("mysql:host=".$request->host.";dbname=".$request->name."", $request->user, $request->pass);
                    
                    $this->generateConfig($request);

                    $this->dump($request);

                    \Core\Helper::setMessage('success', 'Database successfully installed.');

                    return \Core\Helper::redirect()->to('user');

                }catch (PDOException $e){
                    \Core\Helper::setMessage('danger', $e->getMessage());
                }  

            }

        }


        $this->header($request);

        echo '<h2>3.0 Database Configuration</h2>
        '.message().'
        <p>
            Now you have to set up your database by filling the following fields. Make sure you fill them correctly.
        </p>
        <form method="post" action="" class="form" autocomplete="off">
            <label>Database Host <a>Usually it is localhost.</a></label>
            <input type="text" name="host" class="input" placeholder="e.g. localhost">
            
            <label>Database Name</label>
            <input type="text" name="name" class="input" placeholder="e.g. dbname" required>
            
            <label>Database User </label>
            <input type="text" name="user" class="input" placeholder="e.g. dbuser" required>    
            
            <label>Database Password</label>
            <input type="password" name="pass" class="input">   

            <label>Database Prefix <a>Prefix for your tables (Optional) e.g. short_</a></label>
            <input type="text" name="prefix" class="input" value="">       

            <label>Security Key <a>Keep this secret!</a></label>
            <input type="text" name="key" class="input" value="'."PUS".md5(rand(0,100000)).md5(time()).'">   

            <button type="submit" class="button">Proceed</button>    
        </form>';
        $this->footer();
    }
    /**
     * Setup user
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function stepuser(Request $request){

        if(!$request->session('code')){
            return Helper::redirect()->to('validate')->with('danger', 'Please enter a valid purchase code');
        }

        if($request->isPost()){
            
            $this->error = '';

            if(!$request->email || !$request->validate($request->email, 'email')){                
                $this->error .= 'Please enter a valid email.<br>';
            }
    
            if(!$request->username || !$request->validate($request->username, 'username')){
                $this->error .= 'Please enter a username.<br>';
            }
    
            if(!$request->pass || strlen($request->pass) < 5){
                $this->error .= 'Please enter use a password that is more than 5 characters.<br>';
            }                	
            
            if($this->error || !empty($this->error)){

                \Core\Helper::setMessage('danger', $this->error);

            } else {

                try{
                    
                    include(ROOT."/config.sample.php");

                    DB::Connect();

                    DB::settings()->where('config', 'url')->update(['var' => $request->url]);
                    DB::settings()->where('config', 'purchasecode')->update(['var' => $request->session('code')]);

                    $user = DB::user()->create();

                    $user->email = $request->email;
                    Helper::set('hashCost', 8);
                    $user->password = Helper::Encode($request->pass);
                    $user->username = trim($request->username);
                    $user->admin = 1;
                    $user->date = Helper::dtime();

                    $user->api = Helper::rand(16);
                    $user->uniquetoken = Helper::rand(32);
                    $user->public = 0;
                    $user->auth_key = Helper::Encode($user->email.Helper::dtime());

                    $user->save();

                    $request->save('username', $request->username);
                    $request->save('email', $request->email);
                    $request->save('password', $request->pass);
                    $request->save('site', $request->url);
                    
                    \Core\Helper::setMessage('success', 'Admin successfully created.');

                    return \Core\Helper::redirect()->to('final');

                }catch (PDOException $e){
                    \Core\Helper::setMessage('danger', $e->getMessage());
                }  

            }

        }

        $this->header($request);

        echo '<h2>4.0 Admin Creation</h2>
            '.message().'
            <p>
                Now you have to create an admin account by filling the fields below. Make sure to add a valid email and a strong password. For the site URL, make sure to remove the last slash.
            </p>
            <form method="post" action="" class="form" autocomplete="off">
                <label>Admin Email</label>
                <input type="email" name="email" class="input" required>

                <label>Admin Username</label>
                <input type="text" name="username" class="input" minlenght="3" required>	

                <label>Admin Password (min 5 characters)</label>
                <input type="password" name="pass" class="input" minlength="5" required>   

                <label>Site URL <a>Including http:// or https:// but without the ending slash "/"</a></label>
                <input type="text" name="url" class="input" value="'.str_replace('/user', '', $request->uri()).'" placeholder="http:// or https://" required> 
                <p><strong>Double check to make sure the url is correct. If you have SSL enabled, please make sure the schema is https:// and not http://</strong></p>

                <button type="submit" class="button">Proceed</button>        
            </form>';
        $this->footer();
    }
    /**
     * Final Step
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function stepfinal($request){

        if(!$request->session('code')){
            return Helper::redirect()->to('validate')->with('danger', 'Please enter a valid purchase code');
        }

        rename(ROOT."/config.sample.php", ROOT."/config.php");

        $this->header($request);

        echo''.message().'<p>
                The script has been successfully installed and your admin account has been created. All you have to do is to go to your main site, login using the info below and configure your site by clicking the "Admin" menu and then "Settings". Thanks for your purchase and enjoy.
            </p>
            <p>
            <strong>Login URL: <a href="'.old('site').'/user/login" target="_blank">'.old('site').'/user/login</a></strong> <br />
            <strong>Email: '.old('email').'</strong> <br />
            <strong>Username: '.old('username').'</strong> <br />
            <strong>Password: '.old('password').'</strong>
            </p>
            <p><a href="'.old('site').'" class="button">Visit your site</a></p>';
        $this->footer();
    }
    /**
     * Verify
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $module
     * @return void
     */
    private function verify($module){
        switch ($module) {
            case 'version':
                if(PHP_VERSION >= "7.4"){
                    return "<span class='ok'>You have ".PHP_VERSION."</span>";
                }else{                    
                    $this->error = true;
                    return "<span class='fail'>You have ".PHP_VERSION."</span>";
                }
                break;
            case 'config':
                if(@file_get_contents(ROOT.'/config.sample.php') && is_writable(ROOT.'/config.sample.php')){
                    return "<span class='ok'>Accessible</span>";
                }else{                    
                    $this->error = true;
                    return "<span class='fail'>Not Accessible</span>";
                }
                break;
            case 'storage':
                    if(is_writable(STORAGE)){
                        return "<span class='ok'>Accessible</span>";
                    }else{                    
                        $this->error = true;
                        return "<span class='fail'>Not Accessible</span>";
                    }
                    break;	
            case 'content':
                if(is_writable(UPLOADS)){
                    return "<span class='ok'>Accessible</span>";
                }else{                    
                    $this->error = true;
                    return "<span class='fail'>Not Accessible</span>";
                }
                break;
            case 'pdo':
                if(defined('PDO::ATTR_DRIVER_NAME') && class_exists("PDO")){
                    return "<span class='ok'>Enabled</span>";
                }else{                    
                    $this->error = true;
                    return "<span class='fail'>Disabled</span>";
                }
                break;
            case 'file':
                if(ini_get('allow_url_fopen')){
                    return "<span class='ok'>Enabled</span>";
                }else{
                    return "<span class='warning'>Disabled</span>";
                }
                break;	
            case 'curl':
                if(in_array('curl', get_loaded_extensions())){
                    return "<span class='ok'>Enabled</span>";
                }else{
                    $this->error = true;
                    return "<span class='fail'>Disabled</span>";
                }
                break;						
        }
    }
    /**
     * Generate Config File
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    private function generateConfig($request){

        $file = file_get_contents(ROOT.'/config.sample.php');
	    $file = str_replace("__HOST__", trim($request->host), $file);
	    $file = str_replace("__DB__", trim($request->name), $file);
	    $file = str_replace("__USER__", trim($request->user), $file);
	    $file = str_replace("__PASS__", trim($request->pass), $file);
	    $file = str_replace("__PRE__", trim($request->prefix), $file);
	    $file = str_replace("__PUB__", md5(rand(100000, 1000000).time()), $file);

        $file = str_replace("__ENC__", \Defuse\Crypto\Key::createNewRandomKey()->saveToAsciiSafeString(), $file);
	    $file = str_replace("__KEY__", trim($request->key), $file);
        
	    $fh = fopen(ROOT.'/config.sample.php', 'w') or die("Can't open config.sample.php. Make sure it is writable.");

	    fwrite($fh, $file);
	    fclose($fh);
    }
    /**
     * Dump Database
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function dump($request){
        
        include(ROOT."/config.sample.php");

        DB::Connect();

        \Core\Support\ORM::configure('id_column_overrides', array(
			DBprefix.'settings'  => 'config'
		));
        

        DB::schema('ads', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->string('type')->index();
            $table->text('code');
            $table->integer('impression');
            $table->integer("enabled", null, '1');            
        }); 

        DB::schema('affiliates', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->integer("refid")->index();
            $table->integer("userid")->index();
            $table->double('amount', '10,2');
            $table->timestamp('referred_on');
            $table->timestamp('paid_on', null);
            $table->integer("status", null, '0');
        }); 

        DB::schema('bundle', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->string('slug')->index();
            $table->bigint('userid');
            $table->timestamp('date');
            $table->string('access', 10, 'private');
            $table->integer("view", null, '0');            
        }); 

        DB::schema('coupons', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->text('description');
            $table->string('code')->index();
            $table->integer('discount');
            $table->timestamp('date');
            $table->integer('used', null, '0');
            $table->timestamp('validuntil', null);
            $table->text('data');
        });

        DB::schema('domains', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");            
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('domain')->index();
            $table->string('redirect');
            $table->string('redirect404');
            $table->int("status", null, '1');
        });

        DB::schema('faqs', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");            
            $table->increment('id');
            $table->string('slug')->index();
            $table->string('category')->index();
            $table->text('question');
            $table->text('answer');
            $table->int('pricing', null, '0');
            $table->timestamp('created_at');
        });

        DB::schema('overlay', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('name');
            $table->string('type', 191, 'message')->index();
            $table->text('data');
            $table->timestamp('date');
        });

        DB::schema('page', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->string('category');
            $table->string('seo')->index();
            $table->text('content');
            $table->int('menu', null, '1');
            $table->timestamp('lastupdated');
        });

        DB::schema('payment', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('tid')->index();
            $table->bigint('userid')->index();
            $table->string('status');
            $table->double('amount', '10,2');
            $table->timestamp('date');
            $table->timestamp('expiry', null);
            $table->int('trial_days');
            $table->text('data');
        });
        
        DB::schema('pixels', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('type')->index();
            $table->string('name');
            $table->text('tag');
            $table->timestamp('created_at');
        });

        DB::schema('plans', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->string('slug')->index();
            $table->text('description');
            $table->string('icon');
            $table->int('trial_days');
            $table->double('price_monthly', '10,2');
            $table->double('price_yearly', '10,2');
            $table->double('price_lifetime', '10,2');
            $table->int('free', null, '0');
            $table->bigint('numurls');
            $table->bigint('numclicks');
            $table->integer('retention');
            $table->text('permission');
            $table->int('status', null, '0');
            $table->string('stripeid');
            $table->text('data');
        });

        DB::schema('posts', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('title');
            $table->text('content');
            $table->string('slug')->index();
            $table->timestamp('date');
            $table->bigint('views', null, '0');
            $table->string('image');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->int('published', null, '1');
        });

        DB::schema('profiles', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('alias')->index();
            $table->string('name');
            $table->bigint('urlid')->index();
            $table->text('data');
            $table->int('status', null, '1');
            $table->timestamp('created_at');
        });

        DB::schema('qrs', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('alias')->index();
            $table->string('name');
            $table->string('filename');
            $table->bigint('urlid')->index();
            $table->text('data');
            $table->int('status', null, '1');
            $table->timestamp('created_at');
        });

        DB::schema('reports', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4"); 
            $table->increment('id');
            $table->text('url');
            $table->text('bannedlink');
            $table->string('type');
            $table->string('ip');
            $table->string('email');
            $table->timestamp('date');
            $table->int('status', null, '0');  
        });        

        DB::schema('settings', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4"); 
            $table->string('config', 191, false)->primary();
            $table->text('var');
        });

        $settings = ['url' => '','title' => '','description' => '','api' => '1','user' => '1','sharing' => '1','geotarget' => '1','adult' => '1','maintenance' => '0','keywords' => '','theme' => 'default','apikey' => '','ads' => '1','captcha' => '0','ad728' => '','ad468' => '','ad300' => '','frame' => '0','facebook' => '','twitter' => '','email' => '','fb_connect' => '0','analytic' => '','private' => '0','facebook_app_id' => '','facebook_secret' => '','twitter_key' => '','twitter_secret' => '','safe_browsing' => '','captcha_public' => '','captcha_private' => '','tw_connect' => '0','multiple_domains' => '0','domain_names' => '','tracking' => '1','update_notification' => '1','default_lang' => '','user_activate' => '0','domain_blacklist' => '','keyword_blacklist' => '','user_history' => '0','pro_yearly' => '','show_media' => '0','pro_monthly' => '','paypal_email' => '','logo' => '','timer' => '','smtp' => '','style' => '','font' => '','currency' => 'USD','news' => '<strong>Installation successful</strong> Please go to the admin panel to configure important settings including this message!','gl_connect' => '0','require_registration' => '0','phish_api' => '','phish_username' => '','aliases' => '','pro' => '0','google_cid' => '','google_cs' => '','public_dir' => '0','devicetarget' => '1','homepage_stats' => '1','home_redir' => '','detectadblock' => '0','timezone' => '','freeurls' => '10','allowdelete' => '1','serverip' => '','favicon' => '','advanced' => '0','purchasecode' => '','alias_length' => '5','theme_config' => '{"homeheader":"","homedescription":"","homestyle":"dark"}','schemes' => 'https,ftp,http','email.activated' => '<p><b>Hello</b></p><p>Your account has been successfully activated at {site.title}.</p>','email.activation' => '<p><b>Hello!</b></p><p>You have been successfully registered at {site.title}. To login you will have to activate your account by clicking the URL below.</p><p><a href="http://{user.activation}" target="_blank">{user.activation}</a></p>','email.registration' => '<p><b>Hello!</b></p><p>You have been successfully registered at {site.title}. You can now login to our site at <a href="http://{site.link}" target="_blank">{site.link}</a>.</p>','email.reset' => '<p><b>A request to reset your password was made.</b> If you <b>didn\'t</b> make this request, please ignore and delete this email otherwise click the link below to reset your password.</p>\r\n		      <b><div style="text-align: center;"><b><a href="http://{user.activation}" class="link">Click here to reset your password.</a></b></div></b></p><p>\r\n		      <p>If you cannot click on the link above, simply copy &amp; paste the following link into your browser.</p>\r\n		      <p><a href="http://{user.activation}" target="_blank">{user.activation}</a></p>\r\n		      <p><b>Note: This link is only valid for one day. If it expires, you can request another one.</b></p>','email.invitation' => '<p><b>Hello!</b></p><p>You have been invited to join our team at {site.title}. To accept the invitation, please click the link below.</p><p><a href="http://{user.invite}" target="_blank">{user.invite}</a></p>','blog' => '1','root_domain' => '1','slackclientid' => '','slacksecretid' => '','slackcommand' => '','slacksigningsecret' => '','contact' => '1','report' => '1','customheader' => '','customfooter' => '','saleszapier' => '','pppublic' => '','ppprivate' => '','manualapproval' => '0','version' => $this->version,'faqcategories' => '{}','invoice' => '{"header":"","footer":""}','virustotal' => '{"key":"","limit":"2"}','affiliate' => '{"enabled":"0","rate":"30","payout":"10","terms":"terms of affiliate"}','paypal' => '{"enabled":"0","email":""}','testimonials' => '[]', 'cookieconsent' => '{"enabled":"0","message":"", "link":""}', 'plugins' => '{}'];

        foreach($settings as $config => $var){
            $query = DB::settings()->create();
            $query->config = $config;
            $query->var = $var;
            $query->save();
        }

        DB::schema('splash', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('name');
            $table->text('data');
            $table->timestamp('date');
        });

        DB::schema('stats', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('short');
            $table->bigint('urlid')->index();
            $table->bigint('urluserid', null, '0');
            $table->timestamp('date');
            $table->string('ip')->index();
            $table->string('country')->index();
            $table->string('city')->index();
            $table->string('language')->index();
            $table->string('domain')->index();
            $table->text('referer');
            $table->string('browser')->index();
            $table->string('os')->index();
        });

        DB::schema('url', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');            
            $table->bigint('userid');
            $table->string('alias')->index();
            $table->string('custom')->index();
            $table->text('url');
            $table->text('location');
            $table->text('devices');
            $table->text('domain');
            $table->text('description');
            $table->timestamp('date');
            $table->string('pass');
            $table->bigint('click', null, '0');
            $table->bigint('uniqueclick', null, '0');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('meta_image');
            $table->int('bundle');
            $table->int('public', null, '0');
            $table->int('archived', null, '0');
            $table->string('type');
            $table->string('pixels');
            $table->timestamp('expiry', null);
            $table->text('parameters');
            $table->int('status', null, '1');
            $table->bigint('qrid');
            $table->bigint('profileid');
        });

        DB::schema('user', function($table){
            $table->engine("MYISAM");
            $table->charset("utf8mb4");
            $table->increment('id');    
            $table->text('auth');
            $table->string('auth_id');
            $table->int('admin', null, '0');
            $table->string('email')->index();
            $table->string('username')->index();
            $table->string('name');
            $table->string('password');
            $table->text('address');
            $table->timestamp('date');
            $table->string('api')->index();
            $table->int('active', null, '1');
            $table->int('banned', null, '0');
            $table->int('public', null, '0');
            $table->string('domain');
            $table->int('media', null, '0');
            $table->string('auth_key')->index();
            $table->timestamp('last_payment', null);
            $table->timestamp('expiration', null);
            $table->int('pro', null, '0');
            $table->integer('planid', null, '0');
            $table->string('defaulttype', 50, 'direct');
            $table->bigint('defaultbio');
            $table->bigint('teamid');
            $table->text('teampermission');
            $table->string('secret2fa');
            $table->string('slackid');
            $table->string('zapurl');
            $table->string('zapview');
            $table->int('trial', null, '0');
            $table->text('avatar');
            $table->int('newsletter');
            $table->string('uniquetoken');
            $table->string('paypal');
            $table->double('pendingpayment', '10,2');
        });

        $this->importFaqs();
    }
    /**
     * Faqs
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function importFaqs(){

        $categories = '{"affiliate":{"title":"Affiliate","description":"Questions and answers about our affiliate program."},"pixels":{"title":"Pixels","description":"Pixels are great. Learn how to use to them."},"subscription":{"title":"Subscription","description":"Everything you need to know about your subscription."}}';

        $faqs = [
            ['slug' => 'google-tag-manager-pixel','category' => 'pixels','question' => 'Google Tag Manager Pixel','answer' => '<p>Google Tag Manager allows you to combine hundreds of pixels into a single pixel. Please make sure to add the correct &quot;Container ID&quot; otherwise events will not be tracked!</p><p><code>e.g. GTM-ABC123DE</code></p><p><a href="https://marketingplatform.google.com/about/tag-manager/" target="_blank">Learn more</a></p>','pricing' => '0'],
          
            ['slug' => 'facebook-pixel','category' => 'pixels','question' => 'Facebook Pixel','answer' => '<p>Facebook pixel makes conversion tracking, optimization and remarketing easier than ever. The Facebook pixel ID is usually composed of 16 digits. Please make sure to add the correct value otherwise events will not be tracked!</p> <p><code>e.g. 1234567890123456</code></p><p><a href="https://www.facebook.com/business/a/facebook-pixel" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'google-adwords-conversion-pixel','category' => 'pixels','question' => 'Google Adwords Conversion Pixel','answer' => '<p>With AdWords conversion tracking, you can see how effectively your ad clicks lead to valuable customer activity. The Adwords pixel ID is usually composed of AW followed by 11 digits followed by 19 mixed characters. Please make sure to add the correct value otherwise events will not be tracked!</p><p><code>e.g. AW-12345678901/ABCDEFGHIJKLMOPQRST</code></p><p><a href="https://support.google.com/adwords/answer/1722054?hl=en" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'linkedin-insight-pixel','category' => 'pixels','question' => 'LinkedIn Insight Pixel','answer' => '<p>The LinkedIn Insight Tag is a piece of lightweight JavaScript code that you can add to your website to enable in-depth campaign reporting and unlock valuable insights about your website visitors. You can use the LinkedIn Insight Tag to track conversions, retarget website visitors, and unlock additional insights about members interacting with your ads.!</p><p><code>e.g. 123456</code></p><p><a href="https://www.linkedin.com/help/linkedin/answer/65521" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'twitter-pixel','category' => 'pixels','question' => 'Twitter Pixel','answer' => '<p>Conversion tracking for websites enables you to measure your return on investment by tracking the actions users take after viewing or engaging with your ads on Twitter.</p><p><code>e.g. 123456789</code></p><p><a href="https://business.twitter.com/en/help/campaign-measurement-and-analytics/conversion-tracking-for-websites.html" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'adroll-pixel','category' => 'pixels','question' => 'AdRoll Pixel','answer' => '<p>The AdRoll Pixel is uniquely generated when you create an AdRoll account. The AdRoll ID has two components: the Advertiser ID or adroll_adv_id (X) and Pixel ID or adroll_pix_id (Y) for the AdRoll Pixel. To use the AdRoll Pixel, merge the two components together, separating them by a slash (/).</p><p><code>e.g. adroll_adv_id/adroll_pix_id</code></p><p><a href="https://help.adroll.com/hc/en-us/articles/211846018" target="_blank">Learn more</a></p>','pricing' => '0','created_at' => '2021-11-04 10:46:59'],

            ['slug' => 'quora-pixel','category' => 'pixels','question' => 'Quora Pixel Pixel','answer' => '<p>The Quora Pixel is a tool that is placed in your website code to track traffic and conversions. When someone clicks on your ad and lands on your website, the Quora Pixel allows you to identify how many people are visiting your website and what actions they are taking.</p><p><code>e.g. 1a79a4d60de6718e8e5b326e338ae533</code></p><p><a href="https://quoraadsupport.zendesk.com/hc/en-us/articles/115010466208-How-do-I-install-the-Quora-pixel-" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'can-i-upgrade-my-account-at-any-time','category' => 'subscription','question' => ' Can I upgrade my account at any time?','answer' => '<p>Yes! You can start with our free package and upgrade anytime to enjoy premium features.</p>','pricing' => '1'],

            ['slug' => 'how-will-i-be-charged','category' => 'subscription','question' => 'How will I be charged?','answer' => '<p>You will be charged at the beginning of each period automatically until canceled.</p>','pricing' => '1'],

            ['slug' => 'what-happens-when-i-delete-my-account','category' => 'subscription','question' => 'What happens when I delete my account?','answer' => '<p>Once your account has been deleted, your subscription will be canceled and we will wipe all of your data from our servers including but not limited to your links, traffic data, pixels and all other associated data.</p>','pricing' => '1'],

            ['slug' => 'how-do-refunds-work','category' => 'subscription','question' => ' How do refunds work?','answer' => '<p>Upon request, we will issue a refund at the moment of the request for all <strong>upcoming</strong periods. If you are on a monthly plan, we will stop charging you at the end of your current billing period. If you are on a yearly plan, we will refund amounts for the remaining months.</p>','pricing' => '1']
        ];
        
        \Core\Support\ORM::configure('id_column_overrides', array(
			DBprefix.'settings' => 'config'
		));

        $query = DB::settings()->where('config', 'faqcategories')->first();
        $query->var = $categories;
        $query->save();
       
        foreach($faqs as $request){
            if(DB::faqs()->where('slug', $request['slug'])->first()) continue;
            $faq = DB::faqs()->create();
            $faq->question = $request['question'];
            $faq->slug = $request['slug'];
            $faq->answer = $request['answer'];
            $faq->category = $request['category'];
            $faq->pricing = $request['pricing'];
            $faq->created_at = Helper::dtime();
            $faq->save();
        }
    }
    /**
     * Header
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function header($request){
        echo '<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Premium URL Shortener Installation</title>
                <style type="text/css">
                    :root {--bg: #3f3e50;--ct: #1f1d2b;--color: #fff;--blue: #009ee4;--input: #353340;}*{box-sizing:border-box}body{background-color:var(--bg);font-family:Helvetica, Arial;width:860px;line-height:25px;font-size:13px;margin:0 auto; color:var(--color)}a{color:var(--blue);font-weight:700;text-decoration:none;}a:hover{color:#fff;text-decoration:none;}.container{background: var(--ct);box-shadow: 0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -1px rgba(0,0,0,.06);border-radius: 10px;display: block;overflow: hidden;margin: 50px 0;}.container h1{font-size:20px;display:block;border-bottom:1px solid #15161b;margin:0!important;padding:20px 10px;}.container h2{color:var(--color);font-size:18px;margin:10px; padding: 10px}.container h3{border-bottom:1px solid #15161b;border-radius:3px 0 0 0;text-align:center;margin:0;padding:20px 0;}.left{float:left;width:258px;}.right{float:left;width:601px;border-left:1px solid #15161b;}.form{display:block; padding: 10px 20px;}.form label{font-size:15px;font-weight:700;margin:25px 0px 5px;display: block;}.form label a{float:right;color:var(--blue);font:bold 12px Helvetica, Arial; padding-top: 5px;}.form .input{background:var(--input);display: block;width: 100%;padding: 10px;border: 1px transparent solid;font: bold 15px Helvetica, Arial;color: #9998a3;border-radius: 3px;margin: 10px 0;padding: 10px 25px;}.form .input:focus{border:1px var(--blue) solid;outline:none;color:#fff;}.button{background-color: #4f37ac;font-weight: 700;display:block;text-decoration:none;text-align:center;border-radius: 2px;color:#fff;font:15px Helvetica, Arial bold;cursor:pointer;border-radius:25px;margin:30px auto; padding:10px 30px;border:0;float: right;}.button:active,.button:hover{opacity: 0.9; color: #fff;}.content{color:var(--color);display:block;border-top:1px solid #15161b;margin:10px 0;padding:10px;}li{color:var(--color);}li.current{color:#000;font-weight:700;}li span{float:right;margin-right:10px;font-size:11px;font-weight:700;color:#00B300;}.left > p{border-top:1px solid #15161b;color:var(--color);font-size:12px;margin:0;padding:20px;}.left > p >a{color:var(--blue);}.content > p{color:var(--color);font-weight:700;}span.ok{float:right;border-radius:3px;background-color: #59d8c5;font-weight: 700;background-image: -moz-linear-gradient(0deg, #59d8c5 0%, #68b835 100%);background-image: -webkit-linear-gradient(0deg, #59d8c5 0%, #68b835 100%);background-image: -ms-linear-gradient(0deg, #59d8c5 0%, #68b835 100%);color:#fff;padding:2px 10px;}span.fail{float:right;border-radius:3px;background-color: #FF3146;font-weight: 700;background-image: -moz-linear-gradient(0deg, #f04c74 0%, #FF3146 100%);background-image: -webkit-linear-gradient(0deg, #f04c74 0%, #FF3146 100%);background-image: -ms-linear-gradient(0deg, #f04c74 0%, #FF3146 100%);color:#fff;padding:2px 10px;}span.warning{float:right;border-radius:3px;background:#D27900;color:#fff;padding:2px 10px;}.bg-success,.alert-success{background:#1F800D;color:#fff;font:bold 15px Helvetica, Arial;border:1px solid #000;padding:10px;}.bg-danger,alert-danger{    background-color: #FF3146;background-image: -moz-linear-gradient(0deg, #f04c74 0%, #FF3146 100%);background-image: -webkit-linear-gradient(0deg, #f04c74 0%, #FF3146 100%);background-image: -ms-linear-gradient(0deg, #f04c74 0%, #FF3146 100%);color:#fff;font:bold 15px Helvetica, Arial;margin:0;padding:10px;}.inner,.right > p{margin:10px; padding: 10px;}
                </style>
            </head>
            <body>
            <div class="container">
            <div class="left">
                <h3>Installation Process</h3>
                <ol>
                    <li>Requirements '.($request->segment(1) ? "<span>Completed</span>":"").'</li>
                    <li>Validate Purchase Code '.($request->segment(1) == "database" ? "<span>Completed</span>":"").'</li>
                    <li>Database Installation'.($request->segment(1) == 'user' ?"<span>Completed</span>":"").'</li>
                    <li>Admin Creation'.($request->segment(1) == 'complete' ?"<span>Completed</span>":"").'</li>
                    <li>Installation Complete</li>
                </ol>
                <p>
                    <a href="https://gempixel.com/" target="_blank">Home</a> | 
                    <a href="https://gempixel.com/products" target="_blank">Products</a> | 
                    <a href="https://support.gempixel.com/" target="_blank">Support</a>
                    <p>2012-'.date("Y").' &copy; <a href="https://gempixel.com" target="_blank">GemPixel</a><br>All Rights Reserved.</p>
                </p>
            </div>
            <div class="right">';        
    }
    /**
     * Footer
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function footer(){
                echo '      </div>  		
                </div>
            </body>
        </html>';        
    }
}