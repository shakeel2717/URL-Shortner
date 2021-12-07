<h1 class="h3 mb-3"><?php ee('Invoice') ?></h1>

<div class="row">
    <div class="col-12">
        <div class="card">                                     
            <div class="d-flex p-4">   
                <div>
                    <a class="navbar-brand" href="<?php echo route('home') ?>">
                        <?php if(config('logo')): ?>
                            <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                        <?php else: ?>
                            <h1 class="h3 mt-2 ms-4"><?php echo config('title') ?></h1>
                        <?php endif ?>
                    </a>                       
                </div>                                  
                <div class="ms-auto">
                    <?php if($payment->status == "Completed" || $payment->status == "Refunded"): ?>
                        <span class="badge bg-success fs-4"><?php echo $payment->status ?></span>
                    <?php endif ?>
                </div>
            </div>           
            <div class="card-body m-sm-3 m-md-5">                               
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-muted"><?php ee('Invoice') ?></div>
                        <strong><?php echo $payment->tid ?></strong>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="text-muted"><?php ee('Payment Date') ?></div>
                        <strong><?php echo \Core\Helper::dtime($payment->date, 'd/m/Y') ?></strong>
                    </div>
                </div>

                <hr class="my-4" />

                <div class="row mb-4">
                    <div class="col-md-6">
                    <div class="text-muted"><?php ee('Bill to') ?></div>
                        <strong><?php echo $user->name ?: $user->username ?></strong>
                        <p><?php echo $user->email ?></p>
                        <p>
                            <?php echo $user->address->address?: '' ?> <br />
                            <?php echo $user->address->city?: '' ?> <?php echo $user->address->state?: '' ?> <br />
                            <?php echo $user->address->zip?: '' ?> <br />
                            <?php echo $user->address->country?: '' ?> <br />                            
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="text-muted"><?php ee('Payment To') ?></div>
                        <?php echo nl2br(config('invoice')->header) ?>
                    </div>
                </div>

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th><?php ee('Description') ?></th>
                            <th></th>
                            <th class="text-end"><?php ee('Amount') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php ee('Subscription') ?></td>
                            <td></td>
                            <td class="text-end"><?php echo $payment->trial_days ? 'Trial' : \Helpers\App::currency(config('currency'), $payment->amount) ?></td>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <th><?php ee('Total') ?></th>
                            <th class="text-end"><?php echo $payment->trial_days ? 'Trial' : \Helpers\App::currency(config('currency'), $payment->amount) ?></th>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center mt-4">
                    <p class="text-sm">
                        <?php echo nl2br(config('invoice')->footer) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
