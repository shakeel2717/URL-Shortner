<h1 class="h3 mb-5"><?php ee('Settings') ?></h1>
<div class="row">
    <div class="col-md-8">
        <?php if(!empty($user->auth)): ?>
            <div class="custom-alert alert alert-warning"><?php echo e("You have used a social network to login. Please note that in this case you don't have a password set.") ?></div>
        <?php endif ?>

        <?php if(empty($user->username)): ?>
            <div class="custom-alert alert alert-warning"><?php echo e("You have used a social network to login. You will need to choose a username.") ?></div>
        <?php endif ?>
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('settings.update') ?>" enctype="multipart/form-data" id="settings-form" autocomplete="off">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4 d-flex align-items-center">
					    <div class="me-3">
                            <img src="<?php echo $user->avatar()?>" width="100" class="rounded">
                        </div>
                        <div>
                            <label for="avatar" class="form-label"><?php ee('Avatar') ?></label>				    	
                            <input type="file" name="avatar" id="avatar" class="form-control mb-2">
                            <p class="form-text"><?php ee('By default, we will use the Gravatar associated to your email. Uploaded avatars must be square with the width ranging from 200-500px with a maximum size of 500kb.') ?></p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="form-label"><?php ee('Name') ?></label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $user->name ?>">
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="form-label"><?php ee('Email') ?></label>
                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $user->email ?>">
                                <?php if(config("user_activate")): ?>
                                    <p class="form-text"><?php echo e("Please note that if you change your email, you will need to activate your account again.") ?></p>
                                <?php endif; ?>
                            </div>
                        </div>			
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username" class="form-label"><?php ee('Username') ?></label>
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo $user->username ?>" <?php echo (empty($user->username)?"":" disabled")?>>
                                <p class="form-text"><?php ee('A username is required for your public profile to be visible.') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="f-password"><?php echo e("Password")?></label>
                                <input type="password" value="" name="password" id="f-password" class="form-control" autocomplete="new-password" />
                                <p class="form-text"><?php ee("Leave blank to keep current one.") ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="f-cpassword"><?php echo e("Confirm Password")?></label>
                                <input type="password" value="" name="cpassword" id="f-cpassword" class="form-control" autocomplete="off" />
                                <p class="form-text"><?php ee("Leave blank to keep current one.") ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="domain"><?php echo e("Default Domain")?></label>
                                <div class="input-group input-select">
                                    <select name="domain" id="domain" class="form-control border-start-0 ps-0" data-toggle="select">
                                        <?php foreach(\Helpers\App::domains() as $domain): ?>
                                            <option value="<?php echo $domain ?>" <?php echo $user->domain == $domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php if($user->pro()): ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="defaulttype" class="form-label"><?php echo e("Default Redirection") ?></label>
                                    <div class="input-group input-select">
                                        <select name="defaulttype" id="defaulttype" class="form-select p-2" data-toggle="select">
                                            <option value="direct" <?php echo ($user->defaulttype == "direct" || $user->defaulttype== "" ? " selected":"") ?>> <?php echo e("Direct") ?></option>
                                            <option value="frame" <?php echo ($user->defaulttype == "frame" ? " selected":"") ?>> <?php echo e("Frame") ?></option>
                                            <option value="splash" <?php echo ($user->defaulttype == "splash" ? " selected":"") ?>> <?php echo e("Splash") ?></option>
                                        </select>		              
                                    </div>
                                </div> 
                            </div>
                        <?php endif ?>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="d-flex">
                                    <div>
                                        <label class="form-check-label" for="public"><?php ee('Public Profile') ?></label>
                                        <p class="form-text"><?php ee('Public profile will be activated only when this option is public.') ?></p>
                                    </div>
                                    <div class="form-check form-switch ms-auto">
                                        <input class="form-check-input" type="checkbox" data-binary="true" id="public" name="public" value="1" <?php echo $user->public ? 'checked' : '' ?>>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="d-flex">
                                    <div>
                                        <label class="form-check-label" for="media"><?php ee('Media Gateway') ?></label>
                                        <p class="form-text"><?php ee('If enabled, special pages will be automatically created for your media URLs (e.g. youtube, vimeo, dailymotion...).') ?></p>
                                    </div>
                                    <div class="form-check form-switch ms-auto">
                                        <input class="form-check-input" type="checkbox" data-binary="true" id="media" name="media" value="1" <?php echo $user->media ? 'checked' : '' ?>>
                                    </div>
                                </div>
                            </div>                          
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="d-flex">
                                    <div>
                                        <label class="form-check-label" for="newsletter"><?php ee('Newsletter') ?></label>
                                        <p class="form-text"><?php ee('If enabled, you will receive occasional newsletters from us.') ?></p>
                                    </div>
                                    <div class="form-check form-switch ms-auto">
                                        <input class="form-check-input" type="checkbox" data-binary="true" id="newsletter" name="newsletter" value="1" <?php echo $user->newsletter ? 'checked' : '' ?>>
                                    </div>
                                </div>
                            </div>                          
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4"><?php ee('Save Settings') ?></button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3"><?php echo e("Two-Factor Authentication (2FA)") ?></h4>
                <p>
                <?php echo e("2FA is an enhanced level security for your account. Each time you login, an extra step where you will need to enter a unique code will be required to gain access to your account. To enable 2FA, please click the button below and download the <strong>Google Authenticator</strong> app from Apple Store or Play Store.") ?></p>
                <?php if($QR2FA): ?>						

                    <a href="#qrcode" data-bs-toggle="collapse" data-bs-target="#qrcode" class="mb-4 btn btn-primary btn-sm"><?php ee("View QR") ?></a>
                    <div id="qrcode" class="collapse border p-3 mb-3">
                        <p><img src="<?php echo $QR2FA ?>" width="150"></p>
                        <strong><small><?php echo e("Secret Key") ?></small></strong>: <small data-href="<?php echo $user->secret2fa ?>"><?php echo $user->secret2fa ?></small> <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo $user->secret2fa ?>"><small><?php echo e("Copy")?></small></a>	 
                    </div>

                    <h5 class="mb-2"><?php echo e("Important") ?></h5>            

                    <p><?php echo e("You need to scan the code above with the app. You need to backup the QR code by saving it and save the key somewhere safe in case you lose your phone. You will not be able to login if you can't provide the code, in that case you will need to contact us. If you disable 2FA and re-enable it, you will need to scan a new code.") ?></p>	                
                    <p><a href="<?php echo route("2fa", ['disable', \Core\Helper::nonce('2fa'.$user->id)]) ?>" class="btn btn-danger"><?php echo e("Disable 2FA") ?></a></p>
                <?php else: ?>
                    <p><a href="<?php echo route("2fa", ['enable', \Core\Helper::nonce('2fa'.$user->id)]) ?>" class="btn btn-primary"><?php echo e("Activate 2FA") ?></a></p>
                <?php endif ?>
            </div>
        </div>
        <?php if(config('api') && $user->has('api') && $user->teamPermission('api.create')): ?>
			<div class="card card-body">
				<h4 class="mb-3"><?php echo e("Developer API Key") ?></h4>	
                <code class="bg-dark text-white p-3 rounded mb-3 position-relative d-block"><?php echo $user->api ?> <a href="#" class="btn btn-success btn-sm position-absolute top-0 end-0 copy" data-clipboard-text="<?php echo $user->api ?>"><?php ee('Copy') ?></a></code>
				<p><a href="#" class="btn btn-primary" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#apiModal"><?php echo e("Regenerate") ?></a></p>
			</div>
		<?php endif ?> 
        <?php if(config('allowdelete')): ?>
			<div class="card card-body">
				<h4 class="mb-3"><?php echo e("Delete your account") ?></h4>
				<p><?php echo e("We respect your privacy and as such you can delete your account permanently and remove all your data from our server. Please note that this action is permanent and cannot be reversed.") ?></p>
				<p><a href="#" class="btn btn-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><?php echo e("Delete Permanently") ?></a></p>
			</div>
		<?php endif ?> 
    </div>
</div>

<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Delete your account') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo route('terminate') ?>" method="post">
        <div class="modal-body">
        <p><?php ee('We respect your privacy and as such you can delete your account permanently and remove all your data from our server. Please note that this action is permanent and cannot be reversed.') ?></p>
            <?php echo csrf() ?>
            <div class="form-group">
                <label class="form-label"><?php echo e("Confirm Password")?></label>
                <input type="password" value="" name="cpassword" class="form-control" autocomplete="off" />
            </div>        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-danger"><?php ee('Delete') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="apiModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Developer API Key') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo route('regenerateapi') ?>" method="post">
        <div class="modal-body">
            <p><?php echo ee('If you regenerate your key, the current key will be revoked and your applications might stop working until you update the api key with the new one.') ?></p>
            <?php echo csrf() ?>      
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-success"><?php ee('Regenerate') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>