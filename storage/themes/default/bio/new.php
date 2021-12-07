<h1 class="h3 mb-5"><?php ee('Create Bio') ?></h1>
<form action="<?php echo route('bio.save') ?>" method="post">
    <?php echo csrf() ?>
    <div class="row">
        <div class="col-md-8" id="generator">
            <div class="card card-body">
                <div class="form-group">
                    <label class="form-label"><?php ee('Bio Page Name') ?></label>
                    <input type="text" class="form-control p-2" name="name" placeholder="e.g. For Instagram" data-required>
                </div>
                <div class="form-group mt-4">
                    <label class="form-label"><?php ee('Bio Page Alias') ?></label>
                    <div class="d-flex">
                        <div>
                            <select name="domain" id="domain" class="form-control p-2" data-toggle="select">
                                <?php foreach($domains as $domain): ?>
                                    <option value="<?php echo $domain ?>"><?php echo $domain ?></option>
                                <?php endforeach ?>
                            </select>
                            <p class="form-text"><?php ee('Choose domain to generate the link with.') ?></p>
                        </div>
                        <div class="ms-3">
                            <input type="text" class="form-control p-2" name="custom" placeholder="e.g. my-page">
                            <p class="form-text"><?php ee('Leave this field empty to generate a random alias.') ?></p>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="card card-body">
                <div class="form-group mb-4 d-flex align-items-center">
                    <div class="me-3">
                        <img src="<?php echo user()->avatar()?>" width="100" class="rounded" id="useravatar">
                    </div>
                    <div>
                        <label for="avatar" class="form-label"><?php ee('Custom Avatar') ?></label>				    	
                        <input type="file" name="avatar" id="avatar" class="form-control mb-2">
                        <p class="form-text"><?php ee('We recommend you choose a square picture with a maximum size of 300x300 and 500kb.') ?></p>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="#links" class="nav-link active" data-bs-toggle="collapse" data-bs-parent="#generator"><?php ee('Links') ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#social" class="nav-link" data-bs-toggle="collapse" data-bs-parent="#generator"><?php ee('Social Links') ?></a>
                    </li>
                    <li class="nav-item ms-1">
                        <a href="#appearance" class="nav-link" data-bs-toggle="collapse" data-bs-parent="#generator"><?php ee('Appearance') ?></a>
                    </li>                    
                </ul>
            </div>
            <div class="collapse show" id="links">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="link"></i> <?php ee('Links') ?></h5>
                    </div>
                    <div class="card-body">
                        <div id="linkcontent"></div>
                        <div class="text-center">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contentModal"><?php ee('Add Link or Content') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card collapse" id="social">
                <div class="card-body">
                    <div class="form-group mt-3">
                        <label class="form-label"><?php ee('Facebook') ?></label>
                        <input type="text" class="form-control p-2" name="social[facebook]" placeholder="https://" data-error="<?php ee('Please enter a valid link') ?>">                        
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label"><?php ee('Twitter') ?></label>
                        <input type="text" class="form-control p-2" name="social[twitter]" placeholder="https://" data-error="<?php ee('Please enter a valid link') ?>">                        
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label"><?php ee('Instagram') ?></label>
                        <input type="text" class="form-control p-2" name="social[instagram]" placeholder="https://" data-error="<?php ee('Please enter a valid link') ?>">                        
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label"><?php ee('Tiktok') ?></label>
                        <input type="text" class="form-control p-2" name="social[tiktok]" placeholder="https://" data-error="<?php ee('Please enter a valid link') ?>">                        
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label"><?php ee('Linkedin') ?></label>
                        <input type="text" class="form-control p-2" name="social[linkedin]" placeholder="https://" data-error="<?php ee('Please enter a valid link') ?>">                        
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label"><?php ee('Youtube') ?></label>
                        <input type="text" class="form-control p-2" name="social[youtube]" placeholder="https://" data-error="<?php ee('Please enter a valid link') ?>">                        
                    </div>
                </div>
            </div>
            <div class="card collapse" id="appearance">
				<div class="card-header mt-2">
					<h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <?php ee('Appearance') ?></h5>
				</div>				
				<div class="card-body">
                    <h5><?php ee('Templates') ?></h5>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <a href="#" class="d-block text-center border rounded p-3 d-flex align-self-stretch" style="height:100px;background: linear-gradient(90deg, #1CB5E0 0%, #000851 100%);" onclick="changeTheme('#1CB5E0', '#1CB5E0', '#000851', '#000851', '#ffffff', '#ffffff');">
                                <h5 class="text-white">Midnight Blue</h5>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="d-block text-center border rounded p-3 d-flex align-self-stretch" style="height:100px;background: linear-gradient(90deg, #FC466B 0%, #3F5EFB 100%);" onclick="changeTheme('#FC466B', '#3F5EFB', '#FC466B', '#ffffff', '#FC466B', '#ffffff');">
                                <h5 class="text-white">Disco Club</h5>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="d-block text-center border rounded p-3 d-flex align-self-stretch" style="height:100px;background: linear-gradient(90deg, #FDBB2D 0%, #22C1C3 100%);" onclick="changeTheme('#FDBB2D', '#22C1C3', '#FDBB2D', '#ffffff', '#FDBB2D', '#ffffff');">
                                <h5 class="text-white">Retro City</h5>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="d-block text-center border rounded p-3 d-flex align-self-stretch" style="height:100px;background: linear-gradient(90deg, #00c6ff 0%, #0072ff 100%);" onclick="changeTheme('#00c6ff', '#0072ff', '#00c6ff', '#ffffff', '#00c6ff', '#ffffff');">
                                <h5 class="text-white">Aqua Ocean</h5>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <a href="#" class="d-block text-center border rounded p-3 d-flex align-self-stretch" style="height:100px;background: linear-gradient(90deg, #d53369 0%, #daae51 100%);" onclick="changeTheme('#d53369', '#daae51', '#d53369', '#ffffff', '#d53369', '#ffffff');">
                                <h5 class="text-white">Sunlight Paradise</h5>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="d-block text-center border rounded p-3 d-flex align-self-stretch" style="height:100px;background: linear-gradient(90deg, #ED4264 0%, #FFEDBC 100%);" onclick="changeTheme('#ED4264', '#FFEDBC', '#ED4264', '#ffffff', '#ED4264', '#ffffff');">
                                <h5 class="text-white">Peach</h5>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="d-block text-center border rounded p-3 d-flex align-self-stretch" style="height:100px;background: linear-gradient(90deg, #232526 0%, #414345 100%);" onclick="changeTheme('#232526', '#414345', '#232526', '#ffffff', '#232526', '#ffffff');">
                                <h5 class="text-white">Black Canary</h5>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="d-block text-center border rounded p-3 d-flex align-self-stretch" style="height:100px;background: #76b852" onclick="changeTheme('#ffffff', '#ffffff', '#ffffff', '#76b852', '#ffffff', '#000000');">
                                <h5 class="text-white">White Lime</h5>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <h5><?php ee('Background') ?></h5>
                    <div class="mb-3 mt-3">
                        <div class="btn-group">
                            <a href="#singlecolor" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-parent="#appearance"><?php ee('Single Color') ?></a>
                            <a href="#gradient" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-parent="#appearance"><?php ee('Gradient Color') ?></a>
                        </div>                      
                    </div>
                    <div id="singlecolor" class="collapse show">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="bg"><?php ee("Background") ?></label><br>
                                    <input type="text" name="bg" id="bg" value="rgb(255,255,255)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="gradient" class="collapse">                        
                        <div class="row">                            
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fg"><?php ee("Gradient Start") ?></label><br>
                                    <input type="text" name="gradient[start]" id="bgst" value="#000">
                                </div>	
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fgs"><?php ee("Gradient Stop") ?></label><br>
                                    <input type="text" name="gradient[stop]" id="bgsp" value="#000">
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <h5><?php ee('Text Color') ?></h5>
                    <div class="form-group mb-4">
                        <input type="text" name="textcolor" id="textcolor" value="#000">
                    </div>                       
                    <h5><?php ee('Button Color') ?></h5>
                    <div class="form-group mb-4">
                        <input type="text" name="buttoncolor" id="buttoncolor" value="#fff">
                    </div>
                    <h5><?php ee('Button text Color') ?></h5>
                    <div class="form-group mb-4">
                        <input type="text" name="buttontextcolor" id="buttontextcolor" value="#fff">
                    </div>                 
				</div>
			</div>
        </div>
        <div class="col-md-4">
            <div id="preview">
                <div class="card">
                    <div class="text-center" style="max-height:600px;overflow-y:scroll">
                        <img src="<?php echo user()->avatar() ?>" id="userimage" class="rounded-circle my-3 border" height="120" width="120">
                        <h3><span></span></h3></em>
                        <div class="card-body">
                            <div id="social" class="text-center mt-2">
                            </div>
                            <div id="content" class="mt-5">
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"><?php ee('Save') ?></button>
</form>
<div class="modal fade" id="contentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Add Link or Content') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="modalcontent">
            <div class="collapse show" id="options">
                <div class="row">
                    <div class="col-md-3">
                        <a href="#modal-text" class="d-block text-center border rounded p-3 h-100" data-bs-toggle="collapse" data-bs-parent="#modalcontent">
                            <h3><i data-feather="align-center" class="mb-3"></i></h3>
                            <h5><?php ee('Text') ?></h5>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#modal-links" class="d-block text-center border rounded p-3 h-100" data-bs-toggle="collapse" data-bs-parent="#modalcontent">
                            <h3><i data-feather="link" class="mb-3"></i></h3>
                            <h5><?php ee('Links') ?></h5>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#modal-youtube" class="d-block text-center border rounded py-3 px-2 h-100" data-bs-toggle="collapse" data-bs-parent="#modalcontent">
                            <img src="<?php echo assets('images/youtube.svg') ?>" width="30" class="mb-3">
                            <h5><?php ee('Youtube Video') ?></h5>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#modal-whatsapp" class="d-block text-center border rounded py-3 px-2 h-100" data-bs-toggle="collapse" data-bs-parent="#modalcontent">
                            <img src="<?php echo assets('images/whatsapp.svg') ?>" width="30" class="mb-3">
                            <h5><?php ee('WhatsApp Call') ?></h5>
                        </a>                        
                    </div>                    
                </div>
                <div class="row mt-3">                
                    <div class="col-md-3">
                        <a href="#modal-spotify" class="d-block text-center border rounded py-3 px-2 h-100" data-bs-toggle="collapse" data-bs-parent="#modalcontent">
                            <img src="<?php echo assets('images/spotify.svg') ?>" width="30" class="mb-3">
                            <h5><?php ee('Spotify Embed') ?></h5>
                        </a>
                    </div>                    
                    <div class="col-md-3">
                        <a href="#modal-itunes" class="d-block text-center border rounded py-3 px-2 h-100" data-bs-toggle="collapse" data-bs-parent="#modalcontent">
                            <img src="<?php echo assets('images/itunes.svg') ?>" width="30" class="mb-3">
                            <h5><?php ee('Apple Music Embed') ?></h5>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#modal-paypal" class="d-block text-center border rounded py-3 px-2 h-100" data-bs-toggle="collapse" data-bs-parent="#modalcontent">
                            <img src="<?php echo assets('images/paypal.svg') ?>" width="30" class="mb-3">
                            <h5><?php ee('Paypal Button') ?></h5>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#modal-tiktok" class="d-block text-center border rounded py-3 px-2 h-100" data-bs-toggle="collapse" data-bs-parent="#modalcontent">
                            <img src="<?php echo assets('images/tiktok.svg') ?>" width="30" class="mb-3">
                            <h5><?php ee('Tiktok Embed') ?></h5>
                        </a>
                    </div>
                </div>                
            </div>
            <div id="modal-text" class="collapse" data-name="<?php echo e('Text') ?>">
                <a href="#options" data-bs-toggle="collapse" data-bs-parent="#modalcontent" class="mb-4 d-block"><i data-feather="chevron-left"></i> <?php ee('Back') ?></a>
                <div class="form-group">
                    <label class="form-label"><?php ee('Text') ?></label>
                    <textarea class="form-control p-2" name="content" placeholder="e.g. some description here"></textarea>
                </div>
                <button type="button" data-trigger="insertcontent" data-type="text" class="btn btn-primary mt-3"><?php ee('Add Text') ?></button>
            </div>
            <div id="modal-links" class="collapse" data-name="<?php echo e('Links') ?>">
                <a href="#options" data-bs-toggle="collapse" data-bs-parent="#modalcontent" class="mb-4 d-block"><i data-feather="chevron-left"></i> <?php ee('Back') ?></a>
                <div class="form-group">
                    <label class="form-label"><?php ee('Text') ?></label>
                    <input type="text" class="form-control p-2" name="text" placeholder="e.g. My Site">                        
                </div>
                <div class="form-group mt-3">
                    <label class="form-label"><?php ee('Link') ?></label>
                    <input type="text" class="form-control p-2" name="link" placeholder="https://" data-error="<?php ee('Please enter a valid link') ?>">                        
                </div>
                <button type="button" data-trigger="insertcontent" data-type="link" class="btn btn-primary mt-3"><?php ee('Add Link') ?></button>
            </div>
            <div id="modal-image" class="collapse" data-name="<?php echo e('Image') ?>">
                <a href="#options" data-bs-toggle="collapse" data-bs-parent="#modalcontent" class="mb-4 d-block"><i data-feather="chevron-left"></i> <?php ee('Back') ?></a>
                <div class="form-group">
                    <label class="form-label"><?php ee('Image') ?></label>
                    <input type="file" class="form-control p-2" name="file" placeholder="e.g https://www.youtube.com/watch?v=dQw4w9WgXcQ">                        
                </div>
                <button type="button" data-trigger="insertcontent" data-type="image" class="btn btn-primary mt-3"><?php ee('Add Image') ?></button>
            </div>            
            <div id="modal-youtube" class="collapse" data-name="<?php echo e('Youtube Video') ?>">
                <a href="#options" data-bs-toggle="collapse" data-bs-parent="#modalcontent" class="mb-4 d-block"><i data-feather="chevron-left"></i> <?php ee('Back') ?></a>
                <div class="form-group">
                    <label class="form-label"><?php ee('Link to Video') ?></label>
                    <input type="text" class="form-control p-2" name="link" placeholder="e.g https://www.youtube.com/watch?v=dQw4w9WgXcQ" data-error="<?php ee('Please enter a valid youtube link') ?>">                        
                </div>
                <button type="button" data-trigger="insertcontent" data-type="youtube" class="btn btn-primary mt-3"><?php ee('Add Youtube Video') ?></button>
            </div>
            <div id="modal-whatsapp" class="collapse" data-name="<?php echo e('WhatsApp Call') ?>">
                <a href="#options" data-bs-toggle="collapse" data-bs-parent="#modalcontent" class="mb-4 d-block"><i data-feather="chevron-left"></i> <?php ee('Back') ?></a>
                <div class="form-group">
                    <label class="form-label"><?php ee('Phone Number') ?></label>
                    <input type="text" class="form-control p-2" name="phone" placeholder="e.g +1123456789">                        
                </div>
                <div class="form-group mt-2">
                    <label class="form-label"><?php ee('Label') ?></label>
                    <input type="text" class="form-control p-2" name="label" placeholder="e.g Call us">                        
                </div>
                <button type="button" data-trigger="insertcontent" data-type="whatsapp" class="btn btn-primary mt-3"><?php ee('Add WhatsApp Call') ?></button>
            </div>
            <div id="modal-spotify" class="collapse" data-name="<?php echo e('Spotify Embed') ?>">
                <a href="#options" data-bs-toggle="collapse" data-bs-parent="#modalcontent" class="mb-4 d-block"><i data-feather="chevron-left"></i> <?php ee('Back') ?></a>
                <div class="form-group">
                    <label class="form-label"><?php ee('Link to Spotify Song') ?></label>
                    <input type="text" class="form-control p-2" name="link" placeholder="e.g https://open.spotify.com/track/6PQ88X9TkUIAUIZJHW2upE?si=e8ab004e890a4d2f" data-error="<?php ee('Please enter a valid spotify link') ?>">                        
                </div>
                <button type="button" data-trigger="insertcontent" data-type="spotify" class="btn btn-primary mt-3"><?php ee('Add Spotify') ?></button>
            </div>
            <div id="modal-itunes" class="collapse" data-name="<?php echo e('Apple Music Embed') ?>">
                <a href="#options" data-bs-toggle="collapse" data-bs-parent="#modalcontent" class="mb-4 d-block"><i data-feather="chevron-left"></i> <?php ee('Back') ?></a>
                <div class="form-group">
                    <label class="form-label"><?php ee('Link to Apple Music Song') ?></label>
                    <input type="text" class="form-control p-2" name="link" placeholder="e.g https://music.apple.com/us/album/acapulco-jay-robinson-remix-single/1590557278" data-error="<?php ee('Please enter a valid apple music link') ?>">                        
                </div>
                <button type="button" data-trigger="insertcontent" data-type="itunes" class="btn btn-primary mt-3"><?php ee('Add Apple Music') ?></button>
            </div>
            <div id="modal-paypal" class="collapse" data-name="<?php echo e('PayPal Button') ?>">
                <a href="#options" data-bs-toggle="collapse" data-bs-parent="#modalcontent" class="mb-4 d-block"><i data-feather="chevron-left"></i> <?php ee('Back') ?></a>
                <div class="form-group">
                    <label class="form-label"><?php ee('Label') ?></label>
                    <input type="text" class="form-control p-2" name="label" placeholder="e.g New Hoodie For Sale">
                </div>                
                <div class="form-group mt-3">
                    <label class="form-label"><?php ee('PayPal Email') ?></label>
                    <input type="text" class="form-control p-2" name="email" placeholder="e.g myemail@domain.com">
                </div>
                <div class="form-group mt-3">
                    <label class="form-label"><?php ee('Amount') ?></label>
                    <input type="text" class="form-control p-2" name="amount" placeholder="e.g 10">
                </div>
                <div class="form-group mt-3">
                    <label class="form-label d-block mb-2"><?php ee('Currency') ?></label>
                    <select name="currency" data-toggle="select" class="form-control">
                        <?php foreach(\Helpers\App::currency() as $code => $currency): ?>
                            <option value="<?php echo $code ?>" <?php echo $code == "USD" ? 'selected' : '' ?>><?php echo $currency['label'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <button type="button" data-trigger="insertcontent" data-type="paypal" class="btn btn-primary mt-3"><?php ee('Add Paypal') ?></button>
            </div>
            <div id="modal-tiktok" class="collapse" data-name="<?php echo e('Tiktok Embed') ?>">
                <a href="#options" data-bs-toggle="collapse" data-bs-parent="#modalcontent" class="mb-4 d-block"><i data-feather="chevron-left"></i> <?php ee('Back') ?></a>
                <div class="form-group">
                    <label class="form-label"><?php ee('Link to Tiktok Video') ?></label>
                    <input type="text" class="form-control p-2" name="link" placeholder="e.g https://www.tiktok.com/@marvel/video/7016405255604817157" data-error="<?php ee('Please enter a valid tiktok link') ?>">                        
                </div>
                <button type="button" data-trigger="insertcontent" data-type="tiktok" class="btn btn-primary mt-3"><?php ee('Add Tiktok') ?></button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>