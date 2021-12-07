<?php if($users): ?>
<div class="card flex-fill">
    <div class="card-header">
        <div class="d-flex">
            <div>
                <h5 class="card-title mb-0"><?php ee('Users') ?></h5>
            </div>            
        </div>
    </div> 
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Email') ?></th>
                    <th><?php ee('User Status') ?></th>
                    <th><?php ee('Registration Date') ?></th>
                    <th><?php ee('Membership') ?></th>
                    <th><?php ee('Expiration') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td>
                            <?php echo ($user->admin)?"<strong>{$user->email}</strong>":$user->email ?> <?php echo ($user->trial)?"(Free Trial)":"" ?>
                            <?php echo ($user->public)?"<a href='".route('profile',[$user->username])."' class='badge bg-primary text-white' target='_blank'>@{$user->username}</a>":"" ?>
                        </td>
                        <td><?php echo ($user->active ? '<span class="badge bg-success">Active</span>':'<span class="badge bg-danger">Not Active</span>') ?> <?php echo $user->banned ? '<span class="badge bg-danger">'.e('Banned').'</span>':'' ?></td>                
                        <td><?php echo date("F d, Y",strtotime($user->date)) ?></td>
                        <td><?php echo ($user->pro ? '<span class="badge bg-success">Pro</span>':'<span class="badge bg-warning">Free</span>') ?></td>
                        <td><?php echo ($user->pro?date("F d, Y",strtotime($user->expiration)):"n/a") ?></td>                
                        <td class="d-none d-md-table-cell">
                            <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.users.payment', [$user->id]) ?>" target="_blank"><i data-feather="credit-card"></i> <?php ee('View Payment') ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.users.edit', [$user->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.users.ban', [$user->id]) ?>"><i data-feather="x-circle"></i> <?php echo $user->banned ? e('Unban') : e('Ban') ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.users.delete', [$user->id, \Core\Helper::nonce('user.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete User') ?></a></li>                                
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.users.delete.all', [$user->id, \Core\Helper::nonce('user.delete')]) ?>"><i data-feather="trash-2"></i> <?php ee('Delete User + Data') ?></a></li>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif ?>
<?php if($urls): ?>
<div class="card flex-fill">
    <div class="card-header">
        <div class="d-flex">
            <div>
                <h5 class="card-title mb-0"><?php ee('Links') ?></h5>
            </div>
        </div>
    </div> 
    <div class="card-body h-100">
      <form method="post" action="" data-trigger="options">
        <?php echo csrf() ?>
        <input class="form-check-input me-2" type="checkbox" data-trigger="checkall">
        <input type="hidden" name="selected">
        <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
        <ul class="dropdown-menu">				
          <li><a class="dropdown-item" href="<?php echo route('admin.links.deleteall') ?>"><i data-feather="trash"></i> <?php ee('Delete All') ?></span></a></li>
        </ul> 
      </form>
      <hr>
        <?php foreach($urls as $url): ?>
            <?php view('admin.partials.links', compact('url')) ?>
        <?php endforeach ?>
    </div>
</div>
<?php endif ?>
<?php if($payments): ?>
<div class="card flex-fill">
    <div class="card-header">
        <div class="d-flex">
            <div>
                <h5 class="card-title mb-0"><?php ee('Payments') ?></h5>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Transaction ID') ?></th>
                    <th><?php ee('User') ?></th>
                    <th><?php ee('Status') ?></th>
                    <th><?php ee('Amount') ?></th>
                    <th><?php ee('Date') ?></th>
                    <th><?php ee('Expiration') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($payments as $payment): ?>
                    <tr>
                        <td><?php echo $payment->tid?:'NA' ?> <?php echo (($payment->status == "Refunded") ? "(Refund)" : "") ?></td>
                        <td>
                            <a href="<?php echo route('admin.users.view', [$payment->userid]) ?>"><?php echo $payment->user ?: 'Social Media' ?></a>
                            <a href="<?php echo route('admin.email', ['email' => $payment->user]) ?>"><span class="badge bg-success"><?php ee('Send email') ?></span></a>
                        </td>
                        <td><?php echo $payment->status ?></td>
                        <td><?php echo \Helpers\App::currency(config('currency'), $payment->amount) ?></td>
                        <td><?php echo $payment->date ?></td>
                        <td><?php echo $payment->expiry ?></td>
                        <td>
                            <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.invoice', [$payment->id]) ?>"><i data-feather="file-text"></i> <?php ee('View Invoice') ?></a></li>
                                <?php if($payment->status == "Completed"): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.payments.markas', [$payment->id, 'refunded']) ?>"><i data-feather="delete"></i> <?php ee('Mark as Refunded') ?></a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.payments.markas', [$payment->id, 'paid']) ?>"><i data-feather="check-circle"></i> <?php ee('Mark as Paid') ?></a></li>
                                <?php endif ?>
                                <li><hr class="dropdown-divider"></li>   
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.payments.delete', [$payment->id, \Core\Helper::nonce('payment.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>    
    </div>
</div>
<?php endif ?>
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