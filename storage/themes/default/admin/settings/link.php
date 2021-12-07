<h1 class="h3 mb-5"><?php ee('Link Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="frame" class="form-label"><?php ee('Default Redirection') ?></label>
                                <select name="frame" id="frame" class="form-control" data-toggle="select">
                                    <option <?php echo (config("frame") == '0' ? "selected":"") ?> value="0"><?php ee('None') ?></option>	
                                    <option <?php echo (config("frame") == '1' ? "selected":"") ?> value="1"><?php ee('Frame') ?></option>	
                                    <option <?php echo (config("frame") == '2' ? "selected":"") ?> value="2"><?php ee('Splash') ?></option>	
                                    <option <?php echo (config("frame") == '3' ? "selected":"") ?> value="3"><?php ee('Auto') ?></option>	
                                </select>
                                <p class="form-text"><?php ee('Choose the type of redirection mechanism. "None" will directly redirect while "Auto" will add an option to let the user choose for each URL.') ?></p>
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="timer" class="form-label"><?php ee('Splash Page Timer') ?></label>
                                <input class="form-control p-2" name="timer" id="timer" value="<?php echo config('timer') ?>">
                                <p class="form-text"><?php ee('Timer for the splash page.') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
					    <label for="alias_length" class="form-label"><?php ee('Shortener Alias Length') ?></label>
					    <input class="form-control" name="alias_length" id="alias_length" value="<?php echo config('alias_length') ?>">
					    <p class="form-text"><?php ee('This field is used to generate a random alias of X length. Minimum value 2.') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="schemes" class="form-label"><?php ee('Allowed Schemes') ?></label>
					    <input type="text" class="form-control" name="schemes" id="schemes" value="<?php echo config('schemes') ?>" data-toggle="tags" placeholder="Enter text">
					    <p class="form-text"><?php ee('Add or remove allowed url schemes.') ?></p>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Anonymous Links Stats') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="tracking" name="tracking" value="1" <?php echo config("tracking") ? 'checked':'' ?>>
                            <label class="form-check-label" for="tracking"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Disable this if you do not want to store data for anonymous links. Clicks will still be counted but not anything else. This is good if you want to save on database space.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Manual Link Approval') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="manualapproval" name="manualapproval" value="1" <?php echo config("manualapproval") ? 'checked':'' ?>>
                            <label class="form-check-label" for="manualapproval"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enable this to manually approve all links shortened.') ?></p>
                    </div>                  
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Media Gateway') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="show_media" name="show_media" value="1" <?php echo config("show_media") ? 'checked':'' ?>>
                            <label class="form-check-label" for="show_media"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enabling this will create automatically media pages for URLs such as Youtube, Vine, Dailymotion. Registered users can override this option from user settings.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Geo Targeting') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="geotarget" name="geotarget" value="1" <?php echo config("geotarget") ? 'checked':'' ?>>
                            <label class="form-check-label" for="geotarget"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Redirects user according to their country (if set by user). This is a global feature. Disabling this will disable it across the app.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Device Targeting') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="devicetarget" name="devicetarget" value="1" <?php echo config("devicetarget") ? 'checked':'' ?>>
                            <label class="form-check-label" for="device"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Redirects user according to their device (if set by user). This is a global feature. Disabling this will disable it across the app.') ?></p>
                    </div>                    
                    <button type="submit" class="btn btn-primary"><?php ee('Save Settings') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>