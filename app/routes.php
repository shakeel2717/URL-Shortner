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
use Core\Helper;
use Core\Localization;

\Helpers\App::checkEncryption();

// Homepage
Gem::get('/', 'Home@index')->name('home')->middleware('CheckDomain')->middleware('CheckMaintenance')->middleware('CheckPrivate');
// Pricing Page
Gem::get('/pricing', 'Subscription@pricing')->name('pricing')->middleware('CheckDomain')->middleware('CheckMaintenance');
Gem::get('/checkout/{id}/{type}', 'Subscription@checkout')->name('checkout');
Gem::post('/checkout/{id}/{type}', 'Subscription@process')->middleware('Auth')->name('checkout.process');
Gem::get('/checkout/{id}/{type}/coupon', 'Subscription@coupon')->middleware('Auth')->name('checkout.coupon');

// Custom Page
Gem::get('/page/{page}', 'Page@index')->name('page')->middleware('CheckDomain')->middleware('CheckMaintenance');
Gem::get('/qr-codes', 'Page@qr')->name('page.qr')->middleware('CheckDomain')->middleware('CheckMaintenance');
Gem::get('/bio-profiles', 'Page@bio')->name('page.bio')->middleware('CheckDomain')->middleware('CheckMaintenance');

// Contact Page
Gem::get('/contact', 'Page@contact')->name('contact')->middleware('CheckDomain');
Gem::post('/contact/send', 'Page@contactSend')->middleware('BlockBot')->middleware('CheckDomain')->middleware('ValidateCaptcha')->name('contact.send');
// Report Page
Gem::get('/report', 'Page@report')->name('report')->middleware('CheckDomain');
Gem::post('/report/send', 'Page@reportSend')->middleware('BlockBot')->middleware('CheckDomain')->middleware('ValidateCaptcha')->name('report.send');

Gem::get('/developers', 'Page@api')->name('apidocs')->middleware('CheckDomain')->middleware('CheckMaintenance');

// Blog Group
Gem::group('/blog', function(){
    Gem::setMiddleware('CheckDomain');
    Gem::get('/', 'Blog@index')->name('blog');
    Gem::get('/{post}', 'Blog@post')->name('blog.post');
});

Gem::post('/shorten', 'Link@shorten')->name('shorten')->middleware('BlockBot');

Gem::get('/faq', 'Page@faq')->name('faq')->middleware('CheckDomain');

Gem::get('/affiliate', 'Page@affiliate')->name('affiliate')->middleware('CheckDomain');   

Gem::get('/u/{username}', 'Link@profile')->name('profile')->middleware('CheckDomain'); 

Gem::group('/user', function(){ 
    
    Gem::get('/login', 'Users@login')->middleware('CheckDomain')->middleware('UserLogged')->name('login');
    Gem::post('/login/auth', 'Users@loginAuth')->middleware('BlockBot')->middleware('CheckDomain')->middleware('UserLogged')->middleware('ValidateCaptcha')->name('login.auth');
    Gem::get('/login/2fa', 'Users@login2FA')->middleware('CheckDomain')->middleware('UserLogged')->name('login.2fa');
    Gem::post('/login/2fa/validate', 'Users@login2FAValidate')->middleware('CheckDomain')->middleware('UserLogged')->name('login.2fa.validate');
    Gem::get('/login/facebook', 'Users@loginWithFacebook')->middleware('CheckDomain')->middleware('UserLogged')->name('login.facebook');
    Gem::get('/login/twitter', 'Users@loginWithTwitter')->middleware('CheckDomain')->middleware('UserLogged')->name('login.twitter');
    Gem::get('/login/google', 'Users@loginWithGoogle')->middleware('CheckDomain')->middleware('UserLogged')->name('login.google');

    Gem::get('/register', 'Users@register')->middleware('CheckDomain')->middleware('UserLogged')->name('register');
    Gem::post('/register/validate', 'Users@registerValidate')->middleware('BlockBot')->middleware('UserLogged')->middleware('ValidateCaptcha')->name('register.validate');

    Gem::get('/login/forgot', 'Users@forgot')->middleware('CheckDomain')->name('forgot');
    Gem::post('/login/forgot/send', 'Users@forgotSend')->middleware('CheckDomain')->middleware('ValidateCaptcha')->name('forgot.send');
    Gem::get('/login/reset/{token}', 'Users@reset')->middleware('CheckDomain')->name('reset');
    Gem::post('/login/reset/{token}/change', 'Users@resetChange')->middleware('CheckDomain')->name('reset.change');
    Gem::get('/activate/{token}', 'Users@activate')->middleware('CheckDomain')->name('activate');
    Gem::get('/invited/{token}', 'Users@invited')->middleware('CheckDomain')->name('invited');
    Gem::post('/invited/{token}/accept', 'Users@acceptInvitation')->middleware('CheckDomain')->name('acceptinvitation');

    // Protect all routes below with Auth Middleware
    Gem::setMiddleware(['CheckDomain', 'Auth']);

    Gem::get('/','User\Dashboard@index')->name('dashboard');
    Gem::get('/logout', 'Users@logout')->name('logout');
    
    Gem::get('/links', 'User\Dashboard@links')->name('links');
    Gem::get('/links/archived', 'User\Dashboard@archived')->name('archive');
    Gem::get('/links/expired', 'User\Dashboard@expired')->name('expired');
    Gem::get('/links/refresh', 'User\Dashboard@refresh')->name('links.refresh');
    Gem::get('/links/refresh/archive', 'User\Dashboard@refreshArchive')->name('links.refresh.archive');
    Gem::get('/links/{id}/delete/{token}', 'Link@delete')->name('links.delete');
    Gem::post('/links/deleteselected', 'Link@deleteMany')->name('links.deleteall');
    Gem::get('/links/archiveselected', 'Link@archiveSelected')->name('links.archive');
    Gem::get('/links/unarchiveselected', 'Link@unarchiveSelected')->name('links.unarchive');
    Gem::get('/links/publicselected', 'Link@publicSelected')->name('links.public');
    Gem::get('/links/privateselected', 'Link@privateSelected')->name('links.private');    
    Gem::post('/links/addtocampaign', 'Link@addtocampaign')->name('links.addtocampaign');
    Gem::get('/links/{id}/edit', 'Link@edit')->name('links.edit');
    Gem::post('/links/{id}/update', 'Link@update')->name('links.update');

    Gem::get('/campaigns', 'User\Campaigns@index')->name('campaigns');
    Gem::post('/campaigns/save', 'User\Campaigns@save')->name('campaigns.save');
    Gem::post('/campaigns/{id}/update', 'User\Campaigns@update')->name('campaigns.update');
    Gem::get('/campaigns/{id}/delete/{token}', 'User\Campaigns@delete')->name('campaigns.delete');
    Gem::get('/campaigns/{id}/stats', 'User\Campaigns@stats')->name('campaigns.stats');
    Gem::get('/campaigns/{id}/statistics/clicks', 'User\Campaigns@statsClicks')->name('campaigns.stats.clicks');
    Gem::get('/campaigns/{id}/statistics/map', 'User\Campaigns@statsMap')->name('campaigns.stats.map');
    Gem::get('/campaigns/{id}/statistics/browser', 'User\Campaigns@statsBrowser')->name('campaigns.stats.browser');
    Gem::get('/campaigns/{id}/statistics/os', 'User\Campaigns@statsOs')->name('campaigns.stats.os');

    Gem::get('/search', 'User\Dashboard@search')->name('search');

    Gem::get('/tools', 'User\Tools@index')->name('tools');
    Gem::get('/tools/slack', 'User\Tools@slack')->name('user.slack');
    Gem::post('/tools/zapier', 'User\Tools@zapier')->name('user.zapier');
    

    Gem::get('/billing', 'User\Account@billing')->name('billing');
    Gem::post('/billing/cancel', 'User\Account@billingCancel')->name('cancel');
    Gem::post('/terminate', 'User\Account@terminate')->name('terminate');
    Gem::get('/verify', 'User\Account@verify')->name('verify');
    Gem::get('/settings', 'User\Account@settings')->name('settings');        
    Gem::post('/settings/update', 'User\Account@settingsUpdate')->name('settings.update');        
    Gem::post('/settings/api/regenerate', 'User\Account@regenerateApi')->name('regenerateapi');        
    Gem::get('/twofa/{action}/{nonce}', 'User\Account@twoFA')->name('2fa');        
    
    Gem::get('/splash/', 'User\Splash@index')->name('splash');
    Gem::get('/splash/create', 'User\Splash@create')->name('splash.create');
    Gem::post('/splash/save', 'User\Splash@save')->name('splash.save');
    Gem::get('/splash/{id}/edit', 'User\Splash@edit')->name('splash.edit');
    Gem::post('/splash/{id}/update', 'User\Splash@update')->name('splash.update');
    Gem::get('/splash/{id}/toggle', 'User\Splash@toggle')->name('splash.toggle');
    Gem::get('/splash/{id}/delete/{nonce}', 'User\Splash@delete')->name('splash.delete');

    Gem::get('/overlay/', 'User\Overlay@index')->name('overlay');
    Gem::get('/overlay/create[/{action}]', 'User\Overlay@create')->name('overlay.create');
    Gem::post('/overlay/save/{action}', 'User\Overlay@save')->name('overlay.save');
    Gem::get('/overlay/{id}/edit', 'User\Overlay@edit')->name('overlay.edit');
    Gem::post('/overlay/{id}/update', 'User\Overlay@update')->name('overlay.update');
    Gem::get('/overlay/{id}/delete/{nonce}', 'User\Overlay@delete')->name('overlay.delete');

    Gem::get('/pixels/', 'User\Pixels@index')->name('pixel');
    Gem::get('/pixels/create', 'User\Pixels@create')->name('pixel.create');
    Gem::post('/pixels/save', 'User\Pixels@save')->name('pixel.save');
    Gem::get('/pixels/{id}/edit', 'User\Pixels@edit')->name('pixel.edit');
    Gem::post('/pixels/{id}/update', 'User\Pixels@update')->name('pixel.update');
    Gem::get('/pixels/{id}/delete/{nonce}', 'User\Pixels@delete')->name('pixel.delete');

    Gem::get('/domains/', 'User\Domains@index')->name('domain');
    Gem::get('/domains/create', 'User\Domains@create')->name('domain.create');
    Gem::post('/domains/save', 'User\Domains@save')->name('domain.save');
    Gem::get('/domains/{id}/delete/{nonce}', 'User\Domains@delete')->name('domain.delete');
    Gem::get('/domains/{id}/edit', 'User\Domains@edit')->name('domain.edit');
    Gem::post('/domains/{id}/update', 'User\Domains@update')->name('domain.update');

    Gem::get('/teams/', 'User\Teams@index')->name('team');
    Gem::post('/teams/invite', 'User\Teams@invite')->name('team.save');
    Gem::get('/teams/{team}/user/{id}/remove/{nonce}', 'User\Teams@delete')->name('team.delete');
    Gem::get('/teams/{id}/edit', 'User\Teams@edit')->name('team.edit');
    Gem::post('/teams/{id}/update', 'User\Teams@update')->name('team.update');


    Gem::get('/qr/', 'User\QR@index')->name('qr');
    Gem::get('/qr/create', 'User\QR@create')->name('qr.create');
    Gem::post('/qr/preview', 'User\QR@preview')->name('qr.preview');
    Gem::post('/qr/save', 'User\QR@save')->name('qr.save');
    Gem::get('/qr/{id}/edit', 'User\QR@edit')->name('qr.edit');
    Gem::post('/qr/{id}/update', 'User\QR@update')->name('qr.update');
    Gem::get('/qr/{id}/delete/{nonce}', 'User\QR@delete')->name('qr.delete');

    Gem::get('/bio/', 'User\Bio@index')->name('bio');
    Gem::get('/bio/create', 'User\Bio@create')->name('bio.create');
    Gem::post('/bio/preview', 'User\Bio@preview')->name('bio.preview');
    Gem::post('/bio/save', 'User\Bio@save')->name('bio.save');
    Gem::get('/bio/{id}/edit', 'User\Bio@edit')->name('bio.edit');
    Gem::post('/bio/{id}/update', 'User\Bio@update')->name('bio.update');
    Gem::get('/bio/{id}/delete/{nonce}', 'User\Bio@delete')->name('bio.delete');
    Gem::get('/bio/{id}/default', 'User\Bio@default')->name('bio.default');
    
    Gem::get('/statistics', 'User\Stats@index')->name('user.stats');
    Gem::get('/statistics/alllinks', 'User\Stats@statsLinks')->name('user.stats.links');
    Gem::get('/statistics/allclicks', 'User\Stats@statsClicks')->name('user.stats.clicks');
    Gem::get('/statistics/map', 'User\Stats@clicksMap')->name('user.stats.map');
    Gem::get('/statistics/clicks', 'User\Dashboard@statsClicks')->name('user.clicks');   
     
    
    Gem::get('/affiliate', 'User\Dashboard@affiliate')->name('user.affiliate');   
    
    Gem::get('/invoice/{id}','User\Account@invoice')->name('invoice');

    Gem::get('/export/links', 'User\Export@links')->name('user.export.links');
    Gem::post('/export/statistics', 'User\Export@stats')->name('user.stats.export');
    Gem::get('/export/statistics/{id}', 'User\Export@single')->name('links.stats.export');
    Gem::post('/export/campaigns/{id}', 'User\Export@campaign')->name('campaigns.export');
});

Gem::group('/admin', function(){
    // Protect all routes with Admin Auth Middleware
    Gem::setMiddleware('Auth@admin');

    Gem::get('/', 'Admin\Dashboard@index')->name('admin');

    Gem::post('/verify', 'Admin\Settings@verify')->name('admin.verify');
    
    Gem::get('/statistics', 'Admin\Stats@index')->name('admin.stats');
    Gem::get('/statistics/links', 'Admin\Stats@statsLinks')->name('admin.stats.links');
    Gem::get('/statistics/users', 'Admin\Stats@statsUsers')->name('admin.stats.users');
    Gem::get('/statistics/clicks', 'Admin\Stats@statsClicks')->name('admin.stats.clicks');
    Gem::get('/statistics/map', 'Admin\Stats@clicksMap')->name('admin.stats.map');
    Gem::get('/statistics/memberships', 'Admin\Stats@memberships')->name('admin.stats.membership');

    Gem::get('/search', 'Admin\Dashboard@search')->name('admin.search');
    // Plans
    Gem::get('/plans', 'Admin\Plans@index')->name('admin.plans');
    Gem::get('/plans/new', 'Admin\Plans@new')->name('admin.plans.new');
    Gem::post('/plans/save', 'Admin\Plans@save')->name('admin.plans.save');    
    Gem::get('/plans/{id}/delete/{nonce}', 'Admin\Plans@delete')->name('admin.plans.delete');
    Gem::get('/plans/{id}/edit', 'Admin\Plans@edit')->name('admin.plans.edit');
    Gem::post('/plans/{id}/update', 'Admin\Plans@update')->name('admin.plans.update');    
    Gem::get('/plans/sync', 'Admin\Plans@sync')->name('admin.plans.sync');    
    Gem::get('/subscriptions', 'Admin\Membership@subscriptions')->name('admin.subscriptions');
    Gem::get('/payments', 'Admin\Membership@payments')->name('admin.payments');
    Gem::get('/payments/{id}/invoice','Admin\Membership@invoice')->name('admin.invoice');
    Gem::get('/payments/{id}/delete/{nonce}','Admin\Membership@delete')->name('admin.payments.delete');
    Gem::get('/payments/{id}/{action}','Admin\Membership@markAs')->name('admin.payments.markas');
    // Coupons
    Gem::get('/coupons', 'Admin\Coupons@index')->name('admin.coupons');
    Gem::post('/coupons/save', 'Admin\Coupons@save')->name('admin.coupons.save');
    Gem::get('/coupons/{id}/delete/{nonce}', 'Admin\Coupons@delete')->name('admin.coupons.delete');
    Gem::post('/coupons/{id}/update', 'Admin\Coupons@update')->name('admin.coupons.update');

    // Links
    Gem::get('/links', 'Admin\Links@index')->name('admin.links');
    Gem::get('/links/{id}/delete/{nonce}', 'Admin\Links@delete')->name('admin.links.delete');
    Gem::post('/links/delete/all', 'Admin\Links@deleteAll')->name('admin.links.deleteall');
    Gem::get('/links/{id}/edit', 'Admin\Links@edit')->name('admin.links.edit');
    Gem::post('/links/{id}/update', 'Admin\Links@update')->name('admin.links.update');
    Gem::get('/links/{id}/view', 'Admin\Links@view')->name('admin.links.view');
    Gem::get('/links/expired', 'Admin\Links@expired')->name('admin.links.expired');
    Gem::get('/links/archived', 'Admin\Links@archived')->name('admin.links.archived');
    Gem::get('/links/pending', 'Admin\Links@pending')->name('admin.links.pending');
    Gem::get('/links/report', 'Admin\Links@report')->name('admin.links.report');
    Gem::get('/links/report/{id}/{action}', 'Admin\Links@reportAction')->name('admin.links.report.action');
    Gem::get('/links/bad', 'Admin\Links@bad')->name('admin.links.bad');
    Gem::get('/links/bad/{id}/cancel', 'Admin\Links@badCancel')->name('admin.links.bad.cancel');
    Gem::get('/links/{id}/disable', 'Admin\Links@disable')->name('admin.links.disable');
    Gem::get('/links/{id}/approve', 'Admin\Links@approve')->name('admin.links.approve');
    Gem::route(['GET', 'POST'], '/links/import', 'Admin\Links@import')->name('admin.links.import');
    // Users
    Gem::get('/users', 'Admin\Users@index')->name('admin.users');
    Gem::get('/users/new', 'Admin\Users@new')->name('admin.users.new');
    Gem::post('/users/save', 'Admin\Users@save')->name('admin.users.save');
    Gem::get('/users/inactive', 'Admin\Users@inactive')->name('admin.users.inactive');
    Gem::get('/users/banned', 'Admin\Users@banned')->name('admin.users.banned');
    Gem::get('/users/admins', 'Admin\Users@admin')->name('admin.users.admin');
    Gem::get('/users/{id}/edit', 'Admin\Users@edit')->name('admin.users.edit');
    Gem::post('/users/{id}/update', 'Admin\Users@update')->name('admin.users.update');
    Gem::get('/users/{id}/delete/{nonce}', 'Admin\Users@delete')->name('admin.users.delete');
    Gem::get('/users/{id}/wipe/{nonce}', 'Admin\Users@wipe')->name('admin.users.delete.all');
    Gem::post('/user/delete/all', 'Admin\Users@deleteAll')->name('admin.users.deleteall');
    Gem::get('/users/{id}/ban', 'Admin\Users@ban')->name('admin.users.ban');
    Gem::get('/users/{id}/view', 'Admin\Users@view')->name('admin.users.view');

    Gem::get('/users/testimonials', 'Admin\Users@testimonial')->name('admin.testimonial');
    Gem::post('/users/testimonial/save', 'Admin\Users@testimonialSave')->name('admin.testimonial.save');
    Gem::get('/users/testimonial/{id}/edit', 'Admin\Users@testimonialEdit')->name('admin.testimonial.edit');
    Gem::post('/users/testimonial/{id}/update', 'Admin\Users@testimonialUpdate')->name('admin.testimonial.update');
    Gem::get('/users/testimonial/{id}/delete/{nonce}', 'Admin\Users@testimonialDelete')->name('admin.testimonial.delete');

    Gem::get('/users/login/{id}/{nonce}', 'Admin\Users@loginAs')->name('admin.users.login');

    //Pages
    Gem::get('/page', 'Admin\Pages@index')->name('admin.page');
    Gem::get('/page/new', 'Admin\Pages@new')->name('admin.page.new');
    Gem::post('/page/save', 'Admin\Pages@save')->name('admin.page.save');
    Gem::get('/page/{id}/edit', 'Admin\Pages@edit')->name('admin.page.edit');
    Gem::post('/page/{id}/update', 'Admin\Pages@update')->name('admin.page.update');
    Gem::get('/page/{id}/delete/{nonce}', 'Admin\Pages@delete')->name('admin.page.delete');    
    // Blog
    Gem::get('/blog', 'Admin\Blog@index')->name('admin.blog');
    Gem::get('/blog/new', 'Admin\Blog@new')->name('admin.blog.new');
    Gem::post('/blog/save', 'Admin\Blog@save')->name('admin.blog.save');
    Gem::get('/blog/{id}/edit', 'Admin\Blog@edit')->name('admin.blog.edit');
    Gem::post('/blog/{id}/update', 'Admin\Blog@update')->name('admin.blog.update');
    Gem::get('/blog/{id}/delete/{nonce}', 'Admin\Blog@delete')->name('admin.blog.delete');
    // Domains
    Gem::get('/domains', 'Admin\Domains@index')->name('admin.domains');
    Gem::get('/domains/new', 'Admin\Domains@new')->name('admin.domains.new');
    Gem::post('/domains/save', 'Admin\Domains@save')->name('admin.domains.save');
    Gem::get('/domains/{id}/edit', 'Admin\Domains@edit')->name('admin.domains.edit');
    Gem::post('/domains/{id}/update', 'Admin\Domains@update')->name('admin.domains.update');    
    Gem::get('/domains/{id}/disable', 'Admin\Domains@disable')->name('admin.domains.disable');
    Gem::get('/domains/{id}/activate', 'Admin\Domains@activate')->name('admin.domains.activate');
    Gem::get('/domains/{id}/pending', 'Admin\Domains@pending')->name('admin.domains.pending');
    Gem::get('/domains/{id}/delete/{nonce}', 'Admin\Domains@delete')->name('admin.domains.delete');
    // FAQS
    Gem::get('/faq', 'Admin\Faqs@index')->name('admin.faq');
    Gem::get('/faq/new', 'Admin\Faqs@new')->name('admin.faq.new');
    Gem::post('/faq/save', 'Admin\Faqs@save')->name('admin.faq.save');
    Gem::get('/faq/{id}/edit', 'Admin\Faqs@edit')->name('admin.faq.edit');
    Gem::post('/faq/{id}/update', 'Admin\Faqs@update')->name('admin.faq.update');
    Gem::get('/faq/{id}/delete/{nonce}', 'Admin\Faqs@delete')->name('admin.faq.delete');
    Gem::get('/faq/categories', 'Admin\Faqs@categories')->name('admin.faq.categories');
    Gem::post('/faq/categories/save', 'Admin\Faqs@categoriesSave')->name('admin.faq.categories.save');
    Gem::get('/faq/categories/{id}/edit', 'Admin\Faqs@categoriesEdit')->name('admin.faq.categories.edit');
    Gem::post('/faq/categories/{id}/update', 'Admin\Faqs@categoriesUpdate')->name('admin.faq.categories.update');
    Gem::get('/faq/categories/{id}/delete/{nonce}', 'Admin\Faqs@categoriesDelete')->name('admin.faq.categories.delete');
    
    // Affiliates
    Gem::get('/affiliates', 'Admin\Affiliates@index')->name('admin.affiliate');
    Gem::get('/affiliates/payments', 'Admin\Affiliates@payments')->name('admin.affiliate.payments');
    Gem::get('/affiliates/{id}/delete/{nonce}', 'Admin\Affiliates@delete')->name('admin.affiliate.delete');
    Gem::get('/affiliates/{id}/pay', 'Admin\Affiliates@pay')->name('admin.affiliate.pay');
    Gem::get('/affiliates/{id}/{action}', 'Admin\Affiliates@update')->name('admin.affiliate.update');

    // Ads
    Gem::get('/ads', 'Admin\Ads@index')->name('admin.ads');
    Gem::get('/ads/new', 'Admin\Ads@new')->name('admin.ads.new');
    Gem::post('/ads/save', 'Admin\Ads@save')->name('admin.ads.save');
    Gem::get('/ads/{id}/edit', 'Admin\Ads@edit')->name('admin.ads.edit');
    Gem::post('/ads/{id}/update', 'Admin\Ads@update')->name('admin.ads.update');
    Gem::get('/ads/{id}/delete/{nonce}', 'Admin\Ads@delete')->name('admin.ads.delete');
    // Themes
    Gem::get('/themes', 'Admin\Themes@index')->name('admin.themes');
    Gem::get('/themes/settings', 'Admin\Themes@settings')->name('admin.themes.settings');
    Gem::get('/themes/editor', 'Admin\Themes@editor')->name('admin.themes.editor');
    Gem::post('/themes/update', 'Admin\Themes@update')->name('admin.themes.editor.update');
    Gem::post('/themes/upload', 'Admin\Themes@upload')->name('admin.themes.upload');
    Gem::get('/themes/custom', 'Admin\Themes@custom')->name('admin.themes.custom');    
    Gem::post('/themes/custom/update', 'Admin\Themes@customUpdate')->name('admin.themes.custom.update');    
    Gem::get('/themes/{id}/activate', 'Admin\Themes@activate')->name('admin.themes.activate');
    Gem::get('/themes/{id}/delete/{nonce}', 'Admin\Themes@delete')->name('admin.themes.delete');
    Gem::get('/themes/{id}/clone/{nonce}', 'Admin\Themes@clone')->name('admin.themes.clone');

    Gem::get('/plugins', 'Admin\Plugins@index')->name('admin.plugins');
    Gem::get('/plugins/{id}/activate', 'Admin\Plugins@activate')->name('admin.plugins.activate');
    Gem::get('/plugins/{id}/disable', 'Admin\Plugins@disable')->name('admin.plugins.disable');
    Gem::post('/plugins/upload', 'Admin\Plugins@upload')->name('admin.plugins.upload');

    // Settings
    Gem::get('/settings', 'Admin\Settings@index')->name('admin.settings');
    Gem::post('/settings/save', 'Admin\Settings@store')->name('admin.settings.save');
    Gem::get('/settings/{config}', 'Admin\Settings@config')->name('admin.settings.config');
    
    // Languages
    Gem::get('/languages', 'Admin\Languages@index')->name('admin.languages');
    Gem::get('/languages/new', 'Admin\Languages@new')->name('admin.languages.new');
    Gem::post('/languages/save', 'Admin\Languages@save')->name('admin.languages.save');
    Gem::post('/languages/upload', 'Admin\Languages@upload')->name('admin.languages.upload');
    Gem::get('/languages/{id}/delete/{nonce}', 'Admin\Languages@delete')->name('admin.languages.delete');
    Gem::get('/languages/{id}/set', 'Admin\Languages@set')->name('admin.languages.set');
    Gem::get('/languages/{id}/edit', 'Admin\Languages@edit')->name('admin.languages.edit');
    Gem::post('/languages/{id}/update', 'Admin\Languages@update')->name('admin.languages.update');   
    Gem::post('/languages/translate', 'Admin\Languages@translate')->name('admin.translate'); 
    //Tools
    Gem::get('/tools', 'Admin\Dashboard@tools')->name('admin.tools');
    Gem::get('/tools/{action}/{nonce}', 'Admin\Dashboard@toolsAction')->name('admin.toolsAction');
    Gem::get('/email', 'Admin\Dashboard@email')->name('admin.email');
    Gem::post('/email/send', 'Admin\Dashboard@emailSend')->name('admin.email.send');
    Gem::route(['GET', 'POST'], '/email/templates', 'Admin\Dashboard@emailTemplates')->name('admin.email.template');
    Gem::route(['GET', 'POST'], '/update', 'Admin\Dashboard@update')->name('admin.update');
    Gem::post('/update/process', 'Admin\Dashboard@updateProcess')->name('admin.update.process');
    Gem::get('/tools/data', 'Admin\Dashboard@data')->name('admin.data');
    Gem::post('/tools/data/backup', 'Admin\Dashboard@backup')->name('admin.backup');
    Gem::post('/tools/data/restore', 'Admin\Dashboard@restore')->name('admin.restore');

    Gem::get('/crons', 'Admin\Dashboard@crons')->name('admin.crons');

    Gem::get('/phpinfo', 'Admin\Dashboard@phpinfo')->name('admin.phpinfo');
});

// API
Gem::group('/api', function(){
    
    Gem::setMiddleware(['Throttle', 'CheckDomain', 'Auth@api']);

    Gem::get('/', 'API\Index@index');
    
    // Account
    Gem::get('/account', 'API\Account@get')->name("api.account.get");
    Gem::put('/account/update', 'API\Account@update')->name("api.account.update");
    
    // Links
    Gem::get('/urls', 'API\Links@get')->name("api.url.get");
    Gem::post('/url/add', 'API\Links@create')->name("api.url.create");
    Gem::put('/url/{id}/update', 'API\Links@update')->name("api.url.update");
    Gem::delete('/url/{id}/delete', 'API\Links@delete')->name("api.url.delete");
    Gem::get('/url/{id}', 'API\Links@single')->name("api.url.single");

    // QR Codes
    Gem::get('/qr', 'API\QR@get')->name("api.qr.get");
    Gem::post('/qr/add', 'API\QR@create')->name("api.qr.create");
    Gem::put('/qr/{id}/update', 'API\QR@update')->name("api.qr.update");
    Gem::delete('/qr/{id}/delete', 'API\QR@delete')->name("api.qr.delete");
    Gem::get('/qr/{id}', 'API\QR@single')->name("api.qr.single");

    Gem::get('/users', 'API\Users@get')->name("api.user.get");
    Gem::post('/user/add', 'API\Users@create')->name("api.user.create");
    Gem::delete('/user/{id}/delete', 'API\Users@delete')->name("api.user.delete");

    Gem::get('/plans', 'API\Plans@get')->name("api.plan.get");
    Gem::put('/plan/{id}/user/{userid}', 'API\Plans@subscribe')->name("api.plan.subscribe");
    
});

Gem::group('/crons', function(){
    Gem::get('/users/{id}', 'Cron@user')->name('crons.user');
    Gem::get('/data/{id}', 'Cron@data')->name('crons.data');
    Gem::get('/urls/{id}', 'Cron@urls')->name('crons.urls');
});

Gem::get('/q', 'Link@quick')->name('quick');

Gem::get('/fullpage', 'Link@fullpage')->name('fullpage');

Gem::get("/script.js", 'Link@scriptjs')->name('scriptjs');

Gem::get('/sitemap.xml', 'Sitemap@index')->name('sitemap');

Gem::route(['GET', 'POST'], '/update', 'Update@index');

Gem::post('/server/contact', 'Server@contact')->name('server.contact');
Gem::post('/server/subscribe', 'Server@subscribe')->name('server.subscribe');
Gem::get('/server/states', '\Helpers\App@states')->middleware('CheckDomain')->name('server.states');

// Webhooks
Gem::route(['GET', 'POST'], '/ipn', 'Webhook@ipn')->middleware('CheckDomain')->name('webhook.paypal');

Gem::route(['GET', 'POST'], '/webhook[/{provider}]', 'Webhook@index')->middleware('CheckDomain')->name('webhook');
// Gem::route(['GET', 'POST'], '/webhook/paypal', 'Webhook@paypal')->middleware('CheckDomain')->name('webhook.paypalapi');
// Gem::route(['GET', 'POST'], '/webhook/slack', 'Webhook@slack')->middleware('CheckDomain')->name('webhook.slack');

// QR Codes
Gem::get('/qr/{id}', 'QR@generate')->name('qr.generate');
Gem::get('/qr/{id}/download/{format}[/{size}]', 'QR@download')->name('qr.download');

// Short URL Routes
Gem::get('/r/{alias}', 'Link@campaign')->name('campaign');
Gem::get('/u/{username}/{alias}', 'Link@campaignList')->name('campaign.list');

Gem::get('/{alias}+', 'Stats@simple')->name('stats.alt');
Gem::get('/bookmark', 'Link@bookmark');
Gem::get('/{id}/stats', 'Stats@index')->middleware('CheckDomain')->name('stats');
Gem::get('/{id}/stats/clicks', 'Stats@clicks')->middleware('CheckDomain')->name('stats.clicks');
Gem::get('/{id}/data/clicks', 'Stats@dataClicks')->middleware('CheckDomain')->name('data.clicks');

Gem::get('/{id}/stats/countries', 'Stats@countries')->middleware('CheckDomain')->name('stats.countries');
Gem::get('/{id}/data/countries', 'Stats@dataCountries')->middleware('CheckDomain')->name('data.countries');
Gem::get('/{id}/data/cities', 'Stats@dataCities')->middleware('CheckDomain')->name('data.cities');

Gem::get('/{id}/stats/platforms', 'Stats@platforms')->middleware('CheckDomain')->name('stats.platforms');
Gem::get('/{id}/data/platforms', 'Stats@dataPlatforms')->middleware('CheckDomain')->name('data.platforms');

Gem::get('/{id}/stats/browsers', 'Stats@browsers')->middleware('CheckDomain')->name('stats.browsers');
Gem::get('/{id}/data/browsers', 'Stats@dataBrowsers')->middleware('CheckDomain')->name('data.browsers');

Gem::get('/{id}/stats/languages', 'Stats@languages')->middleware('CheckDomain')->name('stats.languages');
Gem::get('/{id}/data/languages', 'Stats@dataLanguages')->middleware('CheckDomain')->name('data.languages');

Gem::get('/{id}/stats/referrers', 'Stats@referrers')->middleware('CheckDomain')->name('stats.referrers');
Gem::get('/{id}/data/referrers', 'Stats@dataReferrers')->middleware('CheckDomain')->name('data.referrers');

Gem::get('/{id}/i', 'Link@image')->name('link.image');
Gem::get('/{id}/ico', 'Link@icon')->name('link.ico');
Gem::get('/{id}/qr[/{size}]', 'Link@qr')->name('link.qr');
Gem::get('/{id}/qr/download/{format}[/{size}]', 'Link@qrDownload')->name('link.qrDownload');

Gem::route(['GET', 'POST'], '/{alias}', 'Link@redirect')->name('redirect');

Gem::get('/compile/1a589a9d55e6fff984', function(){
    \Core\View::compile([
         "frontend/libs/jquery/dist/jquery.min.js",
         "frontend/libs/bootstrap/dist/js/bootstrap.bundle.min.js",
         "frontend/libs/bootstrap-notify/bootstrap-notify.min.js",
         "frontend/libs/svg-injector/dist/svg-injector.min.js",
         "frontend/libs/feather-icons/dist/feather.min.js",
         "frontend/libs/select2/dist/js/select2.min.js",                   
    ], 'bundle.pack.js');
});