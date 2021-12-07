<section>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-between min-vh-100">
            <div class="col-12 col-md-6 col-xl-6 order-md-2">
                <img alt="Great!" src="<?php echo assets('images/maintenance.svg') ?>" class="img-fluid">
            </div>
            <div class="col-12 col-md-6 col-xl-6 order-md-1 text-center text-md-left">
                <h6 class="display-4 mb-3 font-weight-600 text-success"><?php ee('Custom domain working') ?></h6>
                <p class="description"><?php echo e("Your <strong>domain name</strong> is now successfully pointed to our server. You can now start using it from the platform and shorten branded links with your own domain name.") ?></p>
                <p class="description"><?php echo e("If you want to display another page instead of this page when someone accesses your root domain name, you can define that link in your settings by logging in to your account. You can also define a custom 404 error page.") ?></p>
                <p class="description"><?php echo e("If you have any questions, please do not hesitate to contact us.") ?></p>
                <br>
                <p>
                    <a href="<?php echo route("dashboard") ?>" class="btn btn-secondary btn-round"><?php echo e("Login to your account") ?></a>
                    &nbsp;&nbsp;
                    <a href="<?php echo route("contact") ?>" class="btn btn-primary btn-round"><?php echo e("Contact us") ?></a>            
                </p>
            </div>
        </div>
    </div>
</section>