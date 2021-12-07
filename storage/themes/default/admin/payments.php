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
    <?php echo pagination('pagination') ?>
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