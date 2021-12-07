<section class="slice slice-lg pb-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container mb-n7 position-relative zindex-100 pt-5 pt-lg-6">
        <?php echo message() ?>
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-7 col-md-9">
                <h3 class="h1 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?>"><?php ee('Simple Pricing') ?></h3>
                <p class="lead <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> opacity-8 mb-0">
                    <?php ee('Transparent pricing for everyone. Always know what you will pay.') ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="pricing-container">
                    <div class="text-center mb-7">
                        <div class="btn-group" role="group" aria-label="Pricing">
                            <?php if($settings['lifetime']):?>
                            <button type="button" class="btn btn-sm btn-white" data-pricing="lifetime"><?php ee('Lifetime') ?></button>
                            <?php endif ?>
                            <?php if($settings['monthly']):?>
                            <button type="button" class="btn btn-sm btn-white active" data-pricing="monthly"><?php ee('Monthly') ?></button>
                            <?php endif ?>
                            <?php if($settings['yearly']):?>                            
                            <button type="button" class="btn btn-sm btn-white" data-pricing="yearly">
                                <span><?php ee('Yearly') ?></span>
                                <?php if($settings['discount']): ?>
                                    <span class="badge badge-danger border-0 badge-pill badge-floating">-<?php echo $settings['discount'] ?>%</span>
                                <?php endif ?>
                            </button>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="pricing row no-gutters">                                          
                        <?php foreach($plans as $id => $plan): ?>
                            <div class="<?php echo $class ?>">
                                <div class="card bg-section-primary card-pricing text-center mx-1">
                                    <div class="card-header py-5 border-0 delimiter-bottom">
                                        <span class="d-block h5 mb-4"><?php ee($plan['name']) ?></span>
                                        <div class="h1 text-center mb-0" data-pricing-monthly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_monthly"]) ?>" data-pricing-yearly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_yearly"]) ?>" data-pricing-lifetime="<?php echo  $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_lifetime"]) ?>"><span class="price"><?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_monthly"]) ?></span></div>
                                        <?php echo $plan['description'] ? '<span class="d-block text-muted mt-3">'.$plan['description'].'</span>': '' ?>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-4 text-left text-sm">
											<li><span data-feather="check-circle" class="mr-1 text-success"></span> <?php echo $plan["urls"] == "0" ? e("Unlimited") : $plan["urls"] ?> <?php echo e("URLs allowed") ?></li>
											<li><span data-feather="check-circle" class="mr-1 text-success"></span> <?php echo $plan["clicks"] == "0" ? e("Unlimited") : $plan["clicks"] ?> <?php echo e("Clicks per month") ?></li>											
                                            <li><?php echo $plan["permission"]->alias->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="mr-1 text-danger"></span>' ?>  <?php echo e("Custom Aliases") ?></li>
											<li class="<?php echo $plan["permission"]->geo->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->geo->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?> <?php echo e("Geotargeting"); ?></li>
											<li class="<?php echo $plan["permission"]->device->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->device->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?> <?php echo e("Device Targeting"); ?></li>     
                                            <li class="<?php echo $plan["permission"]->bio->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->bio->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->bio->count == "0" ? e("Unlimited") : $plan["permission"]->bio->count)." ".e("Bio Profiles"); ?></li>
                                            <li class="<?php echo $plan["permission"]->qr->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->qr->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->qr->count == "0" ? e("Unlimited") : $plan["permission"]->qr->count)." ".e("QR Codes"); ?></li>
											<li class="<?php echo $plan["permission"]->splash->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->splash->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->splash->count == "0" ? e("Unlimited") : $plan["permission"]->splash->count)." ".e("Custom Splash"); ?></li>
											<li class="<?php echo $plan["permission"]->overlay->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->overlay->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->overlay->count == "0" ? e("Unlimited") : $plan["permission"]->overlay->count)." ".e("CTA Overlay"); ?></li>
											<li class="<?php echo $plan["permission"]->pixels->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->pixels->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->pixels->count == "0" ? e("Unlimited") : $plan["permission"]->pixels->count)." ".e("Event Tracking"); ?></li>
											<li class="<?php echo $plan["permission"]->team->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->team->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->team->count == "0" ? e("Unlimited") : $plan["permission"]->team->count)." ".e("Team Members"); ?></li>
											<li class="<?php echo $plan["permission"]->domain->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->domain->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->domain->count == "0" ? e("Unlimited") : $plan["permission"]->domain->count)." ".e("Branded Domains"); ?></li>
											<li class="<?php echo $plan["permission"]->bundle->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->bundle->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo e("Campaigns & Link Rotator") ?></li>        
											<li class="<?php echo $plan["permission"]->multiple->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->multiple->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo e("Multiple Domains") ?></li>        
											<li class="<?php echo $plan["permission"]->parameters->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->parameters->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo e("Custom Parameters") ?></li>
											<li><?php echo $plan["permission"]->export->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span> ' : '<span data-feather="x-circle" class="text-danger mr-1"></span> ' ?>  <?php echo e("Export Data") ?></li>        
											<li><?php echo $plan["permission"]->api->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo e("Developer API"); ?></li>											              
											<li><?php echo $plan["free"]  ? '<span data-feather="x-circle" class="text-danger mr-1"></span>' : '<span data-feather="check-circle" class="mr-1 text-success"></span>' ?> <?php echo e("URL Customization") ?></li>                
											<li><?php echo $plan["free"]  ? '<span data-feather="x-circle" class="mr-1 text-danger"></span>' : '<span data-feather="check-circle" class="text-success mr-1"></span>' ?> <?php echo e("Advertisement-Free") ?></li> 
                                            <?php echo $plan["permission"]->custom  ? '<li><span data-feather="check-circle" class="text-success mr-1"></span> '.$plan["permission"]->custom.'</li>' : '' ?>
                                        </ul>
                                        <a href="<?php echo $plan['planurl'] ?>" class="btn btn-primary mb-3 shadow checkout"><?php echo $plan['plantext'] ?></a>
                                    </div>
                                </div>
                            </div> 
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="shape-container shape-line shape-position-bottom">
        <svg width="2560px" height="100px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none" x="0px" y="0px" viewBox="0 0 2560 100" style="enable-background:new 0 0 2560 100;" xml:space="preserve" class="fill-section-secondary">
            <polygon points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</section>
<section class="slice slice-lg pt-8 bg-section-secondary">
    <div class="container">            
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-8 col-md-10">
                <h2 class="mt-4"><?php ee('Frequently Asked Questions') ?></h2>
            </div>
        </div>
        <div class="row">
            <?php foreach(\Helpers\App::pricingFaqs() as $i => $faq): ?>
                <?php if($i > 0 && $i % 2 == 0): ?>
                    </div>
                    <div class="row">
                <?php endif; ?>                
                <div class="col-xl-6">
                    <div id="<?php echo 'faq-holder-'.$faq->slug ?>" class="accordion accordion-spaced">
                        <div class="card">
                            <div class="card-header py-4" id="<?php echo $faq->slug ?>" data-toggle="collapse" role="button" data-target="#faq-<?php echo $faq->id ?>" aria-expanded="false" aria-controls="faq-<?php echo $faq->id ?>">
                                <h6 class="mb-0"><i data-feather="help-circle" class="mr-3"></i><?php ee($faq->question) ?></h6>
                            </div>
                            <div id="faq-<?php echo $faq->id ?>" class="collapse" aria-labelledby="<?php echo $faq->slug ?>" data-parent="#<?php echo 'faq-holder-'.$faq->slug ?>">
                                <div class="card-body">
                                    <?php ee($faq->answer) ?>
                                </div>
                            </div>
                        </div>
                    </div>         
                </div>                  
            <?php endforeach ?> 
        </div>
    </div>
</section>