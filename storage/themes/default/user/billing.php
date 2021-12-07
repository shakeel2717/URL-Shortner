<h1 class="h3 mb-5"><?php ee('Billing') ?></h1>
<div class="row">
    <div class="col-md-8">
        <?php if($subscriptions): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php ee('Subscription History') ?></h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee("Transaction ID") ?></th>
                            <th><?php ee("Amount") ?></th>
                            <th><?php ee("Since") ?></th>
                            <th><?php ee("Next Payment") ?></th>
                            <th><?php ee("Status") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($subscriptions as $subscription): ?>
                            <tr>                                
                                <td><?php echo $subscription->uniqueid ?></td>
                                <td><?php echo \Helpers\App::currency(config("currency"), $subscription->amount) ?></td>
                                <td><?php echo date("d F, Y",strtotime($subscription->date)) ?></td>
                                <td><?php echo date("d F, Y",strtotime($subscription->expiry)) ?></td>
                                <td><?php echo ($subscription->status == "Completed" ? e("Active") : $subscription->status) ?></td>                               
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>   
            </div>
        </div>
        <?php endif ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php ee('Payment History') ?></h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee("Transaction ID") ?></th>
                            <th><?php ee("Amount") ?></th>
                            <th><?php ee("Date") ?></th>
                            <th><?php ee("Expiration") ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($payments as $payment): ?>
                            <tr>                                
                                <td><?php echo ($payment->status == "Refunded" ? "<span class='badge bg-danger'>".e("Refunded")."</span> ":"").$payment->tid ?></td>
                                <td><?php echo ($payment->status == "Refunded" ? "-" :"").($payment->trial_days ? e('Free Trial') : \Helpers\App::currency(config("currency"), $payment->amount)) ?></td>
                                <td><?php echo date("d F, Y",strtotime($payment->date)) ?></td>
                                <td><?php echo ($payment->status == "Refunded" ? '' : date("d F, Y",strtotime($payment->expiry))) ?></td>
                                <td><a href="<?php echo route('invoice', [$payment->tid]) ?>" class="btn btn-sm btn-primary"><?php ee('View Invoice') ?></a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>   
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p><?php echo $user->pro() && $user->expiration ? e('Expiration').': '.\Core\Helper::dtime($user->expiration, 'd-m-Y') : '' ?>
                <hr>
                <h5 class="mb-3"><?php ee('Current Plan') ?>: <?php echo $plan['name'] ?></h5>
                <ul class="list-unstyled mb-4 text-left text-sm">
                    <li class="mb-1"><?php echo $plan["permission"]->alias->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger"></span>' ?>  <?php echo e("Custom Aliases") ?></li>        		
                    <li class="mb-1"><span data-feather="check-circle" class="mr-1 text-success"></span> <?php echo $plan["urls"] == "0" ? e("Unlimited") : $plan["urls"] ?> <?php echo e("URLs allowed") ?></li>
                    <li class="mb-1"><span data-feather="check-circle" class="mr-1 text-success"></span> <?php echo $plan["clicks"] == "0" ? e("Unlimited") : $plan["clicks"] ?> <?php echo e("Clicks per month") ?></li>											
                    <li class="mb-1 <?php echo $plan["permission"]->geo->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->geo->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?> <?php echo e("Geotargeting"); ?></li>
                    <li class="mb-1 <?php echo $plan["permission"]->device->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->device->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?> <?php echo e("Device Targeting"); ?></li>     
                    <li class="mb-1 <?php echo $plan["permission"]->bio->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->bio->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->bio->count == "0" ? e("Unlimited") : $plan["permission"]->bio->count)." ".e("Bio Profiles"); ?></li>
                    <li class="mb-1 <?php echo $plan["permission"]->qr->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->qr->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->qr->count == "0" ? e("Unlimited") : $plan["permission"]->qr->count)." ".e("QR Codes"); ?></li>
                    <li class="mb-1 <?php echo $plan["permission"]->qr->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->qr->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->splash->count == "0" ? e("Unlimited") : $plan["permission"]->splash->count)." ".e("Custom Splash"); ?></li>
                    <li class="mb-1 <?php echo $plan["permission"]->overlay->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->overlay->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->overlay->count == "0" ? e("Unlimited") : $plan["permission"]->overlay->count)." ".e("CTA Overlay"); ?></li>
                    <li class="mb-1 <?php echo $plan["permission"]->pixels->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->pixels->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->pixels->count == "0" ? e("Unlimited") : $plan["permission"]->pixels->count)." ".e("Event Tracking"); ?></li>
                    <li class="mb-1 <?php echo $plan["permission"]->team->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->team->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->team->count == "0" ? e("Unlimited") : $plan["permission"]->team->count)." ".e("Team Members"); ?></li>
                    <li class="mb-1 <?php echo $plan["permission"]->domain->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->domain->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo ($plan["permission"]->domain->count == "0" ? e("Unlimited") : $plan["permission"]->domain->count)." ".e("Branded Domains"); ?></li>
                    <li class="mb-1 <?php echo $plan["permission"]->bundle->enabled ? '' : 'text-muted' ?>"><?php echo $plan["permission"]->bundle->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo e("Campaigns & Link Rotator") ?></li>        
                    <li class="mb-1"><?php echo $plan["permission"]->export->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span> ' : '<span data-feather="x-circle" class="text-danger mr-1"></span> ' ?>  <?php echo e("Export Data") ?></li>        
                    <li class="mb-1"><?php echo $plan["permission"]->api->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php echo e("Developer API"); ?></li>											              
                    <li class="mb-1"><?php echo $plan["free"]  ? '<span data-feather="x-circle" class="text-danger mr-1"></span>' : '<span data-feather="check-circle" class="mr-1 text-success"></span>' ?> <?php echo e("URL Customization") ?></li>                
                    <li class="mb-1"><?php echo $plan["free"]  ? '<span data-feather="x-circle" class="mr-1 text-danger"></span>' : '<span data-feather="check-circle" class="text-success"></span>' ?> <?php echo e("Advertisement-Free") ?></li> 
                    <?php echo $plan["permission"]->custom  ? '<li class="mb-1"><span data-feather="check-circle" class="text-success"></span> '.$plan["permission"]->custom.'</li>' : '' ?>
                </ul>
                <a href="<?php echo route('pricing') ?>" class="btn btn-primary mb-3"><?php ee('Upgrade') ?></a>    
            </div>
        </div>
        <?php if($user->pro): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php ee("Cancel Membership") ?></h5>
            </div>
            <div class="card-body">
                <p><?php ee("You can cancel your membership whenever your want. Upon request, your membership will be canceled right before your next payment period. This means you can still enjoy premium features until the end of your membership.") ?></p>
                <p><a href="#" data-bs-toggle="modal" data-bs-target="#cancelModal" class="btn btn-danger"><?php ee("Cancel membership") ?></a></p>
            </div>
        </div>
        <?php endif ?>
    </div> 
</div>
<?php if($user->pro): ?>
<div class="modal fade" id="cancelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?php echo route('cancel') ?>" method="post">
    <?php echo csrf() ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Cancel Membership') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?php ee('We respect your decision and we are sorry to see you go. If you want to share anything with us, please use the box below and we will do our best to improve our service.') ?></p>

                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Password") ?></label>			
                    <input type="password" name="password" class="form-control p-2">
                </div>				
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Reason for cancellation") ?></label>			
                    <textarea name="reason" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger"><?php ee('Cancel membership') ?></button>
            </div>
        </div>
    </form>
  </div>
</div>
<?php endif ?>