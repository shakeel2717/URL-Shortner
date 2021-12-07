<h1 class="h3 mb-5"><?php ee('Integrations Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>                                        
                    <h4>Slack Intergration</h4>
                    <p>To enable slack integration, setup the following fields. If you leave the following fields empty, slack integration will be disabled. For documentation on how to setup Slack, please see <a href="https://gemp.me/docs" target="_blank">https://gemp.me/docs</a></p>
                    <div class="form-group">
					    <label class="form-label"><?php ee('Slack Request URL') ?></label>
                        <input type="text" class="form-control" value="<?php echo route("webhook", ['slack']) ?>" disabled>
                        <p class="form-text"><?php ee('You need to add this in the the slack "Apps".') ?></p>
                    </div>							
                    <div class="form-group">
					    <label for="slackclientid" class="form-label"><?php ee('Slack Client ID') ?></label>
                        <input type="text" class="form-control" name="slackclientid" value="<?php echo config('slackclientid') ?>">
                        <p class="form-text"><?php ee('You can find your slack client id in the slack "Apps".') ?></p>
                    </div>	
                    <div class="form-group">
					    <label for="slacksecretid" class="form-label"><?php ee('Slack Client Secret') ?></label>
                        <input type="text" class="form-control" name="slacksecretid" value="<?php echo config('slacksecretid') ?>">
                        <p class="form-text"><?php ee('You can find your slack secret id in the slack "Apps".') ?></p>
                    </div>
                    <div class="form-group">
					    <label for="slacksigningsecret" class="form-label"><?php ee('Slack Signing Secret') ?></label>
                        <input type="text" class="form-control" name="slacksigningsecret" value="<?php echo config('slacksigningsecret') ?>">
                        <p class="form-text"><?php ee('You can find your slack secret id in the slack "Apps". This is used to validate requests from Slack.') ?></p>
                    </div>					  	
                    <div class="form-group">
					    <label for="slackcommand" class="form-label"><?php ee('Slack Command') ?></label>
                        <input type="text" class="form-control" name="slackcommand" value="<?php echo config('slackcommand') ?>">
                        <p class="form-text"><?php ee('Insert the command that you choose in the slack app settings. It has to be the same as the one you choose. For more information, please see docs.') ?></p>
                    </div>			
                    
                    <button type="submit" class="btn btn-primary"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>