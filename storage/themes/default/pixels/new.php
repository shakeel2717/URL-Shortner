<h1 class="h3 mb-5"><?php ee('Add Pixel') ?></h1>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('pixel.save') ?>" enctype="multipart/form-data" data-trigger="codeeditor">
                    <?php echo csrf() ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="type" class="form-label"><?php echo e("Pixel Provider") ?></label>
                                <select name="type" id="type" class="form-control" data-toggle="select">
                                    <option value="gtm">Google Tag Manager</option>
                                    <option value="ga">Google Analytics</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="adwords">Google Ads</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="twitter">Twitter</option>
                                    <option value="adroll">AdRoll</option>
                                    <option value="quora">Quora</option>
                                    <option value="pinterest">Pinterest</option>
                                </select>
                            </div>	
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="pixel" class="form-label"><?php ee('Pixel Name') ?></label>
                                <input type="text" class="form-control p-2" name="pixel" id="pixel" value="" placeholder="<?php echo e("Shopify Campaign") ?>">
                            </div>	
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="tag" class="form-label"><?php echo e("Pixel Tag") ?></label>
                                <input type="text" value="" name="tag" class="form-control p-2" placeholder="e.g. <?php echo e("Numerical or alphanumerical values only") ?>" /> 
                            </div>	
                        </div>                
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Pixel') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3"><?php ee('Pixels') ?></h5>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $total == 0 ? 100 : round($count*100/$total) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $count ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></div>
                </div>            
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('What are tracking pixels?') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('Ad platforms such as Facebook and Adwords provide a conversion tracking tool to allow you to gather data on your customers and how they behave on your website. By adding your pixel ID from either of the platforms, you will be able to optimize marketing simply by using short URLs.') ?></p>
                <a href="<?php echo route('faq') ?>#pixels" class="btn btn-primary btn-sm"><?php ee("More info") ?></a>             
            </div>
        </div>
    </div>
</div>