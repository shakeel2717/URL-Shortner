<h1 class="h3 mb-5"><?php ee('Mail Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>                                        
                    <div class="custom-alert alert alert-info"><strong class="mx-2">Tip:</strong><?php ee('SMTP is recommend because it is much more reliable than the system mail module.') ?></div>
                    
                    <div class="form-group mb-3">
					    <label for="email" class="form-label"><?php ee('From Email') ?></label>
					    <input type="text" class="form-control" name="email" id="email" value="<?php echo config('email') ?>">
					    <p class="form-text"><?php ee('This email will be used to send emails and to receive emails. We recommend using an email at @yourdomain.') ?></p>
                    </div>

                    <div class="form-group mb-3">
					    <label for="smtp" class="form-label"><?php ee('SMTP Host') ?></label>
                        <input type="text" class="form-control" name="smtp[host]" value="<?php echo config('smtp')->host ?>">
                    </div>				
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="smtp" class="form-label"><?php ee('SMTP Security') ?></label>
                                <select name="smtp[security]" id="smtp" class="form-control">
                                    <option value="none" <?php echo (config('smtp')->security == 'none' ? 'selected' : '') ?>>None</option>
                                    <option value="tls" <?php echo (config('smtp')->security == 'tls' ? 'selected' : '') ?>>TLS</option>
                                    <option value="ssl" <?php echo (config('smtp')->security == 'ssl' ? 'selected' : '') ?>>SSL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="smtp" class="form-label"><?php ee('SMTP Port') ?></label>
                                <input type="text" class="form-control" name="smtp[port]" value="<?php echo config('smtp')->port ?>">
                            </div>
                        </div>
                    </div>		
                    <div class="form-group mb-3">
					    <label for="smtp" class="form-label"><?php ee('SMTP User') ?></label>
                        <input type="text" class="form-control" name="smtp[user]" value="<?php echo config('smtp')->user ?>">
                    </div>		
                    <div class="form-group mb-3">
					    <label for="smtp" class="form-label"><?php ee('SMTP Pass') ?></label>
                        <input type="password" class="form-control" name="smtp[pass]" value="<?php echo config('smtp')->pass ?>">
                    </div>		
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary"><?php ee('Save Settings') ?></button>
                        <div class="ms-auto">
                            <a href="<?php echo route('admin.email', ['email' => config('email')]) ?>" class="btn btn-success"><?php ee('Send Test Email') ?></a>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>