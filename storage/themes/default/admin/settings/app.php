<h1 class="h3 mb-5"><?php ee('Application Settings') ?></h1>
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
                        <label for="" class="form-label"><?php ee('Site Maintenance') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="maintenance" name="maintenance" value="1" <?php echo config("maintenance") ? 'checked':'' ?>>
                            <label class="form-check-label" for="maintenance"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Setting offline will make your website inaccessible for all users but admins.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Private Service') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="private" name="private" value="1" <?php echo config("private") ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="home_redir">
                            <label class="form-check-label" for="private"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enabling this will prevent users from shortening and registering. Only you can create accounts.') ?></p>
                    </div>
                    <div class="form-group <?php echo config("private") ? '':'d-none' ?>">
                        <label for="home_redir" class="form-label"><?php ee('Home Page Redirect') ?></label>
                        <input type="text" class="form-control" name="home_redir" id="home_redir" value="<?php echo config('home_redir') ?>">
                        <p class="form-text"><?php ee('If you enable private mode and you want to redirect users to a custom page, add the URL above including http://.') ?></p>
                    </div>	
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Blog Module') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="blog" name="blog" value="1" <?php echo config("blog") ? 'checked':'' ?>>
                            <label class="form-check-label" for="blog"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enable the blog module to enable access to the blog posts for users.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Contact Page') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="contact" name="contact" value="1" <?php echo config("contact") ? 'checked':'' ?>>
                            <label class="form-check-label" for="contact"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enable the contact page so users can contact you.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Report Page') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="report" name="report" value="1" <?php echo config("report") ? 'checked':'' ?>>
                            <label class="form-check-label" for="report"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enable the report page so users can report links.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="ads" class="form-label"><?php ee('Advertisement') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="ads" name="ads" value="1" <?php echo config("ads") ? 'checked':'' ?>>
                            <label class="form-check-label" for="ads"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enable or disable advertisement throughout the site.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="detectadblock" class="form-label"><?php ee('Adblock Detection') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="detectadblock" name="detectadblock" value="1" <?php echo config("detectadblock") ? 'checked':'' ?>>
                            <label class="form-check-label" for="detectadblock"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enable or disable adblock detection on redirection (splash and frame - does not work for pro users)') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="cookieconsent[enabled]" class="form-label"><?php ee('Cookie Consent') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="cookieconsent[enabled]" name="cookieconsent[enabled]" value="1" <?php echo config("cookieconsent")->enabled ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="cookieconsentmessage,cookieconsentlink">
                            <label class="form-check-label" for="cookieconsent[enabled]"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enable cookie consent notification.') ?></p>
                    </div>
                    <div class="form-group <?php echo config("cookieconsent")->enabled ? '':'d-none' ?>">
                        <label for="cookieconsent[message]" class="form-label"><?php ee('Cookie Consent Message') ?></label>
                        <input type="text" class="form-control" name="cookieconsent[message]" id="cookieconsentmessage" value="<?php echo config('cookieconsent')->message ?>">
                        <p class="form-text"><?php ee('Enter your personalized message. You can also translate this by adding it manually. If you leave it empty, a pre-defined message will be shown.') ?></p>
                    </div>
                    <div class="form-group <?php echo config("cookieconsent")->enabled ? '':'d-none' ?>">
                        <label for="cookieconsent[link]" class="form-label"><?php ee('Cookie Consent Link') ?></label>
                        <input type="text" class="form-control" name="cookieconsent[link]" id="cookieconsentlink" value="<?php echo config('cookieconsent')->link ?>">
                        <p class="form-text"><?php ee('Enter the link to your cookie policy.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Developer API') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="api" name="api" value="1" <?php echo config("api") ? 'checked':'' ?>>
                            <label class="form-check-label" for="api"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Allow registered users to shorten URLs from their site using the API.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Sharing') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="sharing" name="sharing" value="1" <?php echo config("sharing") ? 'checked':'' ?>>
                            <label class="form-check-label" for="sharing"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Allow users to share their shorten URL through social networks such as facebook and twitter.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label"><?php ee('Update Notification') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="update_notification" name="update_notification" value="1" <?php echo config("update_notification") ? 'checked':'' ?>>
                            <label class="form-check-label" for="update_notification"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Be notified when an update is available.') ?></p>
                    </div>
                    

                    <button type="submit" class="btn btn-primary"><?php ee('Save Settings') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>