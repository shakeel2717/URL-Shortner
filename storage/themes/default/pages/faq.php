<section class="slice slice-lg py-7 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container d-flex align-items-center" data-offset-top="#navbar-main">
        <div class="col py-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 col-lg-7 text-center">
                    <h1 class="display-5 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> mb-2"><?php ee('Frequently Asked Questions') ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="slice slice-lg bg-section-secondary" id="sct-faq">
    <div class="container">
        <div class="row row-grid">
            <div class="col-lg-3">
                <div data-toggle="sticky" data-sticky-offset="50">
                    <div class="card">
                        <div class="list-group list-group-flush">
                            <?php foreach($categories as $id => $category): ?>
                                <a href="#<?php echo $id ?>" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                                    <div>
                                        <span><?php ee($category->title) ?></span>
                                    </div>
                                    <div><i data-feather="chevron-right"></i></div>
                                </a>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 ml-lg-auto">
                <div class="mb-5">
                    <?php foreach($categories as $id => $category): ?>
                        <?php if(isset($faqs[$id])): ?>
                            <h4 class="mb-4" id="<?php echo $id ?>"><?php ee($category->title) ?></h4>
                            <p class="text-muted"><?php ee($category->description) ?></p>
                            <?php foreach($faqs[$id] as $faq): ?>
                                <div id="<?php echo $id.'-'.$faq->slug ?>" class="accordion accordion-spaced">
                                    <div class="card">
                                        <div class="card-header py-4" id="<?php echo $faq->slug ?>" data-toggle="collapse" role="button" data-target="#faq-<?php echo $id ?>-<?php echo $faq->id ?>" aria-expanded="false" aria-controls="faq-<?php echo $id ?>-<?php echo $faq->id ?>">
                                            <h6 class="mb-0"><i data-feather="help-circle" class="mr-3"></i><?php ee($faq->question) ?></h6>
                                        </div>
                                        <div id="faq-<?php echo $id ?>-<?php echo $faq->id ?>" class="collapse" aria-labelledby="<?php echo $faq->slug ?>" data-parent="#<?php echo $id.'-'.$faq->slug ?>">
                                            <div class="card-body">
                                                <?php ee($faq->answer) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                            <div class="text-right py-4">
                                <a href="#<?php echo $id ?>" data-scroll-to data-scroll-to-offset="50" class="text-sm font-weight-bold"><?php ee("Back to top") ?><i data-feather="chevron-up" class="ml-2"></i></a>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>               
            </div>
        </div>
    </div>
</section>
