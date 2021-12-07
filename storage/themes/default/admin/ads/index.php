<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Advertisement') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="<?php echo route('admin.ads.new') ?>" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Ads') ?></a>
    </div>
</div>
<div class="card flex-fill">
    <table class="table table-hover my-0">
        <thead>
            <tr>
                <th><?php ee('Name') ?></th>
                <th class="d-none d-xl-table-cell"><?php ee('Type') ?></th>
                <th class="d-none d-xl-table-cell"><?php ee('Impression') ?></th>
                <th class="d-none d-md-table-cell"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ads as $ad): ?>
                <tr>
                    <td>
                        <?php echo $ad->name ?>
                        <?php if($ad->enabled): ?>
                            <span class="badge bg-success"><?php ee('Enabled') ?></span>
                        <?php else: ?>
                            <span class="badge bg-primary"><?php ee('Disabled') ?></span>
                        <?php endif ?>
                    </td>
                    <td class="d-none d-xl-table-cell"><?php echo \Helpers\App::adType($ad->type) ?></td>
                    <td class="d-none d-xl-table-cell"><?php echo $ad->impression ?></td>
                    <td class="d-none d-md-table-cell">
                        <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo route('admin.ads.edit', [$ad->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.ads.delete', [$ad->id, \Core\Helper::nonce('ads.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
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