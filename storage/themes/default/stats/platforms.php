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
            <div class="col-md-8">
                <div class="card flex-fill w-100">                    
                    <div class="card-header d-flex d-block align-items-center">
                        <div>
                            <h5 class="card-title mb-0 fw-bold"><?php ee('Platforms') ?></h5>
                        </div>
                        <div class="ml-auto">
                            <input type="text" name="customreport" data-action="customreport" class="form-control" placeholder="<?php echo e("Choose a date range to update stats") ?>">
                        </div> 
                    </div>
                    <div class="card-body px-4">
                        <canvas data-trigger="dynamic-pie" data-url="<?php echo route('data.platforms', [$url->id]) ?>" data-type="os"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0 fw-bold"><?php ee('Top Platforms') ?></h5>
                    </div>
                    <div class="card-body px-4">
                        <ul id="top-os" class="list-unstyled d-block"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>