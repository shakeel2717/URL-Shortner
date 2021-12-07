<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Plugins') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="#" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#uploadModal" class="btn btn-primary"><?php ee('Upload Plugin') ?></a>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Name') ?></th>
                            <th><?php ee('Author') ?></th>
                            <th><?php ee('Description') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>             
                        <?php foreach($plugins as $plugin): ?>
                            <tr>
                                <td>
                                    <?php echo $plugin->name ?> (v<?php echo $plugin->version ?>)
                                    <?php if($plugin->enabled): ?>
                                        <span class="badge bg-success text-white"><?php ee('Active') ?></span>
                                    <?php endif ?>
                                </td>
                                <td><a href="<?php echo $plugin->link ?>" target="_blank"><?php echo $plugin->author ?></a></td>
                                <td><?php echo $plugin->description ?></td>
                                <td>
                                    <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <?php if($plugin->enabled): ?>
                                            <li><a class="dropdown-item" href="<?php echo route('admin.plugins.disable', [$plugin->id]) ?>"><i data-feather="delete"></i> <?php ee('Disable') ?></a></li>
                                        <?php else: ?>
                                            <li><a class="dropdown-item" href="<?php echo route('admin.plugins.activate', [$plugin->id]) ?>"><i data-feather="check-circle"></i> <?php ee('Activate') ?></a></li>
                                        <?php endif ?>
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
        <div class="card card-body">
            <p><?php ee('To learn more about plugins or to learn how to create your own plugin, please check our plugin documentation.') ?></p>
            <a href="https://gempixel.com/docs/premium-url-shortener/plugins" target="_blank" class="btn btn-primary">Plugin documentation</a>
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
<div class="modal fade" id="uploadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="<?php echo route('admin.plugins.upload') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Upload or Update Plugin') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="file" class="form-label"><?php ee('Plugin File') ?></label>
                    <input type="file" class="form-control" name="file" id="file" value="" accept=".zip" placeholder="e.g. PLUGINNAME.zip">
                    <p class="form-text"><?php ee('Upload the zip file that comes in the package. Usually it is named PLUGINNAME.zip. Please make sure the plugin respects the file structure.') ?></p>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Upload') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>