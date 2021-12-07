<h1 class="h3 mb-5"><?php ee('Theme Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>                                        
                    <div class="form-group">
                        <label for="user_history" class="form-label"><?php ee('Anonymous User History') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="user_history" name="user_history" value="1" <?php echo config("user_history") ? 'checked':'' ?>>
                            <label class="form-check-label" for="user_history"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('If enabled, anonymous users can view their personal history of URLs on the home page.') ?></p>
                    </div>   
                    <div class="form-group">
                        <label for="public_dir" class="form-label"><?php ee('Public URL List') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="public_dir" name="public_dir" value="1" <?php echo config("public_dir") ? 'checked':'' ?>>
                            <label class="form-check-label" for="public_dir"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enabling this will display a list of new public URLs on the home page. Only the last 25 URLs will be shown there. If you enable this, some parts of the homepage will be removed.') ?></p>
                    </div> 
                    <div class="form-group">
                        <label for="homepage_stats" class="form-label"><?php ee('Stats on Homepage') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="homepage_stats" name="homepage_stats" value="1" <?php echo config("homepage_stats") ? 'checked':'' ?>>
                            <label class="form-check-label" for="homepage_stats"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enabling this will display stats at the bottom of the homepage.') ?></p>
                    </div> 
                    <button type="submit" class="btn btn-primary"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>