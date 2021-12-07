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
use Core\Localization;
use Core\Plugin;

class Languages {
    /**
     * List Languages
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){

        View::set('title', 'Languages');
        
        $languages = [];

        foreach(Localization::list() as $lang){
            $data = include($lang['path'].'/app.php');
            
            $total = count($data['data']) > 0 ? count($data['data']) : 1;
            $filled = count(array_filter($data['data']));
            $data['percent'] = round(($filled / $total)*100, 1);
            $languages[] = $data;
        }

        return View::with('admin.languages.index', compact('languages'))->extend('admin.layouts.main');

    }
    /**
     * Set language as default
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $code
     * @return void
     */
    public function set($code){

        

        $setting = DB::settings()->where('config', 'default_lang')->first();

        $setting->var = $code;
        $setting->save();

        return back()->with('success', e('Language has been set as default.'));
    }
    /**
     * New Languages
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function new(){

        $sample = include(LOCALE.'/sample.php');

        $strings = $sample['data'];

        View::set('title', e('Create Translation'));

        return View::with('admin.languages.new', compact('strings'))->extend('admin.layouts.main');
    }
    /**
     * Create Translation
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        if(!$request->code){
            $request->code = substr($request->name, 0, 2);
        }

        $lang = [    
            "code" => strtolower($request->code),
            "region" => strtolower($request->code),
            "name" => $request->name,
            "author" => config('title'),
            "link" => config('url'),
            "date" => Helper::dtime('now', 'd/m/Y'),
            "rtl" => $request->rtl ? true : false
        ];

        $lang['data'] = [];

        foreach($request->string as $i => $string){
            if(empty($request->base[$i])) continue;
            $lang['data'][$request->base[$i]] = $string;
        }

        if(!file_exists(LOCALE.'/'.$request->code)){
            \mkdir(LOCALE.'/'.$request->code, 755);
        }
        $data = var_export($lang, true);
        $file = fopen(LOCALE.'/'.$request->code.'/app.php', 'w') or die(back()->with('error', e('Cannot open file {f}. Please check permission.', null, ['f' => LOCALE.'/'.$request->code.'/app.php'])));

        fwrite($file, "<?php\n return {$data};");
        fclose($file);

        return Helper::redirect()->to(route('admin.languages'))->with('success', e('Translation file successfully created.'));
    }
    /**
     * Edit Language
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $code
     * @return void
     */
    public function edit(string $code){

        $data = include(LOCALE."/{$code}/app.php");

        View::set('title', e('Update Translation'));

        return View::with('admin.languages.edit', $data)->extend('admin.layouts.main');        
    }
    /**
     * Update Language
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param string $code
     * @return void
     */
    public function update(Request $request, string $code){
        $lang = [    
            "code" => strtolower($code),
            "region" => strtolower($code),
            "name" => $request->name,
            "author" => config('title'),
            "link" => config('url'),
            "date" => Helper::dtime('now', 'd/m/Y'),
            "rtl" => $request->rtl ? true : false
        ];

        $lang['data'] = [];

        foreach($request->string as $i => $string){
            if(empty($request->base[$i])) continue;
            $lang['data'][$request->base[$i]] = $string;
        }

        if(!file_exists(LOCALE.'/'.$code)){
            \mkdir(LOCALE.'/'.$code, 755);
        }
        $data = var_export($lang, true);
        $file = fopen(LOCALE.'/'.$code.'/app.php', 'w') or die(back()->with('error', e('Cannot open file {f}. Please check permission.', null, ['f' => LOCALE.'/'.$code.'/app.php'])));

        fwrite($file, "<?php\n return {$data};");
        fclose($file);

        return back()->with('success', e('Translation file successfully updated.'));
    }
    /**
     * Translate using Google Translate
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function translate(Request $request){

        $trans = new \Helpers\GoogleTranslate();

        try{

            $translated = $trans->translate('en', $request->lang, $request->string);

        }catch(\Exception $e){

            return Response::factory('error')->send(); 
        }

        return Response::factory($translated)->send();
    }
    /**
     * Delete Language file
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $code
     * @param string $nonce
     * @return void
     */
    public function delete(string $code, string $nonce){

        \Gem::addMiddleware('DemoProtect');
        
        if(!Helper::validateNonce($nonce, 'language.delete')){
            return Helper::redirect()->to(route('admin.languages'))->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        \Helpers\App::deleteFolder(LOCALE.'/'.$code);

        Plugin::dispatch('admin.language.deleted', ['language' => $code]);

        return Helper::redirect()->to(route('admin.languages'))->with('success', e('Language has been successfully deleted.'));
    }

    /**
     * Upload File
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function upload(Request $request){
        
        \Gem::addMiddleware('DemoProtect');

        if($file = $request->file('file')){        

            if(!$file->mimematch || !in_array($file->ext, ['zip'])) return Helper::redirect()->to(route('admin.languages'))->with('danger', e('The file is not valid. Only .zip files are accepted.'));    

            $file->move($file, LOCALE);

            $zip = new \ZipArchive();

            $f = $zip->open(LOCALE.'/'.$file->name);
        
            if($f === TRUE) {
              
              if(!$zip->extractTo(LOCALE."/")){
                return Helper::redirect()->to(route('admin.languages'))->with('danger', e('The file was downloaded but cannot be extracted due to permission.'));
              }
        
              $zip->close();
              
            } else {
                return Helper::redirect()->to(route('admin.languages'))->with('danger', e('The file cannot be extracted. You can extract it manually.'));
            }

            if(file_exists(LOCALE.'/'.$file->name)){
                unlink(LOCALE.'/'.$file->name);
            }

            return Helper::redirect()->to(route('admin.languages'))->with('success', e('Language has been uploaded successfully.')); 
        }

        return Helper::redirect()->to(route('admin.languages'))->with('danger', e('An unexpected error occurred. Please try again.'));
    }

}