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
use Models\User;

class Plugins {	
    /**
     * Plugins Home
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){

        $plugins = [];

        foreach (new \RecursiveDirectoryIterator(STORAGE."/plugins/") as $path){
            
            if($path->isDir() && $path->getFilename() !== "." && $path->getFilename() !== ".." && file_exists(STORAGE."/plugins/".$path->getFilename()."/config.json")){          

                $data = json_decode(file_get_contents(STORAGE."/plugins/".$path->getFilename()."/config.json"));

                $plugin = new \stdClass;
                
                $plugin->id = $path->getFilename();
                $plugin->name = isset($data->name) ? Helper::clean($data->name, 3) : "No Name";
                $plugin->author = isset($data->author) ? Helper::clean($data->author, 3) : "Unknown";
                $plugin->link = isset($data->link) ? Helper::clean($data->link, 3) : "#none";
                $plugin->version = isset($data->version) ? Helper::clean($data->version, 3) : "1.0";
                $plugin->description = isset($data->description) ? Helper::clean($data->description, 3) : "";

                $plugin->enabled = isset(config('plugins')->{$plugin->id}) ? true : false;

                $plugins[] = $plugin;
            }
        }  

        View::set('title', e('Plugins'));

        return View::with('admin.plugins', compact('plugins'))->extend('admin.layouts.main');
    }
    /**
     * Activate
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $id
     * @return void
     */
    public function activate($id){

        if(!file_exists(STORAGE."/plugins/".$id."/config.json")){
            return back()->with('danger', e('Plugin does not exist.'));
        }

        $plugins = config('plugins');

        if(isset($plugins->{$id})) return back()->with('danger', e('Plugin is already active.')); 

        $plugins->$id = ['settings' => []];
        
        

        $settings = DB::settings()->where('config', 'plugins')->first();
        $settings->var = json_encode($plugins);
        $settings->save();

        return back()->with('success', e('Plugin was successfully activated.'));
    }

     /**
     * Disable
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $id
     * @return void
     */
    public function disable($id){

        $plugins = config('plugins');

        if(!isset($plugins->{$id})) return back()->with('danger', e('Plugin is already disabled.')); 

        unset($plugins->{$id});            

        $settings = DB::settings()->where('config', 'plugins')->first();
        $settings->var = json_encode($plugins);
        $settings->save();

        return back()->with('success', e('Plugin was successfully disabled.'));
    }

    /**
     * Upload Plugin
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function upload(Request $request){
        
        \Gem::addMiddleware('DemoProtect');

        if($file = $request->file('file')){       

            if(!$file->mimematch || !in_array($file->ext, ['zip'])) return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('The file is not valid. Only .zip files are accepted.'));    

            $name = str_replace('.'.$file->extension, '', $file->name);

            $exists = file_exists(PLUGIN.'/'.$name);

            $request->move($file, PLUGIN);

            $zip = new \ZipArchive();

            $f = $zip->open(PLUGIN.'/'.$file->name);
        
            if($f === TRUE) {

                if($exists) mkdir(PLUGIN.'/'.$name);
              
                if(!$zip->extractTo(PLUGIN."/".$name."/")){
                    return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('The file was downloaded but cannot be extracted due to permission.'));
                }
        
                $zip->close();

                if(!file_exists(PLUGIN.'/'.$name.'/config.json')){
                    \Helpers\App::deleteFolder(PLUGIN.'/'.$name);
                    unlink(PLUGIN.'/'.$file->name);
                    return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('Invalid plugin. Please make sure the plugin is up to date and includes a config.json file.'));
                }
              
            } else {
                return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('The file cannot be extracted. You can extract it manually.'));
            }

            if(file_exists(PLUGIN.'/'.$file->name)){
                unlink(PLUGIN.'/'.$file->name);
            }

            return Helper::redirect()->to(route('admin.plugins'))->with('success', $exists ? e('PLugin has been updated successfully.') : e('PLugin has been uploaded successfully.')); 
        }

        return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('An unexpected error occurred. Please try again.'));
    }
}