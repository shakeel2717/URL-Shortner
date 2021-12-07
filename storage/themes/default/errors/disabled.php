<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php meta() ?>    
        <link rel="stylesheet" href="<?php echo assets('frontend/css/style.css') ?>" id="stylesheet">
    </head>

    <body>
        <a href="<?php echo route('home') ?>" class="btn btn-neutral btn-icon-only rounded-circle position-absolute left-4 top-4 d-none d-lg-inline-flex" title="Go back">
            <span class="btn-inner--icon">
                <i data-feather="arrow-left"></i>
            </span>
        </a>
        <section>
            <div class="container d-flex flex-column">
                <div class="row align-items-center justify-content-between min-vh-100">
                    <div class="col-12 col-md-6 col-xl-6 order-md-2">
                        <img alt="Stop" src="<?php echo assets('images/stop.svg') ?>" class="img-fluid">
                    </div>
                    <div class="col-12 col-md-6 col-xl-6 order-md-1 text-center text-md-left">
                        <h6 class="display-1 mb-3 font-weight-600 text-danger"><?php ee('Stop') ?></h6>
                        <p class="lead text-lg mb-5">
                            <?php ee('There is a problem with this link and we have blocked it either because it is potentially malicious or contains inappropriate content that is against our terms of service. We actively monitor all links on our platform to ensure the safety of all our users. If you have any questions, feel free to contact us.') ?>
                        </p>
                        <a href="<?php echo route('home') ?>" class="btn btn-dark btn-icon hover-translate-y-n3">
                            <span class="btn-inner--icon"><i data-feather="home"></i></span>
                            <span class="btn-inner--text"><?php ee('Back to home') ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <script src="<?php echo assets('frontend/libs/jquery/dist/jquery.min.js') ?>"></script>
        <script src="<?php echo assets('frontend/libs/svg-injector/dist/svg-injector.min.js') ?>"></script>
        <script src="<?php echo assets('frontend/libs/feather-icons/dist/feather.min.js') ?>"></script>
        <script>
            feather.replace({
                'width': '1em',
                'height': '1em'
            })
        </script>
    </body>
</html>