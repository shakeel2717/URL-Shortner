<h1 class="h3 mb-5"><?php ee('Link Details') ?></h1>
<?php if(!$url->status): ?>
    <div class="alert alert-warning p-2 rounded">
        <?php ee('This link requires approval. Please review this link and approve it.') ?>
    </div>
<?php endif ?>
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card mb-3">
            <?php if($user): ?>
                <div class="card-header">
                    <h5 class="card-title mb-0"><?php echo ee('Owner') ?></h5>
                </div>
                <div class="card-body text-center">
                    <img src="<?php echo $user->avatar() ?>" alt="<?php echo $user->username ?>" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                    <h5 class="card-title mb-0"><?php echo $user->username ?></h5>
                    <div class="text-muted mb-2"><?php echo $user->pro ? $plan->name : 'Free user' ?></div>

                    <div>
                        <a class="btn btn-primary btn-sm" href="<?php echo route('admin.email', ['email'=> $user->email]) ?>"><span data-feather="message-square"></span> <?php echo e('Send Email') ?></a>
                        <a class="btn btn-primary btn-sm" href="<?php echo route('admin.users.edit', [$user->id]) ?>"><span data-feather="edit"></span></a>
                    </div>
                </div>                  
            <?php else: ?>
                <div class="card-header">
                    <?php ee('Anonymous user') ?>
                </div>
            <?php endif ?>
        </div> 
        <div class="card">
            <div class="card-body">
                <div class="list-group list-group-flush">                    
                    <a class="list-group-item list-group-item-action" href="<?php echo route('admin.links.edit', [$url->id]) ?>"><?php ee('Edit Link') ?></a>
                    <?php if($url->status): ?>
                        <a class="list-group-item list-group-item-action" href="<?php echo route('admin.links.disable', [$url->id]) ?>"><?php ee('Disable Link') ?></a>
                    <?php else: ?>
                        <a class="list-group-item list-group-item-action" href="<?php echo route('admin.links.approve', [$url->id]) ?>"><?php ee('Approve Link') ?></a>
                    <?php endif ?>
                    <a class="list-group-item list-group-item-action" href="<?php echo route('admin.links.delete', [$url->id, \Core\Helper::nonce('link.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><?php ee('Delete Link') ?></a>
                </div>
            </div>
        </div>               
    </div>

    <div class="col-md-8 col-xl-9">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><?php ee('Clicks') ?></h5>
                        <h1 class="mt-1 mb-3"><?php echo $url->click ?></h1>                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><?php ee('Unique Clicks') ?></h5>
                        <h1 class="mt-1 mb-3"><?php echo $url->uniqueclick ?></h1>                        
                    </div>
                </div>       
            </div>  
        </div>    
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php ee('Links') ?></h5>
            </div>
            <div class="card-body h-100">
                <div class="form-group">
                    <label for="url" class="form-label"><?php ee('URL') ?></label>
                    <div class="input-group">
                        <div class="input-group-text"><i data-feather="link"></i></div>
                        <input type="text" class="form-control p-2 border-start-0 ps-0" id="url" readonly value="<?php echo $url->url ?>" autocomplete="off">
                    </div>
                </div>  
                <div class="row">    
                    <div class="col-sm-4 mt-3">
                        <div class="form-group">
                            <label for="alias" class="form-label"><?php ee('Alias') ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i data-feather="globe"></i></div>
                                <input type="text" class="form-control p-2 border-start-0 ps-0" id="alias" value="<?php echo $url->alias ?>" disabled autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mt-3">
                        <div class="form-group">
                            <label for="custom" class="form-label"><?php ee('Custom') ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i data-feather="globe"></i></div>
                                <input type="text" class="form-control p-2 border-start-0 ps-0" readonly id="custom" placeholder="<?php echo e("Type your custom alias here")?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="pass" class="form-label"><?php ee('Password Protection') ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i data-feather="lock"></i></div>
                                <input type="text" class="form-control p-2 border-start-0 ps-0" readonly id="pass" placeholder="<?php echo e("Type your password here")?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="expiry" class="form-label"><?php ee('Link Expiration') ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i data-feather="lock"></i></div>
                                <input type="text" class="form-control p-2 border-start-0 ps-0" readonly id="expiry" placeholder="<?php echo e("MM/DD/YYYY")?>" autocomplete = "off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="expiry" class="form-label"><?php echo e("Description")?></label>
                            <div class="input-group">
                                <span class="input-group-text"><i data-feather="tag"></i></span>
                                <input type="text" class="form-control p-2 border-start-0 ps-0" readonly id="description" placeholder="<?php echo e("Type your description here")?>" autocomplete = "off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <hr>
                    <h4><?php echo e("Meta Tags")?></h4>
                    <div class="row">   
                        <div class="col-lg-4 col-md-6 mt-3">
                            <div class="form-group">
                                <label for="metatitle" class="form-label"><?php ee('Meta Title') ?></label>                    
                                <input type="text" class="form-control p-2" readonly id="metatitle" placeholder="<?php echo e("Enter your custom meta title")?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mt-3">
                            <div class="form-group">
                                <label for="metadescription" class="form-label"><?php ee('Meta Description') ?></label>                    
                                <input type="text" class="form-control p-2" readonly id="metadescription" placeholder="<?php echo e("Enter your custom meta description")?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>    
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