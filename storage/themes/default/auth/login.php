<section>
    <a href="<?php echo route('home') ?>" class="btn btn-white btn-icon-only rounded-circle position-absolute zindex-101 left-4 top-4 d-none d-lg-inline-flex" data-toggle="tooltip" data-placement="right" title="Go back">
        <span class="btn-inner--icon">
            <i data-feather="arrow-left"></i>
        </span>
    </a>
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center justify-content-center justify-content-lg-start min-vh-100">
            <div class="col-sm-7 col-lg-6 col-xl-6 py-6 py-md-0">
                <div class="row justify-content-center">
                    <div class="col-11 col-lg-10 col-xl-6">
                        <div>
                            <?php message() ?>
                            <span class="clearfix"></span>
                            <form method="post" action="<?php echo route('login.auth') ?>">                                
                                <div class="form-group">
                                    <label class="form-control-label"><?php ee('Email or username') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepend" id="input-email" name="email" placeholder="">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i data-feather="user"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <label class="form-control-label"><?php ee('Password') ?></label>
                                        </div>                                        
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control form-control-prepend form-control-append" id="input-password" name="password" placeholder="">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i data-feather="key"></i></span>
                                        </div>
                                        
                                    </div>
                                    <div class="d-flex mt-2">
                                        <div class="ml-auto">
                                            <a href="<?php echo route('forgot') ?>" class="small text-muted text-underline--dashed border-primary"><?php ee('Forgot Password?') ?></a>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="my-4">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="rememberme" name="rememberme"> 
                                        <label class="custom-control-label" for="rememberme"><strong><?php ee('Remember me') ?></strong></label>
                                    </div>
                                </div>                                
                                <div class="mt-4">
                                    <?php echo \Helpers\Captcha::display() ?>
                                    <?php echo csrf() ?>
                                    <button type="submit" class="btn btn-block btn-primary"><?php ee('Login') ?></button>
                                </div>
                            </form>
                            <?php if(config("user") && !config("private") && !config("maintenance")): ?>
                                <?php if(config('fb_connect') || config('tw_connect') || config('gl_connect')): ?>
                                    <div class="py-3 text-center">
                                        <span class="text-xs text-uppercase"><?php ee('or') ?></span>
                                    </div>                                    
                                    <div class="row">
                                        <?php if(config('fb_connect')): ?>
                                            <div class="col-sm-12 mb-2">
                                                <a href="<?php echo route('login.facebook') ?>" class="btn btn-block btn-neutral btn-icon mb-3 mb-sm-0">
                                                    <span class="btn-inner--icon"><img src="<?php echo assets('images/facebook.svg') ?>" alt="<?php echo e("Sign in with") ?> Facebook"></span>
                                                    <span class="btn-inner--text"><?php echo e("Sign in with") ?> Facebook</span>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                        <?php if(config('gl_connect')): ?>
                                            <div class="col-sm-12 mb-2">
                                                <a href="<?php echo route('login.google') ?>" class="btn btn-block btn-neutral btn-icon mb-3 mb-sm-0">
                                                    <span class="btn-inner--icon"><img src="<?php echo assets('images/google.svg') ?>" alt="<?php echo e("Sign in with") ?> Google"></span>
                                                    <span class="btn-inner--text"><?php echo e("Sign in with") ?> Google</span>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                        <?php if(config('tw_connect')): ?>
                                            <div class="col-sm-12 mb-2">
                                                <a href="<?php echo route('login.twitter') ?>" class="btn btn-block btn-neutral btn-icon mb-3 mb-sm-0">
                                                    <span class="btn-inner--icon"><img src="<?php echo assets('images/twitter.svg') ?>" alt="<?php echo e("Sign in with") ?> Twitter"></span>
                                                    <span class="btn-inner--text"><?php echo e("Sign in with") ?> Twitter</span>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
            &copy; <?php echo date("Y") ?> <a href="<?php echo config('url') ?>" class="font-weight-bold"><?php echo config('title') ?></a>. <?php ee('All Rights Reserved') ?>
        </div>
    </div>
    <div class="bg-dark position-absolute h-100 top-0 right-0 zindex-10 col-lg-6 col-xl-6 d-none d-lg-flex flex-column justify-content-center" data-bg-size="cover" data-bg-position="center">
        <div class="row position-relative zindex-10 p-5">
            <div class="col-md-8 text-center mx-auto">
                <?php if(config("user") && !config("private") && !config("maintenance")): ?>
                    <h5 class="h5 text-white mt-3"><?php ee("Don't have an account?") ?></h5>
                    <p class="text-white opacity-8">
                        <?php ee('Start your marketing campaign now and reach your customers efficiently.') ?>
                    </p>
                    <a href="<?php echo route('register') ?>" class="btn btn-primary btn-sm"><?php ee('Register') ?></a>
                <?php else: ?>
                    <h5 class="h5 text-white mt-3"><?php echo config('title') ?></h5>
                    <p class="text-white opacity-8">
                        <?php ee('Start your marketing campaign now and reach your customers efficiently.') ?>
                    </p>
                <?php endif ?>
            </div>
        </div>        
    </div>    
</section>