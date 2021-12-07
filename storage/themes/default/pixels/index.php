<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Tracking Pixels') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="<?php echo route('pixel.create') ?>" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Pixel') ?></a>
    </div>    
</div>
<div class="row">
    <div class="col-md-9">
        <?php if($count): ?>
            <div class="row">
                <?php foreach($pixels as $pixel): ?>
                    <div class="col-md-4">
                        <div class="card flex-fill">
                            <div class="card-body">        
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo ucfirst(\Helpers\App::pixelName($pixel->type)) ?>"><img src="<?php echo assets('images/'.str_replace(['pixel','fb'], ['', 'facebook'], $pixel->type).'.svg') ?>" width="45"></span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?php echo route('pixel.edit', [$pixel->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit Pixel') ?></a></li>    
                                                <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('pixel.delete', [$pixel->id, \Core\Helper::nonce('pixel.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                            </ul>                       
                                        </div>
                                        <strong><?php echo $pixel->name ?: 'n\a' ?></strong> <br>
                                        <small class="text-navy"><?php echo \Core\Helper::timeago($pixel->created_at) ?></small>
                                        <br>
                                        <small class="badge bg-primary"><?php echo \Core\Helper::truncate($pixel->tag, 20) ?></small>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>  
            </div>              
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center">
                    <p><?php ee('No content found. You can create some.') ?></p>
                    <a href="<?php echo route('pixel.create') ?>" class="btn btn-primary btn-sm"><?php ee('Add Pixel') ?></a>
                </div>
            </div>
        <?php endif ?>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3"><?php ee('Pixels') ?></h5>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $total == 0 ? 100 : round($count*100/$total) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $count ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></div>
                </div>            
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('What are tracking pixels?') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('Ad platforms such as Facebook and Adwords provide a conversion tracking tool to allow you to gather data on your customers and how they behave on your website. By adding your pixel ID from either of the platforms, you will be able to optimize marketing simply by using short URLs.') ?></p>
                <a href="<?php echo route('faq') ?>#pixels" class="btn btn-primary btn-sm"><?php ee("More info") ?></a>             
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