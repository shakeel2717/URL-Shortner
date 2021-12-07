<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Branded Domains') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="<?php echo route('domain.create') ?>" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Domain') ?></a>
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
                                <td><?php echo $domain->redirect?:e('None') ?></td>
                                <td><?php echo $domain->redirect404?:e('None') ?></td>
                                <td>
                                    <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo route('domain.edit', [$domain->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit Domain') ?></a></li>    
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('domain.delete', [$domain->id, \Core\Helper::nonce('domain.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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
            <div class="card-body">
                <h5 class="card-title mb-3"><?php ee('Domains') ?></h5>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $total == 0 ? 100 : round($count*100/$total) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $count ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></div>
                </div>            
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('How to setup custom domain') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('If you have a custom domain name that you want to use with our service, you can associate it to your account very easily. Once added, we will add the domain to your account and set it as the default domain name for your URLs. DNS changes could take up to 36 hours. If you are planning to serve SSL on your domain name, we recommend using cloudflare.') ?></p>
                <?php if(config("serverip")): ?>
					<p><?php ee("To point your domain name, create an A record and set the value to ") ?><strong><?php echo config("serverip") ?></strong></p>
				<?php endif ?>
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