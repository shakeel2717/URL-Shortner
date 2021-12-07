<h1 class="h3 mb-5"><?php ee('Affiliate') ?></h1>
<div class="row">
    <div class="col-md-9">        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php ee('Referral History') ?></h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('User') ?></th>
                            <th><?php ee('Referred') ?></th>
                            <th><?php ee('Commission') ?></th>
                            <th><?php ee('Referred On') ?></th>
                            <th><?php ee('Paid On') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sales as $sale): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $sale->user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                        <div class="ms-2">
                                            <a href="<?php echo route('admin.user.edit', [$sale->user->id]) ?>"><?php echo $sale->user->email ?></a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $sale->referred->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                        <div class="ms-2">
                                            <a href="<?php echo route('admin.user.edit', [$sale->referred->id]) ?>"><?php echo $sale->referred->email ?></a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo \Helpers\App::currency(config('currency'), $sale->amount) ?>
                                    <?php if($sale->status == "1"): ?>
                                        <span class="badge bg-success"><?php ee('Approved') ?></span>
                                    <?php elseif($sale->status == "3"): ?>
                                        <span class="badge bg-success"><?php ee('Paid') ?></span>                                  
                                    <?php elseif($sale->status == "2"): ?>
                                        <span class="badge bg-danger"><?php ee('Rejected') ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning"><?php ee('Pending') ?></span>
                                    <?php endif ?>
                                </td>                                    
                                <td><?php echo \Core\Helper::dtime($sale->referred_on, 'Y-m-d') ?></td>
                                <td><?php echo $sale->paid_on ? \Core\Helper::dtime($sale->paid_on, 'Y-m-d') : e('Pending') ?></td>
                                <td>
                                    <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <?php if($sale->status != "1" && $sale->status != "3"): ?>
                                            <li><a class="dropdown-item" href="<?php echo route('admin.affiliate.update', [$sale->id, 'approve']) ?>"><i data-feather="check"></i> <?php ee('Approve Referral') ?></a></li>
                                            <li><a class="dropdown-item" href="<?php echo route('admin.affiliate.update', [$sale->id, 'reject']) ?>"><i data-feather="x"></i> <?php ee('Reject Referral') ?></a></li>
                                        <?php endif ?>
                                        <li><a class="dropdown-item" href="<?php echo  route('admin.email', ['email'=> $sale->user->email])  ?>"><i data-feather="send"></i> <?php ee('Email User') ?></a></li>
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php ee('Affiliate Settings') ?></h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>       
                    <div class="form-group">
                        <label for="affiliate[enabled]" class="form-label"><?php ee('Enable Affiliates') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="affiliate[enabled]" name="affiliate[enabled]" value="1" <?php echo config("affiliate")->enabled ? 'checked':'' ?>>
                            <label class="form-check-label" for="homepage_stats"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enable customers to earn commission on qualifying sales.') ?></p>
                    </div>                                  
                    <div class="form-group">
                        <label for="affiliate[rate]" class="form-label"><?php ee('Commission Rate') ?></label>
                        <input type="text" class="form-control" name="affiliate[rate]" id="affiliate[rate]" value="<?php echo config('affiliate')->rate ?>">
                        <p class="form-text"><?php ee('Enter the commission you want to give to users.') ?></p>
                    </div>   
                    <div class="form-group">
                        <label for="affiliate[payout]" class="form-label"><?php ee('Minimum Payout') ?></label>
                        <input type="text" class="form-control" name="affiliate[payout]" id="affiliate[payout]" value="<?php echo config('affiliate')->payout ?>">
                        <p class="form-text"><?php ee('Enter the minimum amount of commission to qualify for a payout.') ?></p>
                    </div> 
                    <div class="form-group">
                        <label for="affiliate[terms]" class="form-label"><?php ee('Terms') ?></label>
                        <textarea id="affiliate[terms]" class="form-control" name="affiliate[terms]"><?php echo config('affiliate')->terms ?></textarea>
                        <p class="form-text"><?php ee('Add your custom terms for affiliate.') ?></p>
                    </div>  
                    <button type="submit" class="btn btn-primary"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>   
</div>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Are you sure you want to delete this?') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to delete a record. This action is permanent and cannot be reversed.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>