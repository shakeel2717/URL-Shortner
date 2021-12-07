<section class="slice slice-lg pb-1 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container mb-n7 position-relative zindex-100 pt-lg-6">  </div>       
</section>
<section class="bg-section-secondary pt-4">
    <div class="container">
        <?php echo message() ?>      
        <form action="<?php echo route('checkout.process', [$plan->id, $type]) ?>" method="post" id="payment-form">
            <?php echo csrf() ?>
            <div class="row">            
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title"><?php ee('Payment Method') ?></h6>
                            <div class="btn-group btn-group-toggle mb-4" data-toggle="buttons">
                                <?php $i = 0; foreach($processors as $name => $processor): ?>
                                    <?php if(!config($name) || !config($name)->enabled) continue ?>
                                    <label class="btn btn-outline-light text-dark border <?php echo ($i == 0 ? 'active':'') ?>">
                                        <input type="radio" name="payment" value="<?php echo $name ?>" autocomplete="off" <?php echo ($i == 0 ? 'checked':'') ?>> <?php echo $processor['name'] ?>
                                    </label>
                                <?php $i++; endforeach ?>
                            </div>
                            <?php foreach($processors as $name => $processor): ?>
                                <?php if(!config($name) || !config($name)->enabled) continue ?>
                                <?php if($processor['checkout']): ?>
                                    <?php call_user_func($processor['checkout']) ?>
                                <?php endif ?>
                            <?php endforeach ?>
                            <h6 class="card-title mt-5"><?php ee('Billing Address') ?></h6>
                            <div class="form-group">
                                <label for="name"><?php echo e("Full Name") ?></label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user->name ?>" required>
                            </div>							
                            <div class="form-group">
                                <label for="address"><?php echo e("Address") ?></label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo (isset($user->address->address) ? $user->address->address : "" ) ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city"><?php echo e("City") ?></label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="e.g. New York" value="<?php echo (isset($user->address->city) ? $user->address->city : "" ) ?>" required>
                                    </div>									
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state"><?php echo e("State/Province") ?></label>
                                        <input type="text" class="form-control" id="state" name="state" placeholder="e.g. NY" value="<?php echo (isset($user->address->state) ? $user->address->state : "" ) ?>" required>
                                    </div>										
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country"><?php echo e("Country") ?></label>
                                        <select name="country" id="country" class="form-control" data-toggle="select" required>
                                            <?php echo \Core\Helper::Country($user->address->country ?? request()->country(), true, true) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="zip"><?php echo e("Zip/Postal code") ?></label>
                                        <input type="text" class="form-control" id="zip" name="zip" placeholder="e.g. 44205" value="<?php echo (isset($user->address->zip) ? $user->address->zip : "" ) ?>" required>
                                    </div>										
                                </div>                                  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-section-dark border-0 rounded-lg">
                        <div class="card-header">
                            <h6 class="card-title text-white"><?php ee('Summary') ?></h6>
                        </div>
                        <div class="card-body text-white">
                            <div class="row">
                                <div class="col">
                                    <strong><?php echo $plan->name ?></strong>                                    
                                </div>
                                <div class="col-auto">
                                    <?php echo \Helpers\App::currency(config('currency'), $plan->price) ?>
                                </div>
                            </div>
                            <hr class="opacity-2">
                            <div class="row">
                                <div class="col">
                                    <strong><?php ee('Subtotal') ?></strong>
                                </div>
                                <div class="col-auto" id="subtotal">
                                    <?php echo \Helpers\App::currency(config('currency'), $plan->price) ?>
                                </div>
                            </div>
                            <div class="form-group mt-4 collapse" id="promocode">
                                <label for="coupon"><?php echo e("Promo Code") ?></label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" data-url="<?php echo route('checkout.coupon', [$plan->id, $type]) ?>" class="form-control form-control-sm" id="coupon" name="coupon" placeholder="">
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" data-trigger="applycoupon" class="btn btn-sm btn-primary"><?php ee('Apply') ?></button>
                                    </div>
                                </div>
                            </div>
                            <a href="#promocode" data-toggle="collapse"><?php ee('Apply promo code') ?></a>
                            <div class="form-group mt-4 collapse">
                                <div class="row">
                                    <div class="col">
                                        <?php ee('Discount') ?>
                                    </div>
                                    <div class="col-auto" id="discount"></div>
                                </div>
                            </div>
                            <hr class="opacity-2">
                            <div class="row">
                                <div class="col">
                                    <strong><?php ee('Total') ?></strong>                                    
                                </div>
                                <div class="col-auto text-right" id="total">
                                    <?php echo \Helpers\App::currency(config('currency'), $plan->price) ?>
                                    <p class="text-sm"><?php echo $type == 'lifetime' ? e('One-time payment') : e('Billed').' '.e($type) ?></p>
                                </div>
                            </div>    
                            <div class="d-flex mt-5">
                                <div class="ml-auto">
                                    <button type="submit" class="btn btn-primary btn-sm"><?php ee('Checkout') ?></button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="card rounded card-body">
                        <?php ee('By subscribing to this plan, you agree to our Terms & Conditions. Subscription is charged in {c}. If you have any questions, please contact us.', null, ['c' => config('currency')]) ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>