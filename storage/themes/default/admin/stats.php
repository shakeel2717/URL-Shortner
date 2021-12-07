<h1 class="h3 mb-5"><?php ee('Statistics') ?></h1>

<section id="dynamic-charts">
    <div class="card flex-fill w-100">
        <div class="card-header">
            <h5 class="card-title mb-0 fw-bold"><?php ee('Links') ?></h5>
        </div>
        <div class="card-body py-3">
            <div class="chart chart-sm">
                <canvas data-trigger="dynamic-chart" data-url="<?php echo route('admin.stats.links') ?>" data-color-start="#3B7DDD" data-color-stop="rgba(255,255,255,0.1)"></canvas>
            </div>
        </div>
    </div>
    <div class="card flex-fill w-100">
        <div class="card-header">
            <h5 class="card-title mb-0 fw-bold"><?php ee('Clicks') ?></h5>
        </div>
        <div class="card-body py-3">
            <div class="chart chart-sm">
                <canvas data-trigger="dynamic-chart" data-url="<?php echo route('admin.stats.clicks') ?>" data-color-start="#dc3545" data-color-stop="rgba(255,255,255,0.1)"></canvas>
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
                    <div id="visitor-map" data-trigger="dynamic-map"  data-url="<?php echo route('admin.stats.map') ?>" style="height:350px;"></div>
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
    <div class="row">
        <div class="col-md-8">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Users') ?></h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas data-trigger="dynamic-chart" data-url="<?php echo route('admin.stats.users') ?>" data-color-start="#28a745" data-color-stop="rgba(255,255,255,0.1)"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Memberships') ?></h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas data-trigger="dynamic-pie" data-url="<?php echo route('admin.stats.membership') ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>