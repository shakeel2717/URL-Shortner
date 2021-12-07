<section class="slice slice-lg pt-7 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">               
                <div class="card mb-n7 position-relative zindex-100">                                       
                    <div class="card-body p-md-5">
                        <div class=" text-center">
                            <h1 class="h2 lh-150 mt-3 mb-0"><?php echo $page->name ?></h1>
                        </div>
                        <div class="row align-items-center mt-5 pt-5 delimiter-top">
                            <div class="col mb-3 mb-lg-0">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="text-sm text-muted"><?php ee('Last Updated') ?> <?php echo $page->lastupdated ?></span>
                                    </div>
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shape-container shape-position-bottom">
        <svg width="2560px" height="100px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none" x="0px" y="0px" viewBox="0 0 2560 100" style="enable-background:new 0 0 2560 100;" xml:space="preserve" class="fill-section-secondary">
            <polygon points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</section>
<section class="slice slice-lg pt-5 pb-5 bg-section-secondary">
    <div class="container pb-6">
        <?php \Helpers\App::ads('resp') ?>
        <div class="row row-grid align-items-center">
            <div class="col-xl-8 col-lg-10 offset-xl-2 offset-lg-1">
                <article>
                    <?php echo $page->content ?>
                </article>
            </div>
        </div>
    </div>
</section>