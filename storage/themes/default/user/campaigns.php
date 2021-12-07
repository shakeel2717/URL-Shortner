<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Campaigns') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="#" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary"><?php ee('Create a Campaign') ?></a>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="row">
            <?php if($campaigns): ?>
                <?php foreach($campaigns as $campaign): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card flex-fill h-100">
                            <div class="card-body">        
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?php echo route('links', ['campaign' => $campaign->id]) ?>"><i data-feather="link"></i> <?php ee('Links') ?></span></a></li>
                                                <li><a class="dropdown-item" href="<?php echo route('campaigns.update', [$campaign->id]) ?>" data-bs-toggle="modal" data-bs-target="#updateModal" data-toggle="updateFormContent" data-content='<?php echo json_encode(['newname' => $campaign->name, 'newslug' => $campaign->slug, 'newacess' => $campaign->access]) ?>'><i data-feather="edit"></i> <?php ee('Edit') ?></span></a></li>
                                                <li><a class="dropdown-item" href="<?php echo route('campaigns.stats', [$campaign->id]) ?>"><i data-feather="bar-chart-2"></i> <?php ee('Statistics') ?></span></a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="<?php echo route('campaigns.delete', [$campaign->id, \Core\Helper::nonce('campaign.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></span></a></li>
                                            </ul>                        
                                        </div>
                                        <?php echo $campaign->access == 'private' ? '<span class="badge mb-2 bg-danger">'.e('Inactive').'</span>' : '<span class="badge mb-2 bg-success">'.e('Active').'</span>' ?>
                                        <p><strong><?php echo $campaign->name ?></strong></p>                                        
                                        <?php if($campaign->slug): ?>
                                            <?php if(user()->username): ?>
                                            <p>
                                                <strong><?php ee('List') ?></strong><br>
                                                <small class="text-muted" data-href="<?php echo route('campaign.list', [user()->username, $campaign->slug.'-'.$campaign->id]) ?>"><?php echo route('campaign.list', [user()->username, $campaign->slug.'-'.$campaign->id]) ?></small>
                                                <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo route('campaign.list', [user()->username, $campaign->slug.'-'.$campaign->id]) ?>"><small><?php echo e("Copy")?></small></a>	                                            
                                            </p> 
                                            <?php endif ?>
                                            <p>
                                                <strong><?php ee('Rotator') ?></strong><br>
                                                <small class="text-muted" data-href="<?php echo route('campaign', [$campaign->slug]) ?>"><?php echo route('campaign', [$campaign->slug]) ?></small>
                                                <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo route('campaign', [$campaign->slug]) ?>"><small><?php echo e("Copy")?></small></a>	                                            
                                            </p>                                            
                                        <?php endif ?>
                                        <small class="text-navy"><?php echo $campaign->view ?> <?php ee('views') ?></small> - 
                                        <small class="text-navy"><?php echo $campaign->urlcount ?> <?php ee('links') ?></small> - 
                                        <small class="text-navy"><?php echo \Core\Helper::timeago($campaign->date) ?></small>
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
                        <a href="" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary btn-sm"><?php ee('Create a Campaign') ?></a>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="col-md-3">        
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('What is a campaign?') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p class="text-justify"> <?php echo ee('A campaign can be used to group links together for various purpose. You can use the dedicated rotator link where a random link will be chosen and redirected to among the group. You will also be able to view aggregated statistics for a campaign.') ?></p>            
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="<?php echo route('campaigns.save') ?>" method="post">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Create a Campaign') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Campaign Name") ?> (<?php ee("required") ?>)</label>			
                    <input type="text" value="" name="name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Rotator Slug") ?> (<?php ee("optional") ?>)</label>			
                    <input type="text" value="" name="slug" class="form-control">
                    <p class="form-text"><?php ee("If you want to set a custom alias for the rotator link, you can fill this field.") ?></p>
                </div>
                <div class="d-flex">
                    <div>
                        <label class="form-check-label" for="access"><?php ee('Access') ?></label>
                        <p class="form-text"><?php ee('Disabling this option will deactivate the rotator link.') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto">
                        <input class="form-check-input" type="checkbox" data-binary="true" id="access" name="access" value="1">
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Create Campaign') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="#" method="post">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Update Campaign') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Campaign Name") ?> (<?php ee("required") ?>)</label>			
                    <input type="text" value="" name="newname" id="newname" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Rotator Slug") ?> (<?php ee("optional") ?>)</label>			
                    <input type="text" value="" name="newslug" id="newslug" class="form-control">
                    <p class="form-text"><?php ee("If you want to set a custom alias for the rotator link, you can fill this field.") ?></p>
                </div>
                <div class="d-flex">
                    <div>
                        <label class="form-check-label" for="access"><?php ee('Access') ?></label>
                        <p class="form-text"><?php ee('Disabling this option will deactivate the rotator link.') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto">
                        <input class="form-check-input" type="checkbox" data-binary="true" id="newaccess" name="newaccess" value="1">
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Update Campaign') ?></button>
            </div>
        </form>
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