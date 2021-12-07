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
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card flex-fill w-100">
                    <div class="card-header d-flex d-block align-items-center">
                        <div>
                            <h5 class="card-title mb-0 fw-bold"><?php ee('Clicks') ?></h5>
                        </div>
                        <div class="ml-auto">
                            <input type="text" name="customreport" data-action="customreport" class="form-control" placeholder="<?php echo e("Choose a date range to update stats") ?>">
                        </div> 
                    </div>
                    <div class="card-body py-3">
                        <div>
                            <canvas data-trigger="chart" data-url="<?php echo route('data.clicks', [$url->id]) ?>" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><?php ee('Recent Activity') ?></h5>
                    </div>
                    <div class="card-body no-checkbox">
                        <?php foreach($recentActivity as $stats): ?>
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">                                    
                                    <?php if($stats->country): ?>
                                        <img src="<?php echo \Helpers\App::flag($stats->country) ?>" width="16" class="rounded mr-1" alt=" <?php echo ucfirst($stats->country) ?>">
                                        <small class="mr-2"><?php echo $stats->city ? ucfirst($stats->city).',': e('Somewhere from') ?> <?php echo ucfirst($stats->country) ?></small>
                                    <?php endif ?>
                                    <?php if($stats->os): ?>
                                        <img src="<?php echo \Helpers\App::os($stats->os) ?>" width="16" class="rounded mr-1" alt=" <?php echo ucfirst($stats->os) ?>">
                                        <small class="mr-2 text-navy"><?php echo $stats->os ?></small> 
                                    <?php endif ?>
                                    <?php if($stats->browser): ?>
                                        <img src="<?php echo \Helpers\App::browser($stats->browser) ?>" width="16" class="rounded mr-1" alt=" <?php echo ucfirst($stats->browser) ?>">
                                        <small class="mr-2 text-navy"><?php echo $stats->browser ?></small>
                                    <?php endif ?>
                                    <?php if($stats->domain): ?>
                                        <i data-feather="globe" class="mr-1"></i>
                                        <a href="<?php echo $stats->referer ?>" rel="nofollow" target="_blank"><small class="mr-2 text-navy"><?php echo $stats->domain ?></small></a>
                                    <?php else: ?>
                                        <i data-feather="globe" class="mr-1"></i>
                                        <small class="mr-2 text-navy"><?php echo ee('Direct, email or others') ?></small>
                                    <?php endif ?>
                                    <?php if($stats->language): ?>
                                        <i data-feather="user" class="mr-1"></i>
                                        <small class="mr-2 text-navy"><?php echo strtoupper($stats->language) ?></small>
                                    <?php endif ?>    
                                    <br>
                                    <small class="mr-1"><?php echo \Core\Helper::timeago($stats->date) ?></small>
                                </div>
                            </div>          
                            <hr class="my-2"> 
                        <?php endforeach ?>            
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>