<h1 class="h3 mb-5"><?php ee('Affiliate') ?></h1>
<div class="row">
    <div class="col-md-9">        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php ee('Payments') ?></h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('User') ?></th>
                            <th><?php ee('Paypal') ?></th>
                            <th><?php ee('Pending Payment') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                        <div class="ms-2">
                                            <?php echo $user->email ?>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <?php echo ($user->paypal)?"<strong>{$user->paypal}</strong>": 'No Paypal ID' ?>
                                </td> 
                                <td>
                                    <?php echo \Helpers\App::currency(config('currency'), $user->pendingpayment) ?>
                                </td>                                    
                                <td>
                                    <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo route('admin.affiliate.pay', [$user->id]) ?>"><i data-feather="check"></i> <?php ee('Mark as Paid') ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo  route('admin.email', ['email'=> $user->email])  ?>"><i data-feather="send"></i> <?php ee('Email User') ?></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>   
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body">
            <?php ee('Referrals must first be approved on the referrals page before the user can be credited the amount of commission. It is highly recommended to investigate each referral before awarding commission as possibilities of fraud is most likely. Once a referral is approved, user will be credited and if the amount due is higher than the amount in settings, it will show up here. You will then need to manually pay the user via paypal.') ?>
        </div>
    </div>
</div>