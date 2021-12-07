<h1 class="h3 mb-5"><?php ee('Automatic Updater') ?></h1>
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <?php if($update): ?>
                    <h5 class="card-title fw-bold"><?php ee('New update available') ?></h5>
                    <div class="p-3 my-3 bg-default border rounded">
                        <p class="mb-2"><strong>v<?php echo $update ?> - <?php echo $changes[0]->date ?></strong></p>
                        <?php foreach ($changes as $change): ?>
                            <p class="mb-2"><span class="badge bg-<?php echo $change->class ?> me-2"><?php echo $change->type ?></span>  <?php echo $change->title ?><?php echo $change->description ? " <br><small>{$change->description}</small>" : "" ?></p>
                        <?php endforeach ?>
                    </div>
                    <p><?php ee('You can use this tool to automatically update this script. To be safe, we recommend you backup your site regularly. You will need your purchase code to update automatically. You can find your purchase key in the downloads section of codecayon. Also please note that this updater will replace all files. This means all of your custom changes will be overwritten.') ?></p>
                    <p>
                        <ul class="list-unstyled">
                            <?php if(!in_array('curl', get_loaded_extensions())): ?>
                                <li class="mb-2"><i class="me-2 text-danger" date-feather="x-circle"></i>cURL library is not available. Please update manually.</li>
                            <?php else: ?>
                                <li class="mb-2"><i class="me-2 text-success" data-feather="check-circle"></i>cURL library is available.</li>
                            <?php endif ?>
                            <?php if(!class_exists("ZipArchive")): ?>
                                <li class="mb-2"><i class="me-2 text-danger" date-feather="x-circle"></i>ZipArchive library is not available. Please update manually.</li>
                            <?php else: ?>
                                <li class="mb-2"><i class="me-2 text-success" data-feather="check-circle"></i>ZipArchive library is available.</li>
                            <?php endif ?>
                            <?php if(!is_writable(ROOT)): ?>
                                <li class="mb-2"><i class="me-2 text-danger" date-feather="x-circle"></i>Document root is not writable.</li>
                            <?php else: ?>
                                <li class="mb-2"><i class="me-2 text-success" data-feather="check-circle"></i>Document root is writable.</li>
                            <?php endif ?>
                        </ul>                   
                    </p>
                    <form action="<?php echo route('admin.update.process') ?>" method="post" class="mt-5">
                        <?php echo csrf() ?>
                        <div class="form-group mb-2">
                            <label for="code" class="form-label"><?php ee('Purchase Code') ?></label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Envato Purchase Code"  value="<?php echo config('purchasecode') ?>" autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Updating"><?php ee('Update') ?></button>
                    </form>                
                <?php else: ?>
                    <h5 class="card-title fw-bold"><?php ee('No update available') ?></h5>
                    <p><?php ee('When a new update is available, you will see a notification in the sidebar and in the top menu. Please make sure you have enabled update notification in the admin') ?> <a href="<?php echo route('admin.settings.config', ['app']) ?>"><u><?php ee('settings') ?></u></a>. </p>
                <?php endif ?>                
            </div>
        </div>
    </div> 
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><h5 class="card-title"><?php ee('Script Information') ?></h5></div>      
            <div class="card-body">             
                <p><strong><?php ee('Current Script Version') ?>:</strong> <?php echo config('version') ?></p>
                <div class="d-flex">
                    <div>
                        <strong><?php ee('Current PHP Version') ?>:</strong> <?php echo phpversion() ?> 
                    </div>
                    <div class="ms-auto">
                        <a href="<?php echo route('admin.phpinfo') ?>" class="badge bg-primary text-white" target="_blank"><?php ee('View PHP Info') ?></a>
                    </div>
                </div>
                <hr>
                <div class="d-flex mb-2">
                    <div>
                        <strong><?php ee('Last Update Released') ?>:</strong> <?php echo $changes ? $changes[0]->date : 'na' ?>
                    </div>
                    <div class="ms-auto">
                        <a href="https://gempixel.com/changelog/premium-url-shortener" class="badge bg-primary text-white" target="_blank"><?php ee('View Changelog') ?></a>
                    </div>
                </div>
                <p><strong><?php ee('Envato Purchase Code') ?>: </strong> <?php echo config('purchasecode') ?></p>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><?php ee('Enter Purchase Code') ?></div>      
            <div class="card-body">             
                <p><?php ee('Enter your purchase code to receive automated updates.') ?></p> 
                <form method="post">
                    <div class="form-group">
                        <label class="form-label"><?php ee('Envato Purchase Code') ?></label>
                        <input class="form-control" name="newcode" value="<?php echo config("purchasecode") ?>">
                    </div>
                    <button type="submit" class="btn btn-success mt-2"><?php ee('Update') ?></button> 
                </form>
            </div>
        </div>
    </div>  
</div>
<div class="modal fade" id="Updating" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Updating...') ?></h5>
      </div>
      <div class="modal-body">
        <p><?php ee("Updating script. Please hold. Don't close this page or press update again. The page will refresh once it is done.") ?></p>
      </div>
    </div>
  </div>
</div>