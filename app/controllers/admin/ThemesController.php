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
use Core\Request;
use Core\View;
use Core\Helper;
use Helpers\App;
use Core\Plugin;

class Themes {

    /**
     * List of files
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private static $files;
    /**
     * Get All Themes
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(Request $request){
        
        // Activate plugin
        if($request->activated){            
            Plugin::dispatch('admin.theme.activate');
        }
        
        $themes = [];

        foreach (new \RecursiveDirectoryIterator(STORAGE."/themes/") as $path){
            
            if($path->isDir() && $path->getFilename() !== "." && $path->getFilename() !== ".." && file_exists(STORAGE."/themes/".$path->getFilename()."/config.json")){          
      
                $data = json_decode(file_get_contents(STORAGE."/themes/".$path->getFilename()."/config.json"));

                $theme = new \stdClass;
                
                $theme->id = $path->getFilename();
                $theme->name = isset($data->name) ? Helper::clean($data->name, 3) : "No Name";
                $theme->author = isset($data->author) ? Helper::clean($data->author, 3) : "Unknown";
                $theme->link = isset($data->link) ? Helper::clean($data->link, 3) : "#none";
                $theme->version = isset($data->version) ? Helper::clean($data->version, 3) : "1.0";
                $theme->date = isset($data->date) ? Helper::clean($data->date, 3) : "";
                $theme->thumbnail = isset($data->thumbnail) ? Helper::clean($data->thumbnail, 3) : null;
      
                $themes[] = $theme;
            }
        }  
        
        View::set('title', e('Themes'));

        return View::with('admin.themes', compact('themes'))->extend('admin.layouts.main');
    }
    /**
     * Clone Theme
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $theme
     * @param string $nonce
     * @return void
     */
    public function clone(string $theme, string $nonce){
        
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'themes.clone')){
            return Helper::redirect()->to(route('admin.themes'))->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!file_exists(STORAGE.'/themes/'.$theme.'/config.json')) return Helper::redirect()->to(route('admin.themes'))->with('danger', e('Invalid theme. Please make sure the theme is up to date and includes a config.json file.'));

        $config = json_decode(file_get_contents(STORAGE."/themes/".$theme."/config.json"));

        $newTheme = $theme.rand(0, 9);

        \Helpers\App::copyFolder(STORAGE.'/themes/'.$theme, STORAGE.'/themes/'.$newTheme);

        $config->name = $config->name.' Copy';

        \file_put_contents(STORAGE.'/themes/'.$newTheme.'/config.json', \json_encode($config));

        Plugin::dispatch('admin.theme.cloned', ['old' => $theme, 'new' => $newTheme]);

        return Helper::redirect()->to(route('admin.themes'))->with('success', e('Theme has been successfully cloned.'));
    }
    /**
     * Delete Theme
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $theme
     * @param string $nonce
     * @return void
     */
    public function delete(string $theme, string $nonce){
        \Gem::addMiddleware('DemoProtect');
        
        if(!Helper::validateNonce($nonce, 'themes.delete')){
            return Helper::redirect()->to(route('admin.themes'))->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(config('theme') == $theme) return Helper::redirect()->to(route('admin.themes'))->with('danger', e('You cannot delete an active theme.'));

        if(!file_exists(STORAGE.'/themes/'.$theme.'/config.json')) return Helper::redirect()->to(route('admin.themes'))->with('danger', e('Invalid theme. Please make sure the theme is up to date and includes a config.json file.'));

        \Helpers\App::deleteFolder(STORAGE.'/themes/'.$theme);

        Plugin::dispatch('admin.theme.deleted', ['theme' => $theme]);

        return Helper::redirect()->to(route('admin.themes'))->with('success', e('Theme has been successfully deleted.'));
    }
    /**
     * Activate Theme
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $theme
     * @return void
     */
    public function activate(string $theme){
        \Gem::addMiddleware('DemoProtect');

        if(!file_exists(STORAGE.'/themes/'.$theme.'/config.json')) return Helper::redirect()->to(route('admin.themes'))->with('danger', e('Invalid theme. Please make sure the theme is up to date and includes a config.json file.'));

        if($theme != config('theme')){
            Plugin::dispatch("admin.theme.deactivate"); 
        }
    
        $setting = DB::settings()->where('config', 'theme')->first();

        $setting->var = $theme;
        $setting->save();

        return Helper::redirect()->to(route('admin.themes', ['activated' => 'true']))->with('success', e('Theme has been successfully activated.'));
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
            if(!$file->mimematch || !in_array($file->ext, ['zip'])) return Helper::redirect()->to(route('admin.themes'))->with('danger', e('The file is not valid. Only .zip files are accepted.'));    
            
            $name = str_replace('.'.$file->extension, '', $file->name);

            $exists = file_exists(STORAGE.'/themes/'.$name);

            $request->move($file, STORAGE.'/themes/');

            $zip = new \ZipArchive();

            $f = $zip->open(STORAGE.'/themes/'.$file->name);
        
            if($f === true) {
              
                if($exists) mkdir(STORAGE.'/themes/'.$name);

                if(!$zip->extractTo(STORAGE.'/themes/'.$name.'/')){
                    return Helper::redirect()->to(route('admin.themes'))->with('danger', e('The file was downloaded but cannot be extracted due to permission.'));
                }
        
                $zip->close();

                if(!file_exists(STORAGE.'/themes/'.$name.'/config.json')){
                    \Helpers\App::deleteFolder(STORAGE.'/themes/'.$name);
                    unlink(STORAGE.'/themes/'.$file->name);
                    return Helper::redirect()->to(route('admin.themes'))->with('danger', e('Invalid theme. Please make sure the theme is up to date and includes a config.json file.'));
                }
              
            } else {
                return Helper::redirect()->to(route('admin.themes'))->with('danger', e('The file cannot be extracted. You can extract it manually.'));
            }

            if(file_exists(STORAGE.'/themes/'.$file->name)){
                unlink(STORAGE.'/themes/'.$file->name);
            }

            return Helper::redirect()->to(route('admin.themes'))->with('success', $exists ? e('Theme has been updated successfully.') : e('Theme has been uploaded successfully.')); 
        }

        return Helper::redirect()->to(route('admin.themes'))->with('danger', e('An unexpected error occurred. Please try again.'));
    }
    /**
     * Theme Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function settings(){
        
        $settings = Plugin::dispatch('admin.theme.getoptions');

        View::set('title', 'Theme Settings');

        return View::with('admin.themesettings', compact('settings'))->extend('admin.layouts.main');
    }
    /**
     * Theme Editor
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function editor(){
        
        View::set('title', 'Theme Editor');

        \Helpers\CDN::load('codeeditor');

        $file = self::current();

        if(_STATE == "DEMO") $file['content'] = 'Hidden in demo';

        View::push('<script type="text/javascript">
                        var editor = ace.edit("code-editor");
                            editor.setTheme("ace/theme/dracula");
                            editor.getSession().setMode("ace/mode/'.$file['type'].'");
                            $("form[data-trigger=codeeditor]").submit(function(e){
                                $("#code").val(editor.getSession().getValue());                                
                            });
                    </script>', 'custom')->toFooter();

        View::push('<style>.card-editor{ background: #282a36; color: #fff;  } #code-editor{min-height: 650px;}</style>', 'custom')->toHeader();

        self::files();

        $themefiles = self::$files;

        return View::with('admin.editor', compact('file', 'themefiles'))->extend('admin.layouts.main');
    }
    /**
     * Current File
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private static function current(){
        $data = [];
        $request = new Request;
        // Get File
        if($request->file && $request->file != "config.json"){

        $file = str_replace(['..', '/', '\\'], '', $request->file);
        $file = str_replace('-', '/', $file);

        if(file_exists(\Core\View::$path."/{$file}")){

            $data["type"] = "php";

            $data["name"] = $request->file;

            $data["current"] = ucwords(str_replace([".", "php", "json"], "", $file))."".($file == "functions" ? "":"");
            $file_name = str_replace("..", "", Helper::clean($file,3,true));
            $file_path = \Core\View::$path."/".$file_name;              
            $data["content"] = htmlentities(file_get_contents($file_path, "r"));
          }else{
            return Helper::redirect()->to(route('admin.themes.editor'))->with("danger","Theme file doesn't exist.");
          }
        }else{
            $data["name"] = "config.json";
            $data["type"] = "json";
            $data["current"]="Configuration File";
            $data["content"] = htmlentities(file_get_contents(\Core\View::$path."/config.json"));
        }

        return $data;
    }
    /**
     * Get theme files
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private static function files($directory = null){

        $directory = $directory ?: \Core\View::$path;

        foreach (new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS) as $path){

            if($path->getFilename() == "." || $path->getFilename() == "..") continue;

            if($path->getFilename() == "admin" || strpos($path->getFilename(), 'admin') !== false) continue;

            if($path->isDir()) self::files($path);
            
            if(!in_array(Helper::extension($path->getFileName()), ['json', 'php'])) continue;

            $pt = str_replace(['/', '\\'],'-', str_replace(\Core\View::$path, '', $path->getPath()));

            if($path->getFilename() == 'config.json') {
                $name = 'Configuration File';
            } else {
                $name = ucwords(str_replace(["_",".","-"], " ", str_replace(['php', 'json'], '',  $pt.' '. $path->getFileName())));
            }

            self::$files[] = ['file' => trim($pt.'-'.$path->getFileName(), '-'), 'name' => $name];
        }
    }
    /**
     * Update theme file
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function update(Request $request){

        \Gem::addMiddleware('DemoProtect');

        $file = str_replace(['..', '/', '\\'], '', $request->file);
        $file = str_replace('-', '/', $file);
        
        if(file_exists(\Core\View::$path.'/'.$file)){        
            $f = fopen(\Core\View::$path.'/'.$file, 'w') or die( Helper::redirect()->back()->with("danger", e("Cannot open file. Please make sure that the file is writable.")));
            fwrite($f, $request->code);
            fclose($f);
            return Helper::redirect()->back()->with("success", e("File has been successfully updated."));
        }
        return Helper::redirect()->back()->with("danger", e("Cannot open file. Please make sure that the file is writable."));
    }
    /**
     * Custom CSS/JS
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function custom(){
        
        \Helpers\CDN::load('codeeditor');

        View::push('<script type="text/javascript">
                        var csseditor = ace.edit("customheader");
                            csseditor.setTheme("ace/theme/dracula");
                            csseditor.getSession().setMode("ace/mode/html");
                        var jseditor = ace.edit("customfooter");
                            jseditor.setTheme("ace/theme/dracula");
                            jseditor.getSession().setMode("ace/mode/html")
                        $(document).ready(function(){
                            $("form[data-trigger=codeeditor]").submit(function(){
                                $("#customhead").val(csseditor.getSession().getValue());
                                $("#customfoot").val(jseditor.getSession().getValue());
                            });
                        });
                    </script>', 'custom')->toFooter();

        View::push('<style>.card-editor{ background: #282a36; color: #fff;  } #customheader,#customfooter{min-height: 350px;}</style>', 'custom')->toHeader();

        View::set('title', e('Custom Code'));

        return View::with('admin.custom')->extend('admin.layouts.main');
    }
    /**
     * Save Custom
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function customUpdate(Request $request){

        \Gem::addMiddleware('DemoProtect');
                
        $setting = DB::settings()->where('config', 'customheader')->first();

        $setting->var = htmlentities($request->customheader);
        $setting->save();

        $setting = DB::settings()->where('config', 'customfooter')->first();

        $setting->var = htmlentities($request->customfooter);
        $setting->save();
        
        return Helper::redirect()->back()->with("success", e("Custom code has been successfully saved."));        
    }
}