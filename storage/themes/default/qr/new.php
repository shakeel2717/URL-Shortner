<h1 class="h3 mb-5"><?php ee('Create QR') ?></h1>
<form action="<?php echo route('qr.save') ?>" data-trigger="saveqr" method="post" enctype="multipart/form-data">
    <?php echo csrf() ?>
    <input type="hidden" name="type" value="text">
    <div class="row">
        <div class="col-md-3">           
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title fw-bold"><?php ee('Static QR') ?> - <?php ee('Non-Trackable') ?></h5>
                </div>                
                <div class="list-group list-group-flush list-group-dynamic">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="collapse" data-bs-parent="#qrbuilder" href="#text"><i class="me-2" data-feather="type"></i> <?php ee('Text') ?></a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" data-bs-parent="#qrbuilder" href="#vcard"><i class="me-2" data-feather="user"></i> <?php ee('vCard') ?></a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title fw-bold"><?php ee('Dynamic QR') ?> - <?php ee('Trackable') ?></h5>
                </div>                
                <div class="list-group list-group-flush list-group-dynamic">
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" data-bs-parent="#qrbuilder" href="#link"><i class="me-2" data-feather="link"></i> <?php ee('Link') ?></a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" data-bs-parent="#qrbuilder" href="#email"><i class="me-2" data-feather="mail"></i> <?php ee('Email') ?></a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" data-bs-parent="#qrbuilder" href="#phone"><i class="me-2" data-feather="phone"></i> <?php ee('Phone') ?></a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" data-bs-parent="#qrbuilder" href="#sms"><i class="me-2" data-feather="smartphone"></i><?php ee('SMS') ?></a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="collapse" data-bs-parent="#qrbuilder" href="#wifi"><i class="me-2" data-feather="wifi"></i> <?php ee('WiFi') ?></a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body">
                <div class="form-group">
                    <label for="text" class="form-label"><?php ee('QR Code Name') ?></label>
                    <input type="text" class="form-control p-2" name="name" placeholder="e.g. For Instagram">
                </div>                
            </div>                  
            <div class="card" id="qrbuilder">
                <div class="collapse show" id="text">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="type"></i> <?php ee('Text') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Your Text') ?></label>
                            <textarea class="form-control" name="text" placeholder="<?php ee('Your Text') ?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="link">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="link"></i> <?php ee('Link') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Your Link') ?></label>
                            <input type="text" class="form-control p-2" name="link" placeholder="https://"></input>
                        </div>
                    </div>
                </div>  
                <div class="collapse" id="email">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="mail"></i> <?php ee('Email') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Email') ?></label>
                            <input type="email" class="form-control" name="email[email]" placeholder="e.g. someone@domain.com"></input>
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Subject') ?></label>
                            <input type="text" class="form-control p-2" name="email[subject]" placeholder="e.g. <?php ee('Job Application') ?>"></input>
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Message') ?></label>
                            <textarea class="form-control" name="email[body]" placeholder="e.g. <?php ee('Your message here to be sent as email') ?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="phone">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="phone"></i> <?php ee('Phone') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Phone Number') ?></label>
                            <input type="text" class="form-control p-2" name="phone" placeholder="e.g. 123456789"></input>
                        </div>
                    </div>
                </div>  
                <div class="collapse" id="sms">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="smartphone"></i> <?php ee('SMS') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Phone Number') ?></label>
                            <input type="text" class="form-control p-2" name="sms[phone]" placeholder="e.g 123456789"></input>
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Message') ?></label>
                            <input type="text" class="form-control p-2" name="sms[message]" placeholder="e.g. Job Application"></input>
                        </div>
                    </div>
                </div> 
                <div class="collapse" id="vcard">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="user"></i> <?php ee('vCard') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('First Name') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[fname]" placeholder="e.g. John"></input>
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Last Name') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[lname]" placeholder="e.g. Doe"></input>
                        </div> 
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Organization') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[org]" placeholder="e.g. Internet Inc"></input>
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Phone') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[phone]" placeholder="e.g. +112345689"></input>
                        </div>   
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Email') ?></label>
                            <input type="email" class="form-control" name="vcard[email]" placeholder="e.g. someone@domain.com"></input>
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Website') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[site]" placeholder="e.g. https://domain.com"></input>
                        </div> 
                        <div class="btn-group ms-auto">
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#vcard-address">+ <?php ee('Address') ?></button>
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#vcard-social">+ <?php ee('Social') ?></button>
                        </div>
                        <div id="vcard-address" class="collapse">
                            <hr>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Street') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[street]" placeholder="e.g. 123 My Street"></input>
                            </div>    
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('City') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[city]" placeholder="e.g. My City"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('State') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[state]" placeholder="e.g. My State"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Zipcode') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[zip]" placeholder="e.g. 123456"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Country') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[country]" placeholder="e.g. My Country"></input>
                            </div>
                        </div>
                        <div id="vcard-social" class="collapse">
                            <hr>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Facebook') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[facebook]" placeholder="e.g. https://www.facebook.com/myprofile"></input>
                            </div>    
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Twitter') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[twitter]" placeholder="e.g. https://www.twitter.com/myprofile"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Instagram') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[instagram]" placeholder="e.g. https://www.instagram.com/myprofile"></input>
                            </div> 
                            <div class="form-group mb-3">
                                <label for="text" class="form-label"><?php ee('Linekdin') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[linkedin]" placeholder="e.g. https://www.linkedin.com/myprofile"></input>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="collapse" id="wifi">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="wifi"></i> <?php ee('WiFi') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Network SSID') ?></label>
                            <input type="text" class="form-control p-2" name="wifi[ssid]" placeholder="e.g 123456789"></input>
                        </div>                        
                        <div class="form-group mb-3">
                            <label for="text" class="form-label"><?php ee('Password') ?></label>
                            <input type="text" class="form-control p-2" name="wifi[pass]" placeholder="Optional"></input>
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label"><?php ee('Encryption') ?></label>
                            <select name="wifi[encryption]" class="form-control">
                                <option value="wep">WEP</option>
                                <option value="wpa">WPA/WPA2</option>
                            </select>                        
                        </div>
                    </div>                     
                </div>    
                <div class="d-flex m-3">
                    <div class="ms-auto">
                        <button type="button" data-trigger="preview" data-url="<?php echo route("qr.preview") ?>" class="btn btn-primary"><?php ee('Preview') ?></button>
                    </div>
                </div>                            
            </div>
            <div class="card">
				<div class="card-header mt-2">
					<h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <a href="" class="align-middle" data-bs-toggle="collapse" role="button" data-bs-target="#colors"><?php ee('Colors') ?></a></h5>
				</div>				
				<div class="card-body collapse" id="colors">
                    <?php if(\Helpers\QR::hasImagick()): ?>
                    <div class="mb-3">
                        <div class="btn-group">
                            <a href="#singlecolor" class="btn btn-primary btn-sm active" data-bs-toggle="collapse" data-trigger="color" data-bs-parent="#colors"><?php ee('Single Color') ?></a>
                            <a href="#gradient" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-trigger="color" data-bs-parent="#colors"><?php ee('Gradient Color') ?></a>
                        </div>                      
                    </div>
                    <?php endif ?>
                    <div id="singlecolor" class="collapse show">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="bg"><?php ee("Background") ?></label><br>
                                    <input type="text" name="bg" id="bg" value="rgb(255,255,255)">
                                </div>
                            </div>	
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fg"><?php ee("Foreground") ?></label><br>
                                    <input type="text" name="fg" id="fg" value="rgb(0,0,0)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(\Helpers\QR::hasImagick()): ?>
                        <div id="gradient" class="collapse">
                            <input type="hidden" name="mode" value="simple">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="bg"><?php ee("Background") ?></label><br>
                                        <input type="text" name="gradient[bg]" id="gbg" value="rgb(255,255,255)">
                                    </div>
                                </div>	
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col form-group mb-3">
                                            <label class="form-label" for="fg"><?php ee("Gradient Start") ?></label><br>
                                            <input type="text" name="gradient[start]" id="gfg" value="rgb(0,0,0)">
                                        </div>	
                                        <div class="col form-group mb-3">
                                            <label class="form-label" for="fgs"><?php ee("Gradient Stop") ?></label><br>
                                            <input type="text" name="gradient[stop]" id="gfgs" value="rgb(0,0,0)">
                                        </div>                                        
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="fgd"><?php ee("Gradient Direction") ?></label><br>
                                        <select name="gradient[direction]" id="gfgd" class="form-control">
                                            <option value="vertical"><?php ee('Vertical') ?></option>
                                            <option value="horizontal"><?php ee('Horizontal') ?></option>
                                            <option value="radial"><?php ee('Radial') ?></option>
                                            <option value="diagonal"><?php ee('Diagonal') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col form-group mb-3">
                            <label class="form-label" for="fgs"><?php ee("Eye Color") ?></label><br>
                            <input type="text" name="eyecolor" id="eyecolor" value="">
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
								<label class="form-label" for="logo"><?php ee("Custom Logo") ?></label>
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
                                    <input type="radio" name="matrix" value="square" class="me-2" autocomplete="off" checked> <?php ee('Square') ?>
                                </label>
                                <label class="btn d-block text-center border rounded p-3 px-2 h-100">
                                    <i class="mb-3" data-feather="circle"></i><br>
                                    <input type="radio" name="matrix" value="circle" class="me-2" autocomplete="off">  <?php ee('Rounded') ?>
                                </label>
                                <label class="btn d-block text-center border rounded p-3 px-2 h-100">
                                    <i class="mb-3" data-feather="more-horizontal"></i> <br>
                                    <input type="radio" name="matrix" value="dot" class="me-2" autocomplete="off"> <?php ee('Dots') ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label d-block"><?php ee("Eye Style") ?></label>                        
                            <div class="btn-group btn-group-toggle mt-2 border rounded" data-toggle="buttons">
                                <label class="btn d-block text-center border rounded p-3 px-2 h-100">
                                    <i class="mb-3" data-feather="square"></i> <br>
                                    <input type="radio" name="eye" value="square" class="me-2" autocomplete="off" checked>  <?php ee('Square') ?>
                                </label>
                                <label class="btn d-block text-center border rounded p-3 px-2 h-100">
                                    <i class="mb-3" data-feather="circle"></i><br>
                                    <input type="radio" name="eye" value="circle" class="me-2" autocomplete="off"> <?php ee('Circle') ?>
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
                        <img src="<?php echo \Helpers\QR::factory('Sample QR', 400, 0)->format('png')->create('uri') ?>" class="img-responsive w-100 mw-50">
                    </div>    
                    <p class="mt-2"><button type="submit" class="btn btn-primary"><?php ee('Generate QR') ?></button>
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