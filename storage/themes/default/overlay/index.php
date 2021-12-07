<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('CTA Overlay') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="<?php echo route('overlay.create') ?>" class="btn btn-primary"><?php ee('Create a CTA Overlay') ?></a>
    </div>
</div>

<div class="row">
    <div class="col-lg-9">
        <div class="row">        
            <?php if($overlaypages): ?>
                <?php foreach($overlaypages as $overlay): ?>
                    <div class="col-md-4">
                        <div class="card flex-fill">
                            <div class="card-body">        
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <i class="icon-45" data-feather="<?php echo $overlay->icon ?>"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?php echo route('overlay.edit', [$overlay->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></span></a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="<?php echo route('overlay.delete', [$overlay->id, \Core\Helper::nonce('overlay.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></span></a></li>
                                            </ul>                        
                                        </div>
                                        <strong><?php echo $overlay->name ?></strong>
                                        <br />
                                        <small class="badge bg-primary"><?php ee(ucfirst($overlay->type)) ?></small>
                                        <small class="text-navy"><?php echo \Core\Helper::timeago($overlay->date) ?></small>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                <?php endforeach ?> 
            <?php else: ?>
                <div class="card flex-fill">
                    <div class="card-body text-center">
                        <p><?php ee('No content found. You can create some.') ?></p>
                        <a href="<?php echo route('overlay.create') ?>" class="btn btn-primary"><?php ee('Create a CTA Overlay') ?></a>
                    </div>
                </div>
            <?php endif ?>
        </div>           
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3"><?php ee('CTA Overlay') ?></h5>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $total == 0 ? 100 : round($count*100/$total) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $count ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></div>
                </div>            
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('What is a CTA overlay?') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('An overlay page allows you to display a small non-intrusive overlay on the destination website to advertise your product or your services. You can also use this feature to send a message to your users. You can customize the message and the appearance of the overlay right from this page. As soon as you save it, the changes will be applied immediately across all your URLs using this type. Please note that some secured and sensitive websites such as google.com or facebook.com do not work with this feature. You can have unlimited overlay pages and you can choose one for each URL.') ?></p>            
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