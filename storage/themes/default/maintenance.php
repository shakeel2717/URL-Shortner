<section>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-between min-vh-100">
            <div class="col-12 col-md-6 col-xl-6 order-md-2">
                <img alt="BRB" src="<?php echo assets('images/maintenance.svg') ?>" class="img-fluid">
            </div>
            <div class="col-12 col-md-6 col-xl-6 order-md-1 text-center text-md-left">
                <h6 class="display-1 mb-3 font-weight-600 text-warning"><?php ee('BRB') ?></h6>
                <p class="lead text-lg mb-5">
                    <?php ee('We are currently offline for maintenance. We will be back online as soon as we are done. It should not take long.') ?>
                </p>
                <?php if($facebook = config('facebook')): ?>
                    <a href="<?php echo $facebook ?>" class="bg-secondary text-dark rounded-circle p-3 text-center mr-5" target="_blank">
                        <i data-feather="facebook"></i>
                    </a>
                <?php endif ?>
                <?php if($twitter = config('twitter')): ?>
                    <a href="<?php echo $twitter ?>" class="bg-secondary text-dark rounded-circle p-3 text-center mr-5" target="_blank">
                        <i data-feather="twitter"></i>
                    </a>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>