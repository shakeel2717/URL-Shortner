<h1 class="h3 mb-5"><?php ee('Affiliate') ?></h1>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php ee('Affiliate Link') ?></h5>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <input type="text" class="form-control" value="<?php echo url("?ref={$user->id}") ?>" disabled>
                    <div class="input-group-text bg-white">
                        <button class="btn btn-primary copy" data-clipboard-text="<?php echo url("?ref={$user->id}") ?>"><?php ee('Copy') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php ee('Referral History') ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th><?php ee('Commission') ?></th>
                                <th><?php ee('Referred On') ?></th>
                                <th><?php ee('Paid On') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($sales as $sale): ?>
                                <tr>
                                    <td>
                                        <?php echo \Helpers\App::currency(config('currency'), $sale->amount) ?>
                                        <?php if($sale->status == "1"): ?>
                                            <span class="badge bg-success"><?php ee('Approved') ?></span>
                                        <?php elseif($sale->status == "3"): ?>
                                            <span class="badge bg-success"><?php ee('Paid') ?></span>                                            
                                        <?php elseif($sale->status == "2"): ?>
                                            <span class="badge bg-warning"><?php ee('Rejected') ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?php ee('Pending') ?></span>
                                        <?php endif ?>
                                    </td>                                    
                                    <td><?php echo \Core\Helper::dtime($sale->referred_on, 'd-m-Y') ?></td>
                                    <td><?php echo $sale->paid_on ? \Core\Helper::dtime($sale->paid_on, 'd-m-Y') : e('Pending') ?></td>                                    
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php ee('Affiliate Rate') ?></h5>
            </div>
            <div class="card-body">
                <h1 class="text-success"><?php echo config('affiliate')->rate ?>% <span class="text-dark text-sm"><?php ee('per qualifying sales') ?></span></h1>
                <p class="mb-3 text-sm"><?php ee('Minimum earning of {amount} is required for payment.', null, ['amount' => \Helpers\App::currency(config('currency'), config('affiliate')->payout)]) ?></p>
                <?php if(config('affiliate')->terms): ?>
                    <hr>
                    <h6><?php ee('Terms') ?></h6>
                    <p class="mb-4"><?php ee(config('affiliate')->terms) ?></p>
                <?php endif ?>
                <a href="<?php echo route('contact') ?>" class="btn btn-primary"><?php ee('Contact') ?></a>
            </div>
        </div>
    </div>   
</div>