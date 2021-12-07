<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Custom Splash Pages') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="<?php echo route('splash.create') ?>" class="btn btn-primary"><?php ee('Create a Custom Splash') ?></a>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="row">
            <?php if($splashpages): ?>
                <?php foreach($splashpages as $splash): ?>
                    <div class="col-md-4">
                        <div class="card flex-fill">
                            <div class="card-body">        
                                <div class="d-flex align-items-start">
                                    <?php if($avatar = json_decode($splash->data)->avatar):?>
                                        <div class="me-3">
                                           <img src="<?php echo uploads($avatar) ?>" width="45" class="fluid-image rounded">
                                        </div>
                                    <?php endif ?>                                    
                                    <div class="flex-grow-1">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?php echo route('splash.edit', [$splash->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></span></a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="<?php echo route('splash.delete', [$splash->id, \Core\Helper::nonce('splash.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></span></a></li>
                                            </ul>                        
                                        </div>
                                        <strong><?php echo $splash->name ?></strong>
                                        <br />
                                        <small class="text-navy"><?php echo \Core\Helper::timeago($splash->date) ?></small>
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
                        <a href="<?php echo route('splash.create') ?>" class="btn btn-primary btn-sm"><?php ee('Create a Custom Splash') ?></a>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3"><?php ee('Custom Splash Pages') ?></h5>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $total == 0 ? 100 : round($count*100/$total) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $count ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></div>
                </div>            
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('What is a custom splash page?') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('A custom splash page is a transitional page where you can add a banner and a logo along with a message to represent your brand or company. When creating a short link, you will be able to assign the page to your short url. Users who visit your url will briefly see the page before being redirected to their destination.') ?></p>            
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