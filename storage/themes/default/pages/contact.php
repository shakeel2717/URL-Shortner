<section class="slice slice-lg py-7 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container d-flex align-items-center" data-offset-top="#navbar-main">
        <div class="col py-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 col-lg-7 text-center">
                    <h1 class="display-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> mb-2"><?php ee('Contact Us') ?></h1>
                    <p class="lh-190 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?>"><?php ee('If you have any questions, feel free to contact us so we can help you') ?>.</p>
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
                        <form id="form-contact" method="post" action="<?php echo route('contact.send') ?>" data-trigger="server-form">
                            <div class="form-group">
                                <label class="form-control-label" for="contact-name"><?php ee("Name") ?></label>
                                <input class="form-control form-control-lg" type="text" placeholder="<?php ee("Name") ?>" id="contact-name" name="name" value="<?php echo \Core\Auth::logged() ? \Core\Auth::user()->username : '' ?>" data-error="<?php ee('Please enter a valid name.') ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="contact-email"><?php ee("Email") ?> <span class="text-danger">*</span></label>
                                <input class="form-control form-control-lg" type="email" placeholder="<?php ee("Email") ?>" name="email" id="contact-email" value="<?php echo \Core\Auth::logged() ? \Core\Auth::user()->email : '' ?>" data-error="<?php ee('Please enter a valid email.') ?>" required>
                            </div>                   
                            <div class="form-group">
                                <label class="form-control-label" for="contact-message"><?php ee("Message") ?> <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-lg" placeholder="<?php ee('If you have any questions, feel free to contact us so we can help you') ?>" rows="10" min="10" data-error="<?php ee('The message is empty or too short.') ?>" id="content-message" name="message" required></textarea>
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