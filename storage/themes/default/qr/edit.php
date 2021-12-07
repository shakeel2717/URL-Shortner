<h1 class="h3 mb-5"><?php ee('Edit QR') ?></h1>
<form action="<?php echo route('qr.update', [$qr->id]) ?>" method="post">
    <?php echo csrf() ?>
    <input type="hidden" name="type" value="<?php echo $qr->data->type ?>">
    <div class="row">        
        <div class="col-md-9">
            <div class="card card-body">
                <div class="form-group">
                    <label for="text" class="form-label"><?php ee('QR Code Name') ?></label>
                    <input type="text" class="form-control p-2" name="name" value="<?php echo $qr->name ?>" placeholder="e.g. For Instagram">
                </div>                
            </div>                  
            <div class="card" id="qrbuilder">
                <?php if($qr->data->type == 'text'): ?>
                <div id="text">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="type"></i> <?php ee('Text') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Your Text') ?></label>
                            <textarea class="form-control" name="text" placeholder="<?php ee('Your Text') ?>"><?php echo $qr->data->data ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'link'): ?>
                <div id="link">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="link"></i> <?php ee('Link') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Your Link') ?></label>
                            <input type="text" class="form-control p-2" name="link" value="<?php echo $qr->data->data ?>" placeholder="https://"></input>
                        </div>
                    </div>
                </div>  
                <?php endif ?>
                <?php if($qr->data->type == 'email'): ?>
                <div id="email">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="mail"></i> <?php ee('Email') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Email') ?></label>
                            <input type="email" class="form-control" name="email[email]" value="<?php echo $qr->data->data->email ?>" placeholder="e.g. someone@domain.com"></input>
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Subject') ?></label>
                            <input type="text" class="form-control p-2" name="email[subject]" value="<?php echo $qr->data->data->subject ?>" placeholder="e.g. <?php ee('Job Application') ?>"></input>
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Message') ?></label>
                            <textarea class="form-control" name="email[body]" placeholder="e.g. <?php ee('Your message here to be sent as email') ?>"><?php echo $qr->data->data->body ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'phone'): ?>
                <div id="phone">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="phone"></i> <?php ee('Phone') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Phone Number') ?></label>
                            <input type="text" class="form-control p-2" name="phone" value="<?php echo $qr->data->data ?>" placeholder="e.g. 123456789"></input>
                        </div>
                    </div>
                </div>  
                <?php endif ?>
                <?php if($qr->data->type == 'sms'): ?>
                <div id="sms">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="smartphone"></i> <?php ee('SMS') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Phone Number') ?></label>
                            <input type="text" class="form-control p-2" name="sms[phone]" value="<?php echo $qr->data->data->phone ?>" placeholder="e.g 123456789"></input>
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Message') ?></label>
                            <input type="text" class="form-control p-2" name="sms[message]" value="<?php echo $qr->data->data->message ?>" placeholder="e.g. Job Application"></input>
                        </div>
                    </div>
                </div> 
                <?php endif ?>
                <?php if($qr->data->type == 'vcard'): ?>
                <div id="vcard">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="user"></i> <?php ee('vCard') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('First Name') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[fname]" value="<?php echo $qr->data->data->fname ?>" placeholder="e.g. John"></input>
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Last Name') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[lname]" value="<?php echo $qr->data->data->lname ?>" placeholder="e.g. Doe"></input>
                        </div> 
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Organization') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[org]" value="<?php echo $qr->data->data->org ?>" placeholder="e.g. Internet Inc"></input>
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Phone') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[phone]" value="<?php echo $qr->data->data->phone ?>" placeholder="e.g. +112345689"></input>
                        </div>   
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Email') ?></label>
                            <input type="email" class="form-control" name="vcard[email]" value="<?php echo $qr->data->data->email ?>" placeholder="e.g. someone@domain.com"></input>
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Website') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[site]" value="<?php echo $qr->data->data->site ?>" placeholder="e.g. https://domain.com"></input>
                        </div> 
                        <div class="btn-group ms-auto">
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#vcard-address">+ <?php ee('Address') ?></button>
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#vcard-social">+ <?php ee('Social') ?></button>
                        </div>
                        <div id="vcard-address" class="collapse">
                            <hr>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Street') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[street]" value="<?php echo $qr->data->data->street ?>" placeholder="e.g. 123 My Street"></input>
                            </div>    
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('City') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[city]" value="<?php echo $qr->data->data->city ?>" placeholder="e.g. My City"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('State') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[state]" value="<?php echo $qr->data->data->state ?>" placeholder="e.g. My State"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Zipcode') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[zip]" value="<?php echo $qr->data->data->zip ?>" placeholder="e.g. 123456"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Country') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[country]" value="<?php echo $qr->data->data->country ?>" placeholder="e.g. My Country"></input>
                            </div>
                        </div>
                        <div id="vcard-social" class="collapse">
                            <hr>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Facebook') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[facebook]" value="<?php echo $qr->data->data->facebook ?>" placeholder="e.g. https://www.facebook.com/myprofile"></input>
                            </div>    
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Twitter') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[twitter]" value="<?php echo $qr->data->data->twitter ?>" placeholder="e.g. https://www.twitter.com/myprofile"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Instagram') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[instagram]" value="<?php echo $qr->data->data->instagram ?>" placeholder="e.g. https://www.instagram.com/myprofile"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Linekdin') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[linkedin]" value="<?php echo $qr->data->data->linkedin ?>" placeholder="e.g. https://www.linkedin.com/myprofile"></input>
                            </div> 
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'wifi'): ?>
                <div id="wifi">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="wifi"></i> <?php ee('WiFi') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Network SSID') ?></label>
                            <input type="text" class="form-control p-2" name="wifi[ssid]" placeholder="e.g 123456789" value="<?php echo $qr->data->data->ssid ?>"></input>
                        </div>                        
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Password') ?></label>
                            <input type="text" class="form-control p-2" name="wifi[pass]" placeholder="Optional" value="<?php echo $qr->data->data->pass ?>"></input>
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Encryption') ?></label>
                            <select name="wifi[encryption]" class="form-control">
                                <option value="wep" <?php echo $qr->data->data->encryption == "wep" ? 'selected' : '' ?>>WEP</option>
                                <option value="wpa" <?php echo $qr->data->data->encryption == "wpa" ? 'selected' : '' ?>>WPA/WPA2</option>
                            </select>                        
                        </div>
                    </div>                     
                </div>    
                <?php endif ?>
            </div>
            <div class="card">
				<div class="card-header mt-2">
					<h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <a href="" class="align-middle" data-bs-toggle="collapse" role="button" data-bs-target="#colors"><?php ee('Colors') ?></a></h5>
				</div>				
				<div class="card-body collapse" id="colors">
                    <?php if(\Helpers\QR::hasImagick()): ?>
                    <div class="mb-3">
                        <div class="btn-group">
                            <a href="#singlecolor" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-trigger="color" data-bs-parent="#colors"><?php ee('Single Color') ?></a>
                            <a href="#gradient" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-trigger="color" data-bs-parent="#colors"><?php ee('Gradient Color') ?></a>
                        </div>                      
                    </div>
                    <?php endif ?>
                    <div id="singlecolor" class="collapse <?php echo isset($qr->data->color) ? 'show' : '' ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="bg"><?php ee("Background") ?></label><br>
                                    <input type="text" name="bg" id="bg" value="<?php echo isset($qr->data->color) ? $qr->data->color->bg : '' ?>">
                                </div>
                            </div>	
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fg"><?php ee("Foreground") ?></label><br>
                                    <input type="text" name="fg" id="fg" value="<?php echo isset($qr->data->color) ? $qr->data->color->fg : '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(\Helpers\QR::hasImagick()): ?>
                        <div id="gradient" class="collapse <?php echo isset($qr->data->gradient) ? 'show' : '' ?>">
                            <input type="hidden" name="mode" value="<?php echo isset($qr->data->gradient) ? 'gradient' : 'simple' ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="bg"><?php ee("Background") ?></label><br>
                                        <input type="text" name="gradient[bg]" id="gbg" value="<?php echo isset($qr->data->gradient) ? $qr->data->gradient[1] : 'rgb(255,255,255)' ?>">
                                    </div>
                                </div>	
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col form-group mb-3">
                                            <label class="form-label" for="fg"><?php ee("Gradient Start") ?></label><br>
                                            <input type="text" name="gradient[start]" id="gfg" value="<?php echo isset($qr->data->gradient) ? $qr->data->gradient[0][0] : 'rgb(0,0,0)' ?>">
                                        </div>	
                                        <div class="col form-group mb-3">
                                            <label class="form-label" for="fgs"><?php ee("Gradient Stop") ?></label><br>
                                            <input type="text" name="gradient[stop]" id="gfgs" value="<?php echo isset($qr->data->gradient) ? $qr->data->gradient[0][1] : 'rgb(0,0,0)' ?>">
                                        </div>                                        
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="fgd"><?php ee("Gradient Direction") ?></label><br>
                                        <select name="gradient[direction]" id="gfgd" class="form-control">
                                            <option value="vertical" <?php echo isset($qr->data->gradient) && $qr->data->gradient[2] == "vertical" ? 'selected' : '' ?>><?php ee('Vertical') ?></option>
                                            <option value="horizontal" <?php echo isset($qr->data->gradient) && $qr->data->gradient[2] == "horizontal" ? 'selected' : '' ?>><?php ee('Horizontal') ?></option>
                                            <option value="radial" <?php echo isset($qr->data->gradient) && $qr->data->gradient[2] == "radial" ? 'selected' : '' ?>><?php ee('Radial') ?></option>
                                            <option value="diagonal" <?php echo isset($qr->data->gradient) && $qr->data->gradient[2] == "diagonal" ? 'selected' : '' ?>><?php ee('Diagonal') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
				</div>
			</div>
            <div class="card">
				<div class="card-header mt-2">
					<h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <a href="" class="align-middle" data-bs-toggle="collapse" role="button" data-bs-target="#design"><?php ee('Design') ?></a></h5>
				</div>				
				<div class="card-body collapse" id="design">
                    <div class="row mb-5">
                        <div class="col-md-2">
                            <label class="d-block">
                                <input type="radio" name="selectlogo" value="instagram" class="me-2">
                                <img src="<?php echo assets('images/instagram.png') ?>" class="img-fluid w-50">
                            </label>                            
                        </div>
                        <div class="col-md-2">
                            <label class="d-block">
                                <input type="radio" name="selectlogo" value="facebook" class="me-2">
                                <img src="<?php echo assets('images/facebook.png') ?>" class="img-fluid w-50">
                            </label>                            
                        </div>
                        <div class="col-md-2">
                            <label class="d-block">
                                <input type="radio" name="selectlogo" value="youtube" class="me-2">
                                <img src="<?php echo assets('images/youtube.png') ?>" class="img-fluid w-50">
                            </label>                            
                        </div>
                        <div class="col-md-2">
                            <label class="d-block">
                                <input type="radio" name="selectlogo" value="twitter" class="me-2">
                                <img src="<?php echo assets('images/twitter.png') ?>" class="img-fluid w-50">
                            </label>                            
                        </div>
                        <div class="col-md-2">
                            <label class="d-block">
                                <input type="radio" name="selectlogo" value="tiktok" class="me-2">
                                <img src="<?php echo assets('images/tiktok.png') ?>" class="img-fluid w-50">
                            </label>                            
                        </div>
                        <div class="col-md-2">
                            <label class="d-block">
                                <input type="radio" name="selectlogo" value="linkedin" class="me-2">
                                <img src="<?php echo assets('images/linkedin.png') ?>" class="img-fluid w-50">
                            </label>                            
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="logo"><?php ee("Logo") ?></label>
								<input type="file" class="form-control" name="logo" id="logo">
							</div>
						</div>                    						
					</div>
                    <?php if(\Helpers\QR::hasImagick()): ?>
                        <div class="form-group mb-3">
                            <label class="form-label d-block" for="fgd"><?php ee("Matrix Style") ?></label>                        
                            <div class="btn-group btn-group-toggle mt-2 border rounded" data-toggle="buttons">
                                <label class="btn d-block text-center border rounded p-3 px-2 h-100">
                                    <i class="mb-3" data-feather="square"></i><br>
                                    <input type="radio" name="matrix" value="square" class="me-2" autocomplete="off" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'square' ? 'checked' : '' ?>> <?php ee('Square') ?>
                                </label>
                                <label class="btn d-block text-center border rounded p-3 px-2 h-100">
                                    <i class="mb-3" data-feather="circle"></i><br>
                                    <input type="radio" name="matrix" value="circle" class="me-2" autocomplete="off" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'circle' ? 'checked' : '' ?>>  <?php ee('Rounded') ?>
                                </label>
                                <label class="btn d-block text-center border rounded p-3 px-2 h-100">
                                    <i class="mb-3" data-feather="more-horizontal"></i> <br>
                                    <input type="radio" name="matrix" value="dot" class="me-2" autocomplete="off" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'dot' ? 'checked' : '' ?>> <?php ee('Dots') ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label d-block"><?php ee("Eye Style") ?></label>                        
                            <div class="btn-group btn-group-toggle mt-2 border rounded" data-toggle="buttons">
                                <label class="btn d-block text-center border rounded p-3 px-2 h-100">
                                    <i class="mb-3" data-feather="square"></i> <br>
                                    <input type="radio" name="eye" value="square" class="me-2" autocomplete="off" <?php echo isset($qr->data->eye) && $qr->data->eye == 'square' ? 'checked' : '' ?>>  <?php ee('Square') ?>
                                </label>
                                <label class="btn d-block text-center border rounded p-3 px-2 h-100">
                                    <i class="mb-3" data-feather="circle"></i><br>
                                    <input type="radio" name="eye" value="circle" class="me-2" autocomplete="off"<?php echo isset($qr->data->eye) && $qr->data->eye == 'circle' ? 'checked' : '' ?>> <?php ee('Circle') ?>
                                </label>
                            </div>
                        </div>
                    <?php endif ?>
				</div>
			</div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title fw-bold"><?php ee('QR Code') ?></h5>
                </div>
                <div class="card-body">
                    <div id="return-ajax">
                        <img src="<?php echo route('qr.generate', [$qr->alias]) ?>" class="img-responsive w-100 mw-50">
                    </div>    
                    <button type="submit" class="btn btn-primary mt-3"><?php ee('Update') ?></button>
                </div>
            </div>
            <div class="card card-body">
                <div class="form-text">
                    <?php ee("You will be able to download the QR code in PDF or SVG after it has been generated.") ?>
                </div>
            </div>
        </div>
    </div>
</form>