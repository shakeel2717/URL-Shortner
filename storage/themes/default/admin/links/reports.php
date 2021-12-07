<div class="row">
    <div class="col-md-9">
        <div class="card flex-fill">
            <div class="card-header">
                <div class="d-flex">
                    <div>
                        <h5 class="card-title mb-0"><?php ee('Reported Links') ?></h5>
                    </div>                    
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Reported Link') ?></th>
                            <th><?php ee('Matched Long Link') ?></th>
                            <th><?php ee('Reason') ?></th>
                            <th><?php ee('Email') ?></th>
                            <th><?php ee('Status') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reports as $report): ?>
                            <tr>
                                <td><a href="<?php echo $report->url ?>" target="_blank"><?php echo $report->url ?></a></td>
                                <td><?php echo $report->longurl ?></td>
                                <td><?php echo ucfirst($report->type) ?></td>
                                <td><?php echo $report->email ?></td>
                                <td>
                                    <?php if($report->status == "1"): ?>
                                        <span class="badge bg-danger"><?php ee('URL Banned') ?></span>
                                    <?php elseif($report->status == "2"): ?>
                                        <span class="badge bg-danger"><?php ee('Domain Banned') ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?php ee('Active') ?></span>
                                    <?php endif ?>
                                </td> 
                                <td>
                                    <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">                    
                                        <li><a class="dropdown-item" href="<?php echo route('admin.links.report.action', [$report->id, 'banurl']) ?>"><i data-feather="x-circle"></i> <?php ee('Ban URL') ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo route('admin.links.report.action', [$report->id, 'bandomain']) ?>"><i data-feather="x-circle"></i> <?php ee('Ban Domain') ?></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.links.report.action', [$report->id, 'delete']) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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
                <p><?php ee('You can ban domains or links as soon as someone reports it. By banning the link, any other user who tries to shorten this link will be prevented.') ?></p>        

                <p><?php ee('If you ban the domain, any user who tries to shorten any link in that domain will not be allowed. Banned domains are added to the list in the') ?> <?php ee('Settings') ?> > <a href="<?php echo route("admin.settings.config", ['security']) ?>"><?php ee('Security Settings') ?></a>.</p>
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