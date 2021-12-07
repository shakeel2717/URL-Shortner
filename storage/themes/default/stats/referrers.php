<?php view('stats.partial', ['url' => $url, 'top' => $top]) ?>
<section class="pt-7 bg-section-secondary">
    <div class="container">
        <div class="card card-body">
            <div class="row align-items-center">
                <div class="col">
                    <?php view('partials.stats_nav', ['url' => $url]) ?>
                </div>
            </div>
        </div>
        <div class="row">            
            <div class="col-md-6">
                <div class="card flex-fill w-100">
                    <div class="card-header d-flex d-block align-items-center">
                        <div>
                            <h5 class="card-title mb-0 fw-bold"><?php ee('Top Referrers') ?></h5>
                        </div>
                    </div>
                    <div class="card-body px-4">
                        <ul id="top-referrers" class="list-unstyled d-block">
                            <?php foreach($topReferrer as $referrer): ?>
                                <li class="d-block mb-2 w-100 border-bottom pb-2 fw-bold"><img src="<?php echo !empty($referrer['domain']) ? "https://icons.duckduckgo.com/ip3/".\Core\Helper::parseUrl($referrer['domain'], 'host').".ico" : assets('images/unknown.svg') ?>" width="16" class="mr-2"><?php echo empty($referrer['domain']) ? e('Direct, email and others') : $referrer['domain'] ?> <small class="badge bg-primary text-white float-right"><?php echo $referrer['count'] ?></small></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0 fw-bold"><?php ee('Social Media') ?></h5>
                    </div>
                    <div class="card-body px-4">
                        <canvas></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>