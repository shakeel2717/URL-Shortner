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
                                <h6 class="h3 mb-2"><?php ee('Reset Password') ?></h6>
                                <p class="text-muted mb-0"><?php ee("If you forgot your password, you can request a link to reset your password.") ?></p>
                            </div>
                            <span class="clearfix"></span>
                            <?php message() ?>
                            <form method="post" action="<?php echo route('forgot.send') ?>">
                                <?php echo csrf() ?>
                                <div class="form-group">
                                    <label class="form-control-label"><?php ee('Email') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="email" class="form-control form-control-prepend" id="input-access" name="email" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i data-feather="at-sign"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <?php echo \Helpers\Captcha::display() ?>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-block btn-primary"><?php ee('Reset Password') ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>