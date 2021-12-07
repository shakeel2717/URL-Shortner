<a href="<?php echo route('home') ?>" class="btn btn-white btn-icon-only rounded-circle position-absolute zindex-101 left-4 top-4 d-none d-lg-inline-flex" data-toggle="tooltip" data-placement="right" title="Go back">
    <span class="btn-inner--icon">
        <i data-feather="arrow-left"></i>
    </span>
</a>
<section class="section-half-rounded bg-dark py-4 py-sm-0">
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5 col-xl-4 mx-auto">
                <div class="card shadow-lg border-0 mb-0">
                    <div class="card-body py-5 px-sm-5">
                        <div>
                            <div class="mb-5 text-center">
                                <h6 class="h3 mb-2"><?php ee('Join Team') ?></h6>
                                <p><?php ee("Join team and manage collaborate on everything") ?></p>
                            </div>
                            <span class="clearfix"></span>
                            <?php message() ?>
                            <form method="post" action="<?php echo route('acceptinvitation', [$token]) ?>">
                                <?php echo csrf() ?>
                                <div class="form-group">
                                    <label class="form-control-label"><?php ee('Email') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepend" disabled value="<?php echo $user->email ?>">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-secondary"><i data-feather="send"></i></span>
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="form-control-label"><?php ee('Username') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepend" id="input-access" name="username" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i data-feather="user"></i></span>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="form-control-label"><?php ee('Password') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control form-control-prepend" id="input-access" name="password" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i data-feather="key"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"><?php ee('Confirm Password') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control form-control-prepend" id="input-caccess" name="cpassword" required>
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
                                    <button type="submit" class="btn btn-block btn-primary"><?php ee('Accept') ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>