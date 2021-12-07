<section class="slice slice-lg py-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container d-flex align-items-center" data-offset-top="#navbar-main">
        <div class="row align-items-center py-8">
            <div class="col-md-7">
                <h1 class="display-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> font-weight-bolder mb-4">
                    <?php ee('Bio Profiles') ?>
                </h1>                    
                <p class="lead <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> opacity-8">
                    <?php ee('Convert your followers by creating beautiful pages that group all of your important links on the single page.') ?>
                </p>  
                <p class="my-5">
                    <a href="<?php echo route('register') ?>" class="btn btn-primary"><?php ee('Get Started') ?></a>
                    <a href="<?php echo route('contact') ?>" class="btn btn-secondary"><?php ee('Contact us') ?></a>
                </p>              
            </div>
            <div class="col-md-5 text-center">
                <div class="card bg-gradient-primary border-0 shadow p-5">
                    <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px">&nbsp;</span>
                    <h3 class="text-white"><span><?php echo config('title') ?></span></h3></em>
                    <div id="social" class="text-center mt-2">
                        <a href="<?php echo config('facebook') ?>" class="mx-2 text-white"><i class="fab fa-facebook"></i></a>
                        <a href="<?php echo config('twitter') ?>" class="mx-2 text-white"><i class="fab fa-twitter"></i></a>
                    </div>
                    <div id="content" class="mt-5">
                        <div class="item mb-3">
                            <a href="#" class="btn btn-block btn-white btn-custom">🛒 New Merch</a>
                        </div>
                        <div class="item mb-3">
                            <a href="#" class="btn btn-block btn-white btn-custom">🔥 Shop</a>
                        </div>
                    </div>                     
                </div>               
            </div>
        </div>               
    </div>
</section>
<section class="slice">
    <div class="container">
        <div class="section-process-step">
            <div class="row row-grid justify-content-between align-items-center">
                <div class="col-lg-5 order-lg-2">
                    <h5 class="h3"><?php ee('One link to rule them all') ?>.</h5>
                    <p class="lead my-4">
                        <?php ee('Create beautiful profiles and add content like links, donation, videos and more for your social media users. Share a single on your social media profiles so your users can easily find all of your important links on a single page.') ?>
                    </p>
                    <a href="<?php echo route('register') ?>" class="btn btn-primary btn-sm"><?php ee('Get Started') ?></a>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="card mb-0 mr-lg-5">
                        <div class="card-body p-2">
                            <img src="<?php echo assets('images/profiles.png') ?>" alt="<?php ee('The new standard') ?>" class="img-responsive w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-process-step">
            <div class="row row-grid justify-content-between align-items-center">
                <div class="col-lg-5">
                    <h5 class="h3"><?php ee('Track and optimize') ?>.</h5>
                    <p class="lead my-4">
                        <?php ee('Profiles are fully trackable and you can find out exactly how many people have visited your profiles or clicked links on your profile and where they are from.') ?>
                    </p>
                    <a href="<?php echo route('register') ?>" class="btn btn-primary btn-sm"><?php ee('Get Started') ?></a>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-0 ml-lg-5">
                        <div class="card-body p-2">
                            <img src="<?php echo assets('images/map.png') ?>" alt="<?php ee('Trackable to the dot') ?>" class="img-responsive w-100 py-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>   