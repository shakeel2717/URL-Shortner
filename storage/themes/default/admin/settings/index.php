<h1 class="h3 mb-5"><?php ee('General Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data" id="settings-form">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
					    <label for="url" class="form-label"><?php ee('Site URL') ?></label>
					    <input type="text" class="form-control" name="url" id="url" value="<?php echo config('url') ?>">
					    <p class="form-text"><?php ee('Please make sure to include http:// (or https://) and remove the last slash') ?></p>
                    </div>				
                    <div class="form-group mb-4">
					    <label for="title" class="form-label"><?php ee('Site Title') ?></label>
					    <input type="text" class="form-control" name="title" id="title" value="<?php echo config('title') ?>">
					    <p class="form-text"><?php ee('This is your site name as well as the site meta title') ?></p>
                    </div>				
                    <div class="form-group mb-4">
					    <label for="description" class="form-label"><?php ee('Site Description') ?></label>
					    <input type="text" class="form-control" name="description" id="description" value="<?php echo config('description') ?>">
					    <p class="form-text"><?php ee('This your site description as well as the site meta description') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="keywords" class="form-label"><?php ee('Site Keywords') ?></label>
					    <input type="text" class="form-control" name="keywords" id="keywords" value="<?php echo config('keywords') ?>">
					    <p class="form-text"><?php ee('This your site keywords as well as the site meta keywords (only some important keywords)') ?></p>
                    </div>					  
                    <div class="form-group mb-4">
					    <label for="logo" class="form-label"><?php ee('Logo') ?></label>
                        <?php if(!empty(config("logo"))):  ?>
                            <p><img src="<?php echo config("url") ?>/content/<?php echo config("logo") ?>" height="80" alt="" class="bg-secondary rounded p-3"></p>
                        <?php endif ?>					    	
					    <input type="file" name="logo_path" id="logo" class="form-control mb-2">
                        <?php if(!empty(config("logo"))):  ?>
                            <p class="form-text"><a href="#" id="remove_logo" data-trigger="removeimage" class="btn btn-danger btn-sm"><?php ee('Remove Logo') ?></a></p>
                        <?php endif ?>
					    <p class="form-text"><?php ee('Please make sure that the logo is of adequate size and format') ?></p>
                    </div>		
                    <div class="form-group mb-4">
					    <label for="favicon" class="form-label"><?php ee('Favicon') ?></label>
                        <?php if(!empty(config("favicon"))):  ?>
                            <p><img src="<?php echo config("url") ?>/content/<?php echo config("favicon") ?>" height="32" alt=""></p>
                        <?php endif ?>					    	
					    <input type="file" name="favicon_path" id="favicon" class="form-control mb-2">
                        <?php if(!empty(config("favicon"))):  ?>
                            <p class="form-text"><a href="#" id="remove_favicon" data-trigger="removeimage" class="btn btn-danger btn-sm"><?php ee('Remove Favicon') ?></a></p>
                        <?php endif ?>
					    <p class="form-text"><?php ee('Please make sure that the favicon is of adequate size and format (32x32 png or ico)') ?></p>
                    </div>                    
                    <div class="form-group mb-4">
					    <label for="timezone" class="form-label"><?php ee('Timezone') ?></label>
                        <select name="timezone" id="timezone" class="form-control" data-toggle="select" title="Timezone" data-live-search="true" data-live-search-placeholder="Timezone">
                            <?php foreach($timezones as $key): ?>
                                <option <?php echo (config("timezone") == $key ? "selected":"") ?> value="<?php echo $key ?>"><?php echo $key ?></option>	
                            <?php endforeach ?>										    
                        </select> 
                    </div>
                    <div class="form-group mb-4">
					    <label for="font" class="form-label"><?php ee('Google Font') ?></label>
					    <input class="form-control" name="font" id="font" value="<?php echo config('font') ?>">
					    <p class="form-text"><?php ee('Please add the exact name of the <a href="https://www.google.com/fonts" target="_blank">Google Font</a>: e.g. <strong>Open Sans</strong>') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="news" class="form-label"><?php ee('Announcement') ?></label>
                        <textarea class="form-control" name="news" id="news"><?php echo config('news') ?></textarea>
                        <p class="form-text"><?php ee('This will be shown in the user dashboard. You can use html. Empty it to remove the announcement') ?></p>
                    </div>                    
                    <hr>
                    <div class="form-group mb-4">
					    <label for="facebook" class="form-label"><?php ee('Facebook Page') ?></label>
					    <input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo config('facebook') ?>">
					    <p class="form-text"><?php ee('Link to your Facebook page e.g. http://facebook.com/gempixel') ?></p>
                    </div>	
                    <div class="form-group mb-4">
					    <label for="twitter" class="form-label"><?php ee('Twitter Page') ?></label>
					    <input type="text" class="form-control" name="twitter" id="twitter" value="<?php echo config('twitter') ?>">
					    <p class="form-text"><?php ee('Link to your Twitter profile e.g. http://www.twitter.com/kbrmedia') ?></p>
                    </div>						  			

                    <button type="submit" class="btn btn-primary"><?php ee('Save Settings') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>