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

class Pages {
    /**
     * Custom pages
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){

        $pages = DB::page()->orderByDesc('id')->paginate(15);

        View::set('title', e('Pages'));

        return View::with('admin.pages.index', compact('pages'))->extend('admin.layouts.main');
    }
    /**
     * Add Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function new(){
        
        View::set('title', e('New Page'));

        CDN::load('editor');
        View::push("<script>                        
                        CKEDITOR.replace('editor');
                    </script>", "custom")->toFooter();

        return View::with('admin.pages.new')->extend('admin.layouts.main');
    }
    /**
     * Save page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        \Gem::addMiddleware('DemoProtect');

        $request->save('name', $request->name);
        $request->save('content', $request->content);

        if(!$request->name || !$request->content) return Helper::redirect()->back()->with('danger', e('The name and the content are required.'));

        if($request->slug && DB::page()->where('seo', $request->slug)->first()) return Helper::redirect()->back()->with('danger', e('This slug is already taken, please use another one.'));

        $page = DB::page()->create();
        $page->name = Helper::clean($request->name, 3, true);
        $page->seo = $request->slug ? $request->slug : Helper::slug($page->name);
        $page->content = $request->content;
        $page->category = $request->category;
        $page->lastupdated = Helper::dtime();
        $page->menu = Helper::clean($request->menu);

        $page->save();
        $request->clear();
        return Helper::redirect()->to(route('admin.page'))->with('success', e('Custom page has been added successfully'));
    }
    /**
     * Edit Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        
        if(!$page = DB::page()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Page does not exist.'));
        
        View::set('title', e('Edit Page'));

        CDN::load('editor');    
        View::push("<script>                        
                        CKEDITOR.replace('editor', {
                            allowedContent: true,
                            extraAllowedContent: 'section div',
                        });
                    </script>", "custom")->toFooter();        

        return View::with('admin.pages.edit', compact('page'))->extend('admin.layouts.main');
    }
    /**
     * Update Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        \Gem::addMiddleware('DemoProtect');

        if(!$page = DB::page()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Page does not exist.'));

        if(!$request->name || !$request->content) return Helper::redirect()->back()->with('danger', e('The name and the content are required.'));

        if($request->slug && DB::page()->where('seo', $request->slug)->whereNotEqual('id', $page->id)->first()) return Helper::redirect()->back()->with('danger', e('This slug is already taken, please use another one.'));

        $page->name = Helper::clean($request->name, 3, true);
        $page->seo = $request->slug;
        $page->content = $request->content;
        $page->category = $request->category;
        $page->lastupdated = Helper::dtime();
        $page->menu = Helper::clean($request->menu);

        $page->save();

        return Helper::redirect()->back()->with('success', e('Custom page has been update successfully.'));
    }
    /**
     * Delete Page
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

        if(!Helper::validateNonce($nonce, 'page.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$page = DB::page()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Custom page not found. Please try again.'));
        }
        
        $page->delete();
        return Helper::redirect()->back()->with('success', e('Page has been deleted.'));
    }
}