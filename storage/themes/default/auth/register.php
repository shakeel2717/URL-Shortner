<a href="<?php echo route('home') ?>" class="btn btn-white btn-icon-only rounded-circle position-absolute zindex-101 left-4 top-4 d-none d-lg-inline-flex" data-toggle="tooltip" data-placement="right" title="Go back">
    <span class="btn-inner--icon">
        <i data-feather="arrow-left"></i>
    </span>
</a>
<section>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-md-8 col-lg-5 py-6">
                <div>
                    <div class="mb-5 text-center">
                        <h6 class="h3 mb-1"><?php ee("Create your account") ?></h6>
                        <p class="text-muted mb-0"><?php ee('Start your marketing campaign now and reach your customers efficiently.') ?></p>
                    </div>
                    <span class="clearfix"></span>
                    <?php message() ?>
                    <form method="post" action="<?php echo route('register.validate')?>">
                        <div class="form-group">
                            <label class="form-control-label" for="user-name"><?php ee('Username') ?></label>
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepend" id="user-name" name="username" placeholder="<?php ee('Please enter a username') ?>" value="<?php echo old('username') ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="user"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="user-email"><?php ee('Email address') ?></label>
                            <div class="input-group input-group-merge">
                                <input type="email" class="form-control form-control-prepend" id="user-email" name="email" placeholder="<?php ee('Please enter a valid email.') ?>" value="<?php echo old('email') ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="at-sign"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label" for="user-pass"><?php ee('Password') ?></label>
                                </div>                                
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control form-control-prepend" id="user-pass" name="password" placeholder="<?php ee('Please enter a valid password.') ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="key"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label" for="confirm-pass"><?php ee('Confirm Password') ?></label>
                                </div>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control form-control-prepend" id="confirm-pass" name="cpassword" placeholder="<?php ee('Please confirm your password.') ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="key"></i></span>
                                </div>
                            </div>
                        </div>
                        <?php if($page): ?>
                            <div class="my-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="check-terms" name="terms" value="1">
                                    <label class="custom-control-label" for="check-terms"><?php ee('I agree to the') ?> <a href="<?php echo route('page', $page->seo) ?>" target="_blank"><?php echo $page->name ?></a>.</label>
                                </div>
                            </div>              
                        <?php else: ?>
                            <div class="my-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="check-terms" name="terms" value="1">
                                    <label class="custom-control-label" for="check-terms"><?php ee('I agree to the terms and conditions') ?>.</label>
                                </div>
                            </div>                
                        <?php endif ?>
                        <div class="mt-4">
                            <?php echo \Helpers\Captcha::display() ?>
                            <?php echo csrf() ?>
                            <button type="submit" class="btn btn-block btn-primary"><?php ee('Register') ?></button>
                        </div>
                    </form>
                    <div class="mt-4 text-center"><small><?php ee('Already have an account?') ?></small>
                        <a href="<?php echo route('login') ?>" class="small font-weight-bold"><?php ee('Login') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>