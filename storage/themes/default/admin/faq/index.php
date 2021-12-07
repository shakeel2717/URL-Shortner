<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('FAQs') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="<?php echo route('admin.faq.new') ?>" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add FAQ') ?></a>
    </div>
</div>
<div class="card flex-fill">    
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Question') ?></th>
                    <th><?php ee('Category') ?></th>
                    <th><?php ee('Permalink') ?></th>
                    <th><?php ee('Created on') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($faqs as $faq): ?>
                    <tr>
                        <td>
                            <a href="<?php echo route('faq') ?>#<?php echo $faq->slug ?>" target="_blank"><i data-feather="link"></i> <?php echo $faq->question ?></a>
                            <?php if($faq->pricing): ?>
                                <span class="badge bg-success"><?php ee("Pricing Page") ?></span>
                            <?php endif ?>
                        </td>
                        <td><?php echo ucfirst($faq->category) ?></td>
                        <td><span class="badge bg-primary"><?php echo $faq->slug ?></span></td>
                        <td><?php echo \Core\Helper::dtime($faq->created_at, 'd-m-Y') ?></td>
                        <td>
                            <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.faq.edit', [$faq->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.faq.delete', [$faq->id, \Core\Helper::nonce('faq.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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