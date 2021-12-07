<footer class="position-relative" id="footer-main">
    <div class="footer pt-lg-7 footer-dark bg-section-dark">                               
        <div class="container pt-4">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <h3 class="text-secondary mb-2"><?php ee('Marketing with confidence.') ?></h3>
                            <p class="lead mb-0 text-white opacity-8">
                                <?php ee('Start your marketing campaign now and reach your customers efficiently.') ?>
                            </p>
                        </div>
                        <div class="col-lg-5 text-lg-right mt-4 mt-lg-0">
                            <a href="<?php echo route('register') ?>" class="btn btn-primary my-2 ml-0 ml-sm-3">
                                <?php ee('Get Started') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="divider divider-fade divider-dark my-5">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <p class="mt-4 text-sm opacity-8 pr-lg-4"><?php echo config('description') ?></p>
                    <ul class="nav mt-4">
                        <?php if($facebook = config('facebook')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $facebook ?>" target="_blank">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            </li>
                        <?php endif ?>
                        <?php if($twitter = config('twitter')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $twitter ?>" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
                <div class="col-lg-4 col-6 col-sm-6 ml-lg-auto mb-5 mb-lg-0">
                    <h6 class="heading mb-3"><?php ee('Solutions') ?></h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo route('page.qr') ?>"><?php ee('QR Codes') ?></a></li>
                        <li><a href="<?php echo route('page.bio') ?>"><?php ee('Bio Profiles') ?></a></li>
                        <?php foreach(\Helpers\App::pages('main') as $page): ?>
                            <li><a href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="col-lg-4 col-6 col-sm-6 mb-5 mb-lg-0">
                    <h6 class="heading mb-3"><?php ee('Company') ?></h6>
                    <ul class="list-unstyled">
                        <?php foreach(\Helpers\App::pages('company') as $page): ?>
                            <li><a href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a></li>
                        <?php endforeach ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo route('faq') ?>"><?php ee('Help') ?></a></li>
                        <?php if(config('api')): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo route('apidocs') ?>"><?php ee('Developer API') ?></a></li>
                        <?php endif ?>
                        <?php if(config('affiliate')->enabled): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo route('affiliate') ?>"><?php ee('Affiliate Program') ?></a></li>
                        <?php endif ?>
                        <?php if(config('contact')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo route('contact') ?>"><?php ee('Contact Us') ?></a></li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
            <hr class="divider divider-fade divider-dark my-4">
            <div class="row align-items-center justify-content-md-between pb-4">
                <div class="col-md-4">
                    <div class="copyright text-sm font-weight-bold text-center text-md-left">                                
                        &copy; <?php echo date("Y") ?> <a href="<?php echo config('url') ?>" class="font-weight-bold"><?php echo config('title') ?></a>. <?php ee('All Rights Reserved') ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">                                
                        <?php foreach(\Helpers\App::pages('policy') as $page): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a></li>
                        <?php endforeach ?>
                        <?php foreach(\Helpers\App::pages('terms') as $page): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a></li>
                        <?php endforeach ?>                                
                        <li class="nav-item"><a class="nav-link" href="<?php echo route('report') ?>"><?php ee('Report') ?></a></li>
                        <?php if($langs = \Helpers\App::langs()): ?>
                            <li class="nav-item dropup">
                                <a class="nav-link" data-toggle="dropdown" href="#"><i data-feather="globe" class="mr-1"></i> <?php echo strtoupper(\Core\Localization::locale()) ?></a>
                                <ul class="dropdown-menu">
                                    <?php foreach($langs  as $lang): ?>
                                        <li><a class="dropdown-item" href="?lang=<?php echo $lang['code'] ?>"><?php echo $lang['name'] ?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>