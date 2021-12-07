<div id="return-error"></div>
<form action="<?php echo route('shorten') ?>" method="post" data-trigger="shorten-form" enctype="multipart/form-data">
    <?php echo csrf() ?>
    <div class="d-flex items-align-center border rounded">
        <div class="flex-grow-1" id="linksinput">
            <div id="single" class="collapse show" data-bs-parent="#linksinput">
                <input type="text" class="form-control p-3 border-0" name="url" id="url" placeholder="<?php ee('Paste a long link') ?>">
            </div>
            <div id="multiple" class="collapse" data-bs-parent="#linksinput">
                <textarea name="urls" rows="5" class="form-control p-3 border-0" name="urls" id="urls" placeholder="<?php ee('Paste up to 10 long urls. One URL per line.') ?>"></textarea>
                <input type="hidden" name="multiple" value="0">
            </div>
        </div>
        <div class="align-self-center me-3">
            <div class="btn-group">
                <button type="button" class="btn btn-default border" data-bs-toggle="collapse" data-bs-target="#advancedOptions"><i data-feather="sliders"></i></button>
                <button type="submit" class="btn btn-primary">
                    <span class="d-none d-sm-block"><?php ee('Shorten') ?></span>
                    <span class="d-block d-sm-none"><i class="fa fa-link"></i></span>
                </button>
            </div>
        </div>
    </div>
    <div class="collapse" id="advancedOptions">
        <div class="row">
            <?php if($domains = \Helpers\App::domains()): ?>
            <div class="col-sm-6 mt-3">
                <div class="form-group rounded input-select">
                    <label for="domain" class="form-label"><?php ee('Domain') ?></label>
                    <select name="domain" id="domain" class="form-control border-start-0 ps-0" data-toggle="select">
                        <?php foreach($domains as $domain): ?>
                            <option value="<?php echo $domain ?>" <?php echo user()->domain == $domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <?php endif ?>
            <?php if($redirects = \Helpers\App::redirects()): ?>
            <div class="col-sm-6 mt-3">
                <div class="form-group rounded input-select">
                    <label for="type" class="form-label"><?php ee('Redirect') ?></label>
                    <select name="type" id="type" class="form-control border-start-0 ps-0" data-toggle="select">
                        <?php foreach($redirects as $name => $redirect): ?>
                            <optgroup label="<?php echo $name ?>">
                            <?php foreach($redirect as $id => $name): ?>
                                <option value="<?php echo $id ?>" <?php echo user()->defaulttype == $id ? 'selected' : '' ?>><?php echo $name ?></option>
                            <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>         
            <?php endif ?>   
        </div>
        <hr>
        <div class="row">
            <?php if(\Core\Auth::user()->has("alias") !== false): ?>
            <div class="col-sm-6 mt-3">
                <div class="form-group">
                    <label for="custom" class="form-label"><?php ee('Custom') ?></label>
                    <p class="form-text"><?php ee('If you need a custom alias, you can enter it below.') ?></p>
                    <div class="input-group">
                        <div class="input-group-text bg-white"><i data-feather="globe"></i></div>
                        <input type="text" class="form-control border-start-0 ps-0" name="custom" id="custom" placeholder="<?php echo e("Type your custom alias here")?>" autocomplete="off">
                    </div>
                </div>
            </div>
            <?php endif ?>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label for="pass" class="form-label"><?php ee('Password Protection') ?></label>
                    <p class="form-text"><?php ee('By adding a password, you can restrict the access.') ?></p>
                    <div class="input-group">
                        <div class="input-group-text bg-white"><i data-feather="lock"></i></div>
                        <input type="text" class="form-control border-start-0 ps-0" name="pass" id="pass" placeholder="<?php echo e("Type your password here")?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label for="expiry" class="form-label"><?php ee('Link Expiration') ?></label>
                    <p class="form-text"><?php ee('Set an expiration date to disable the link.') ?></p>
                    <div class="input-group">
                        <div class="input-group-text bg-white"><i data-feather="lock"></i></div>
                        <input type="text" class="form-control border-start-0 ps-0" data-toggle="datepicker" name="expiry" id="expiry" placeholder="<?php echo e("MM/DD/YYYY")?>" autocomplete = "off">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label for="expiry" class="form-label"><?php echo e("Description")?></label>
                    <p class="form-text"><?php echo e('This can be used to identify URLs on your account.')?></p>                  
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i data-feather="tag"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" name="description" id="description" placeholder="<?php echo e("Type your description here")?>" autocomplete = "off">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex mt-4">
            <div class="btn-group ms-auto">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#metatags">+ <?php ee('Meta Tags') ?></button>
                <?php if(config("geotarget") && \Core\Auth::user()->has("geo") !== false):?>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#geo">+ <?php ee('Geo Targeting') ?></button>
                <?php endif ?>
                <?php if(config("devicetarget") && \Core\Auth::user()->has("device") !== false):?>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#device">+ <?php ee('Device Targeting') ?></button>
                <?php endif ?>
                <?php if(\Core\Auth::user()->has("pixels") !== false):?>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#pixels">+ <?php ee('Pixels') ?></button>
                <?php endif ?>
                <?php if(\Core\Auth::user()->has("parameters") !== false):?>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#parameters">+ <?php ee('Parameters') ?></button>
                <?php endif ?>
            </div>
        </div>
        <div id="metatags" class="mt-4 collapse">
            <hr>
            <h4><?php echo e("Meta Tags")?></h4>
            <div class="row">   
                <div class="col-lg-4 col-md-6 mt-3">
                    <div class="form-group">
                        <label for="metaimage" class="form-label"><?php ee('Custom Banner') ?></label>                                  
                        <input type="file" class="form-control" name="metaimage" id="metaimage" placeholder="<?php echo e("Enter your custom meta title")?>" autocomplete="off">
                    </div>                 
                </div>
                <div class="col-lg-4 col-md-6 mt-3">
                    <div class="form-group">
                        <label for="metatitle" class="form-label"><?php ee('Meta Title') ?></label>                    
                        <input type="text" class="form-control" name="metatitle" id="metatitle" placeholder="<?php echo e("Enter your custom meta title")?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-3">
                    <div class="form-group">
                        <label for="metadescription" class="form-label"><?php ee('Meta Description') ?></label>                    
                        <input type="text" class="form-control" name="metadescription" id="metadescription" placeholder="<?php echo e("Enter your custom meta description")?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <?php if(config("geotarget") && \Core\Auth::user()->has("geo") !== false):?>
            <div class="collapse mt-4" id="geo">
                <hr>
                <div class="d-flex">
                    <h4><?php echo e("Geo Targeting")?></h4>
                    <div class="ms-auto">
                        <a href="#" class="btn btn-sm btn-primary" data-trigger="addmore" data-for="geo"><?php echo e("+ Add")?></a>
                    </div>
                </div>
                <p class="form-text"><?php echo e('If you have different pages for different countries then it is possible to redirect users to that page using the same URL. Simply choose the country and enter the URL.')?></p>           
                <div class="row" data-toggle="addable" data-label="geo" data-states="<?php echo route('server.states') ?>">
                    <div class="col col-sm-6 mt-3">
                        <div class="input-group input-select">
                            <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                            <select name="location[]" class="form-control border-start-0 ps-0" data-trigger="getStates" data-toggle="select">
                                <?php echo \Core\Helper::Country('United States', true) ?>
                            </select>
                        </div>
                    </div>
                    <div class="col col-sm-6 mt-3">
                        <div class="input-group input-select">
                            <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                            <select name="state[]" class="form-control border-start-0 ps-0" data-toggle="select">
                                <option value="0"><?php ee('All States') ?></option>
                                <?php foreach(\Helpers\App::states('United States') as $state): ?>
                                    <option value="<?php echo strtolower($state->name) ?>"><?php echo $state->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col col-sm-12 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                            <input type="text" name="target[]" class="form-control border-start-0 ps-0 p-1" placeholder="<?php echo e("Type the url to redirect user to.")?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if(config("devicetarget") && \Core\Auth::user()->has("device") !== false):?>
            <div class="row collapse mt-4" id="device">
                <hr>
                <div class="d-flex">
                    <h4><?php echo e("Device Targeting")?></h4>
                    <div class="ms-auto">
                        <a href="#" class="btn btn-sm btn-primary" data-trigger="addmore" data-for="device"><?php echo e("+ Add")?></a>
                    </div>
                </div>
                <p class="form-text">
                    <?php echo e('If you have different pages for different devices (such as mobile, tablet etc) then it is possible to redirect users to that page using the same short URL. Simply choose the device and enter the URL.')?>
                </p>
                <div class="row" data-toggle="addable" data-label="device">
                    <div class="col-sm-6 mt-3">
                        <div class="input-group input-select">
                            <span class="input-group-text bg-white"><i data-feather="smartphone"></i></span>
                            <select name="device[]" class="form-control border-start-0 ps-0" data-toggle="select">
                                <?php echo \Core\Helper::devices() ?>
                            </select>
                        </div>              
                    </div>
                    <div class="col-sm-6 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                            <input type="text" name="dtarget[]" class="form-control border-start-0 ps-0" placeholder="<?php echo e("Type the url to redirect user to.")?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if(\Core\Auth::user()->has("pixels") !== false):?>
            <div id="pixels" class="collapse mt-4">
                <hr>
                <h4><?php echo e("Targeting Pixels")?></h4>
                <p class="form-text"><?php echo e('Add your targeting pixels below from the list. Please make sure to enable them in the pixels settings.')?></p>
                <div class="input-group input-select">
                    <span class="input-group-text bg-white"><i data-feather="filter"></i></span>
                    <select name="pixels[]" data-placeholder="Your Pixels" multiple data-toggle="select">
                        <?php foreach(\Core\Auth::user()->pixels() as $type => $pixels): ?>     
                            <optgroup label="<?php echo ucwords($type) ?>">                       
                            <?php foreach($pixels as $pixel): ?>
                                <option value="<?php echo $pixel->type ?>-<?php echo $pixel->id ?>"><?php echo $pixel->name ?></option>                                
                            <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        <?php endif ?>
        <?php if (\Core\Auth::user()->has("parameters") !== false): ?>
            <div class="collapse mt-4" id="parameters">
                <hr>
                <div class="d-flex">
                    <h4><?php echo e("Parameter Builder")?></h4>
                    <div class="ms-auto">
                        <a href="#" class="btn btn-sm btn-primary" data-trigger="addmore" data-for="parameters"><?php echo e("+ Add")?></a>
                    </div>
                </div>
                <p class="form-text">
                    <?php echo e("You can add custom parameters like UTM to the link above using this tool. Choose the parameter name and then assign a value. These will be added during redirection.")?>
                </p>
                <div class="row" data-toggle="addable" data-label="parameters">
                    <div class="col-sm-6 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="list"></i></span>
                            <input type="text" name="paramname[]" class="form-control border-start-0 ps-0" data-trigger="autofillparam" placeholder="<?php echo e("Parameter name")?>">
                        </div>              
                    </div>              
                    <div class="col-sm-6 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="edit"></i></span>
                            <input type="text" name="paramvalue[]" class="form-control border-start-0 ps-0" placeholder="<?php echo e("Parameter value")?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
    <div class="d-flex mt-4">
        <div class="btn-group ms-auto">
            <button type="button" class="btn btn-primary btn-sm active" data-bs-toggle="collapse" data-trigger="toggleSM" data-value="single" data-bs-target="#single">+ <?php ee('Single') ?></button>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-trigger="toggleSM" data-value="multiple" data-bs-target="#multiple">+ <?php ee('Multiple') ?></button>
        </div>
    </div>
</form>