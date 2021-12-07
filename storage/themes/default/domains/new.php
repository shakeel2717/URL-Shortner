<h1 class="h3 mb-5"><?php ee('New Domain') ?></h1>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('domain.save') ?>" enctype="multipart/form-data" data-trigger="codeeditor">
                    <?php echo csrf() ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="domain" class="form-label"><?php ee('Domain') ?></label>
                                <input type="text" class="form-control p-2" name="domain" id="domain" value="<?php echo old('domain') ?>" placeholder="https://domain.com">
                                <div class="form-text"><?php ee('You will need to setup a DNS record for your domain to work. See instructions on the right side.') ?></div>
                            </div>	
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="rootdomain" class="form-label"><?php ee('Domain Root') ?></label>
                                <input type="text" class="form-control p-2" name="root" id="rootdomain" value="<?php echo old('root') ?>" placeholder="https://mycompany.com">
                                <div class="form-text"><?php ee('Redirects to this page if someone visits the root domain above without a short alias.') ?></div>
                            </div>	
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="root404" class="form-label"><?php ee('Domain 404') ?></label>
                                <input type="text" class="form-control p-2" name="root404" id="root404" value="<?php echo old('root404') ?>" placeholder="https://mycompany.com/404">
                                <div class="form-text"><?php ee('Redirects to this page if a short url is not found (error 404).') ?></div>
                            </div>	
                        </div>                
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Domain') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3"><?php ee('Domains') ?></h5>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $total == 0 ? 100 : round($count*100/$total) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $count ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></div>
                </div>            
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('How to setup custom domain') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('If you have a custom domain name that you want to use with our service, you can associate it to your account very easily. Once added, we will add the domain to your account and set it as the default domain name for your URLs. DNS changes could take up to 36 hours.') ?></p>
                <?php if(config("serverip")): ?>
					<p><?php ee("To point your domain name, create an A record and set the value to ") ?><strong><?php echo config("serverip") ?></strong></p>
				<?php endif ?>
            </div>
        </div>
    </div>
</div>