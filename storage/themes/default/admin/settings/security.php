<h1 class="h3 mb-5"><?php ee('Security Settings') ?></h1>
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
                        <label for="adult" class="form-label"><?php ee('Blacklisting URLs') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="adult" name="adult" value="1" <?php echo config("adult") ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="keyword_blacklist,domain_blacklist">
                            <label class="form-check-label" for="adult"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Once enabled, any url containing the keywords below (or an internal list) will not be allowed. This will also prevent links to executable files to be shortened.') ?></p>                                                
                    </div>   
                    <div class="form-group mb-4 <?php echo config("adult") ? '':'d-none' ?>">
					    <label for="keyword_blacklist" class="form-label"><?php ee('Blacklist Keywords') ?></label>
					    <input type="text" class="form-control" name="keyword_blacklist" id="keyword_blacklist" value="<?php echo config('keyword_blacklist') ?>" data-toggle="tags" placeholder="Enter keyword">
					    <p class="form-text"><?php ee('Each URL shortener will be matched with list of keywords below and if matched it will not allowed. Separate each keyword by a comma e.g. keyword1,keyword2') ?></p>
                        <div class="alert alert-warning p-2 rounded"><?php ee('If you have a long list, you can add them in a text file named "keywords.txt" in the folder storage/app/ and that will be used instead of the list here.') ?></div>
                    </div>
                    <div class="form-group mb-4 <?php echo config("adult") ? '':'d-none' ?>">
					    <label for="domain_blacklist" class="form-label"><?php ee('Blacklist Domains') ?></label>
					    <input type="text" class="form-control" name="domain_blacklist" id="domain_blacklist" value="<?php echo config('domain_blacklist') ?>" data-toggle="tags" placeholder="Enter domain">
					    <p class="form-text"><?php ee('To blacklist domain names (or tlds) or IPs, simply add them in the field below in the following format (separated by a comma): domain.com,domain2.com,domain3.com,.tld. To block a subdomain, you can use the following format *.domain.com - this will block all subdomains (example *.google.com will block code.google.com but not google.com).') ?></p>
                        <div class="alert alert-warning p-2 rounded"><?php ee('If you have a long list, you can add them in a text file named "domains.txt" in the folder storage/app/ and that will be used instead of the list here.') ?></div>
                    </div>
                    <hr>
                    <div class="form-group mb-4">
					    <label for="safe_browsing" class="form-label"><?php ee('Google Web Risk') ?></label>
					    <input type="text" class="form-control" name="safe_browsing" id="safe_browsing" value="<?php echo config('safe_browsing') ?>">
					    <p class="form-text"><?php ee('You can get your API key for free from <a href="https://cloud.google.com/web-risk/" target="_blank">Google</a>. Google has changed to Web Risk API. Note that the Google Web Risk API does not apply to commercial usage anymore and as such you cannot use it.') ?></p>
                    </div>
                    <hr>
                    <div class="form-group mb-4">
					    <label for="phish_username" class="form-label"><?php ee('Phishtank Username') ?></label>
					    <input type="text" class="form-control" name="phish_username" id="phish_username" value="<?php echo config('phish_username') ?>">
					    <p class="form-text"><?php ee('You will need to create an account <a href="https://www.phishtank.com" target="_blank">here</a> and add your username here.') ?></p>
                    </div> 
                    <div class="form-group mb-4">
					    <label for="phish_api" class="form-label"><?php ee('Phishtank API') ?></label>
					    <input type="text" class="form-control" name="phish_api" id="phish_api" value="<?php echo config('phish_api') ?>">
					    <p class="form-text"><?php ee('You will need to create an account <a href="https://www.phishtank.com" target="_blank">here</a> and add your username here.') ?></p>
                    </div>
                    <hr>
                    <div class="form-group mb-4">
					    <label for="vtkey" class="form-label"><?php ee('Virus Total API') ?></label>
					    <input type="text" class="form-control" name="virustotal[key]" id="vtkey" value="<?php echo config('virustotal')->key ?>">
					    <p class="form-text"><?php ee('You will need to create an account <a href="https://developers.virustotal.com" target="_blank">here</a> and add your API key here.') ?></p>
                    </div> 
                    <div class="form-group mb-4">
					    <label for="vtlimit" class="form-label"><?php ee('Virus Total Tolerance') ?></label>
					    <input type="number" class="form-control" name="virustotal[limit]" id="vtlimit" value="<?php echo  config('virustotal')->limit ?>" min="1" placeholder="e.g 2">
					    <p class="form-text"><?php ee('Choose the tolerance for number of positives to block a link. For example if you choose 2 and the VT returns at least 2 positives, the url will be blocked.') ?></p>
                    </div>
                    <hr>
                    <div class="custom-alert alert alert-warning"><strong class="me-2"><?php ee('Important') ?></strong> <?php ee('Before you logout, make sure you are using the correct captcha keys otherwise you will be locked out of your account and would not be able to login unless you directly disable captcha via the database.') ?></div>
                    <div class="form-group mb-4">
					    <label for="frame" class="form-label"><?php ee('Captcha') ?></label>
					      <select name="captcha" id="captcha" class="form-control" data-toggle="select">
                            <option <?php echo (config("captcha") == '0' ? "selected":"") ?> value="0"><?php ee('None') ?></option>	
                            <option <?php echo (config("captcha") == '1' ? "selected":"") ?> value="1"><?php ee('reCaptcha v3') ?></option>	
                            <option <?php echo (config("captcha") == '3' ? "selected":"") ?> value="3"><?php ee('reCaptcha v2') ?></option>	
                            <option <?php echo (config("captcha") == '4' ? "selected":"") ?> value="4"><?php ee('hCaptcha') ?></option>	
					      </select>
					      <p class="form-text"><?php ee('Users will be prompted to answer a captcha before processing their request. If you enable any of the captcha make sure to add your keys as well. To enable hCaptcha, add your "Site Key" in the Public Key field below and your "Secret Key" in the Private Key below.') ?></p>
                    </div>  
                    <div class="form-group mb-4">
					    <label for="captcha_public" class="form-label"><?php ee('Public Key') ?></label>
					    <input type="text" class="form-control" name="captcha_public" id="captcha_public" value="<?php echo config('captcha_public') ?>">
					    <p class="form-text"><?php ee('For reCaptcha, you can get your public key for free from <a href="https://www.google.com/recaptcha" target="_blank">Google</a>') ?></p>
                    </div> 
                    <div class="form-group mb-4">
					    <label for="captcha_private" class="form-label"><?php ee('Private Key') ?></label>
					    <input type="text" class="form-control" name="captcha_private" id="captcha_private" value="<?php echo config('captcha_private') ?>">
					    <p class="form-text"><?php ee('For reCaptcha, you can get your private key for free from <a href="https://www.google.com/recaptcha" target="_blank">Google</a>') ?></p>
                    </div>   
                    <button type="submit" class="btn btn-primary"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>