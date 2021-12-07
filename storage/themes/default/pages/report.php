<section class="slice slice-lg py-7 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container d-flex align-items-center" data-offset-top="#navbar-main">
        <div class="col py-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 col-lg-7 text-center">
                    <h1 class="display-4  <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> mb-2"><?php ee('Report link') ?></h1>
                    <p class="lh-190  <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?>"><?php ee('Please report a link that you consider risky or dangerous. We will review all cases and take measure to remove the link.') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="slice slice-lg bg-section-secondary" id="sct-form-contact">
    <div class="container position-relative zindex-100">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form id="form-contact" method="post" action="<?php echo route('report.send') ?>" data-trigger="server-form">
                            <div class="form-group">
                                <label class="form-control-label" for="contact-email"><?php ee("Email") ?> <span class="text-danger">*</span></label>
                                <input class="form-control form-control-lg" type="email" placeholder="<?php ee("Email") ?>" name="email" id="contact-email" value="<?php echo \Core\Auth::logged() ? \Core\Auth::user()->email : '' ?>" data-error="<?php ee('Please enter a valid email.') ?>" required>
                            </div>   
                            <div class="form-group">
                                <label class="form-control-label" for="contact-link"><?php ee("Short Link") ?> <span class="text-danger">*</span></label>
                                <input class="form-control form-control-lg" type="text" placeholder="<?php ee("Please enter a valid short link") ?>" id="contact-link" name="link" value="" data-error="<?php ee('Please enter a valid link.') ?>" required>
                            </div>                
                            <div class="form-group">
                                <label class="form-control-label" for="contact-reason"><?php ee("Reason") ?> <span class="text-danger">*</span></label>
                                <select name="reason" id="contact-reason" class="form-control">
                                    <option value="spam"><?php echo e("Spam") ?></option>
                                    <option value="fraudulent"><?php echo e("Fraudulent") ?></option>
                                    <option value="malicious"><?php echo e("Malicious") ?></option>
                                    <option value="phishing"><?php echo e("Phishing") ?></option>
                                </select>
                            </div>
                            <?php echo \Helpers\Captcha::display() ?>
                            <div class="text-center">
                                <?php echo csrf() ?>
                                <button type="submit" class="btn btn-block btn-lg btn-primary mt-4"><?php ee('Send') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>