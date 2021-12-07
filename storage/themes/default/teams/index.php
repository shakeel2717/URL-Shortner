<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Manage Teams') ?></h1>
    </div>
    <?php if(!user()->teamid): ?>
        <div class="ms-auto">
            <a href="#" data-bs-toggle="modal" data-bs-target="#inviteModal" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Member') ?></a>
        </div>
    <?php endif ?>
</div>
<div class="row">
    <div class="col-md-9">
        <?php if($count): ?>
            <div class="row">
                <?php foreach($teams as $team): ?>
                    <div class="col-md-4">
                        <div class="card flex-fill">
                            <div class="card-body">        
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3">
                                        <img src="<?php echo $team->avatar() ?>">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?php echo route('team.edit', [$team->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></span></a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="<?php echo route('team.delete', [$team->teamid, $team->id, \Core\Helper::nonce('team.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></span></a></li>
                                            </ul>                        
                                        </div>
                                        <strong><?php echo $team->name ? $team->name : $team->username ?> <?php echo ($team->active ? '<span class="badge bg-success">'.e("Active").'</span>' : '<span class="badge bg-danger">'.e("Inactive").'</span>') ?></strong><br>
                                        <small><?php echo $team->email ?></small>                                        
                                    </div>
                                </div> 
                                <p>
                                <?php if ($permissions = json_decode($team->teampermission)): ?>
                                    <?php foreach ($permissions as $permission): ?>
                                        <span class="badge bg-primary"><?php echo str_replace('.', ': ', $permission) ?></span>
                                    <?php endforeach ?>											
                                <?php endif ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>  
            </div>              
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center">
                    <p><?php ee('No members found. You can invite one.') ?></p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#inviteModal"  class="btn btn-primary btn-sm"><?php ee('Add Member') ?></a>
                </div>
            </div>
        <?php endif ?>        
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3"><?php ee('Team Members') ?></h5>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $total == 0 ? 100 : round($count*100/$total) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $count ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></div>
                </div>            
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('Permission') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p><?php echo e("Create: A create event will allow your team member to shorten links, create splash pages & overlay and campaigns.") ?></p>
                <p><?php echo e("Edit: An edit event will allow your team member to edit links, splash pages & overlay and campaigns.") ?></p>
                <p><?php echo e("Delete: A delete event will allow your team member to delete links, splash pages & overlay and campaigns.") ?></p>
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
<?php if(!user()->teamid): ?>
<div class="modal fade" id="inviteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="<?php echo route('team.save') ?>">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php ee('Add Member') ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php echo csrf() ?>
            <div class="form-group mb-3">
                <label for="email" class="label-control mb-2"><?php echo e("Email") ?></label>
                <input type="email" value="" name="email" class="form-control" placeholder="johndoe@email.tld" />				
            </div>	
            <div class="form-group input-select">
                <label for="permissions" class="label-control mb-2"><?php echo e("Permissions") ?></label>
                <select name="permissions[]" class="form-control" placeholder="<?php echo e("Permissions") ?>" data-placeholder="<?php echo e("Permissions") ?>" multiple data-toggle="select">	
                    <optgroup label="<?php echo e("Links") ?>">
                        <option value="links.create"><?php echo e("Create Links") ?></option>
                        <option value="links.edit"><?php echo e("Edit Links") ?></option>
                        <option value="links.delete"><?php echo e("Delete Links") ?></option>				    				
                    </optgroup>
                    <?php if (user()->has("qr") !== false): ?>
                        <optgroup label="<?php echo e("QR Codes") ?>">
                            <option value="qr.create"><?php echo e("Create QR") ?></option>
                            <option value="qr.edit"><?php echo e("Edit QR") ?></option>
                            <option value="qr.delete"><?php echo e("Delete QR") ?></option>				    				
                        </optgroup>
                    <?php endif ?>
                    <?php if (user()->has("bio") !== false): ?>
                        <optgroup label="<?php echo e("Bio Pages") ?>">
                            <option value="Bio.create"><?php echo e("Create Bio") ?></option>
                            <option value="Bio.edit"><?php echo e("Edit Bio") ?></option>
                            <option value="Bio.delete"><?php echo e("Delete Bio") ?></option>				    				
                        </optgroup>
                    <?php endif ?>
                    <?php if (user()->has("splash") !== false): ?>
                        <optgroup label="<?php echo e("Custom Splash") ?>">
                            <option value="splash.create"><?php echo e("Create Splash") ?></option>
                            <option value="splash.edit"><?php echo e("Edit Splash") ?></option>
                            <option value="splash.delete"><?php echo e("Delete Splash") ?></option>				    				
                        </optgroup>
                    <?php endif ?>
                    <?php if (user()->has("overlay") !== false): ?>
                        <optgroup label="<?php echo e("CTA Overlay") ?>">
                            <option value="overlay.create"><?php echo e("Create Overlay") ?></option>
                            <option value="overlay.edit"><?php echo e("Edit Overlay") ?></option>
                            <option value="overlay.delete"><?php echo e("Delete Overlay") ?></option>				    				
                        </optgroup>
                    <?php endif ?>	
                    <?php if (user()->has("pixels") !== false): ?>
                            <optgroup label="<?php echo e("Tracking Pixels") ?>">
                            <option value="pixels.create"><?php echo e("Create Pixels") ?></option>
                            <option value="pixels.edit"><?php echo e("Edit Pixels") ?></option>
                            <option value="pixels.delete"><?php echo e("Delete Pixels") ?></option>				    				
                        </optgroup>
                    <?php endif ?>
                    <?php if (user()->has("domain") !== false): ?>
                            <optgroup label="<?php echo e("Branded Domain") ?>">
                            <option value="domain.create"><?php echo e("Add Custom Domain") ?></option>
                            <option value="domain.delete"><?php echo e("Delete Custom Domain") ?></option>				    				
                        </optgroup>
                    <?php endif ?>								    				
                    <?php if (user()->has("bundle") !== false): ?>
                            <optgroup label="<?php echo e("Campaigns") ?>">
                            <option value="bundle.create"><?php echo e("Create Campaigns") ?></option>
                            <option value="bundle.edit"><?php echo e("Edit Campaigns") ?></option>
                            <option value="bundle.delete"><?php echo e("Delete Campaigns") ?></option>				    				
                        </optgroup>
                    <?php endif ?>	
                    <?php if (user()->has("api") !== false): ?>
                        <option value="api.create"><?php echo e("Developer API") ?></option>		    				
                    <?php endif ?>	
                    <?php if (user()->has("export") !== false): ?>
                        <option value="export.create"><?php echo e("Export Data") ?></option>		    				
                    <?php endif ?>						    						    						    					    							    		
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-success"><?php ee('Invite') ?></button>
        </div>
        </div>
    </form>
  </div>
</div>
<?php endif ?>