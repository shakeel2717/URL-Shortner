<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Statistics') ?></h1>
    </div>
    <?php if(\Core\Auth::user()->has('export')): ?>        
        <div class="ms-auto">
            <a data-bs-toggle="modal" data-bs-target="#exportModal" href="#" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Export Stats') ?></a>
        </div>
    <?php endif ?>
</div>
<section id="dynamic-charts">
    <div class="card flex-fill w-100">
        <div class="card-header">
            <h5 class="card-title mb-0 fw-bold"><?php ee('Links') ?></h5>
        </div>
        <div class="card-body py-3">
            <div class="chart chart-sm">
                <canvas data-trigger="dynamic-chart" data-url="<?php echo route('user.stats.links') ?>" data-color-start="#3B7DDD" data-color-stop="rgba(255,255,255,0.1)"></canvas>
            </div>
        </div>
    </div>
    <div class="card flex-fill w-100">
        <div class="card-header">
            <h5 class="card-title mb-0 fw-bold"><?php ee('Clicks') ?></h5>
        </div>
        <div class="card-body py-3">
            <div class="chart chart-sm">
                <canvas data-trigger="dynamic-chart" data-url="<?php echo route('user.stats.clicks') ?>" data-color-start="#dc3545" data-color-stop="rgba(255,255,255,0.1)"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-xxl-6 d-flex order-3 order-xxl-2">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Visitor Map') ?></h5>
                </div>
                <div class="card-body px-4">
                    <div id="visitor-map" data-trigger="dynamic-map"  data-url="<?php echo route('user.stats.map') ?>" style="height:350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xxl-6 d-flex order-3 order-xxl-2">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Top Countries') ?></h5>
                </div>
                <div class="card-body px-4">
                    <ul id="top-countries" class="list-unstyled d-block"></ul>
                </div>
            </div>
        </div>
    </div>    
</section>
<?php if(\Core\Auth::user()->has('export')): ?>
<div class="modal fade" id="exportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="<?php echo route('user.stats.export') ?>" method="post">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Export Data') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <p><?php ee("Choose a range to export data as CSV. Exported data will including information like date, city and country, os, browser, referer and language.") ?></p>
                <input type="text" class="form-control mt-3" name="customreport">        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success" data-bs-dismiss="modal"><?php ee('Export') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php endif ?>