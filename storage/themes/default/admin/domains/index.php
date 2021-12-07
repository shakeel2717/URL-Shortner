<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Domains') ?></h1>
    </div>
    <div class="ms-auto">
    <a href="<?php echo route('admin.domains.new') ?>" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Domain') ?></a>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="card flex-fill">            
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Domain') ?></th>
                            <th><?php ee('User') ?></th>
                            <th><?php ee('Domain Root') ?></th>
                            <th><?php ee('404 Redirect') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($domains as $domain): ?>
                            <tr>
                                <td>
                                    <?php echo $domain->domain ?>
                                    <?php if($domain->status == "1"): ?>
                                    <span class="badge bg-success"><?php ee('Active') ?></span>
                                    <?php elseif($domain->status == "2"): ?>
                                    <span class="badge bg-warning"><?php ee('Pending DNS') ?></span>
                                    <?php else: ?>
                                    <span class="badge bg-danger"><?php ee('Inactive/Disabled') ?></span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <a href="<?php echo route('admin.users.edit', [$domain->userid]) ?>"><?php echo $domain->user ?></a>
                                    <a href="<?php echo route('admin.email', ['email' => $domain->user]) ?>"><span class="badge bg-success"><?php ee('Send email') ?></span></a>
                                </td>
                                <td><?php echo $domain->redirect?:e('None') ?></td>
                                <td><?php echo $domain->redirect404?:e('None') ?></td>
                                <td>
                                    <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo route('admin.domains.edit', [$domain->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit Domain') ?></a></li>
                                    <?php if($domain->status == "1"): ?>
                                        <li><a class="dropdown-item" href="<?php echo route('admin.domains.disable', [$domain->id]) ?>"><i data-feather="x-circle"></i> <?php ee('Disable Domain') ?></a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="<?php echo route('admin.domains.activate', [$domain->id]) ?>"><i data-feather="check-circle"></i> <?php ee('Activate Domain') ?></a></li>
                                    <?php endif ?>
                                        <li><a class="dropdown-item" href="<?php echo route('admin.domains.pending', [$domain->id]) ?>"><i data-feather="check-circle"></i> <?php ee('Set to pending') ?></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.domains.delete', [$domain->id, \Core\Helper::nonce('domain.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>    
            </div>
            <?php echo pagination('pagination') ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('Domains') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('Customers can add their own domain name and use it to shorten URLs. This will require some setup. Your customers can add their own domain name via the Custom Domain page. They will need to either add an A record or a CNAME record. On your side, you will require some changes before your server can accept their domains. If you are using cPanel, add the following the domain and make sure the directory is the same as current script directory. If you are on a VPS, please see the documentation via the link below.') ?></p>
                <a href="https://gempixel.com/docs/premium-url-shortener?utm_source=AppAdmin#cd" class="btn btn-primary" target="_blank"><?php ee('Get Help') ?></a>
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