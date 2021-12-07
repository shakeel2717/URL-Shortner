<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Languages') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="<?php echo route("admin.languages.new") ?>" class="btn btn-primary"><?php ee('Create Translation') ?></a>
        <a href="#" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#uploadModal"  class="btn btn-primary"><?php ee('Upload Language') ?></a>
    </div>
</div>
<div class="row">
  <div class="col-md-9">
    <div class="card">
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th><?php ee('Name') ?></th>
                  <th><?php ee('Code') ?></th>
                  <th><?php ee('Author') ?></th>
                  <th><?php ee('Last Update') ?></th>
                  <th><?php ee('% Translated') ?></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>          
                <?php foreach ($languages as $language): ?>
                  <tr>
                    <td><?php echo $language["name"] ?> <?php echo config('default_lang') && config('default_lang') == $language["code"] ? '<span class="badge bg-primary">Default</span>': '' ?> <?php echo $language['rtl'] ? '<span class="badge bg-primary">RTL</span>' : '' ?></td>
                    <td><?php echo $language["code"] ?></td>
                    <td><a href="<?php echo $language["link"] ?>" rel="nofollow" target="_blank"><?php echo $language["author"] ?></a></td>
                    <td><?php echo $language["date"] ?></td>
                    <td>
                      <div class="progress">
                          <div class="progress-bar" role="progressbar" style="width: <?php echo $language["percent"] ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $language["percent"] ?>%</div>
                      </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                        <ul class="dropdown-menu">
                            <?php if(config('default_lang') && config('default_lang') == $language["code"]): ?>
                              <li><a class="dropdown-item" href="<?php echo route('admin.languages.set', ['en']) ?>"><i data-feather="check"></i> <?php ee('Set English as Default') ?></a></li>
                            <?php else: ?>
                            <li><a class="dropdown-item" href="<?php echo route('admin.languages.set', [$language["code"]]) ?>"><i data-feather="check"></i> <?php ee('Set as Default') ?></a></li>
                            <?php endif ?>
                            <li><a class="dropdown-item" href="<?php echo route('admin.languages.edit', [$language["code"]]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>                            
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.languages.delete', [$language["code"], \Core\Helper::nonce('language.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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
    <div class="card card-default">
      <div class="card-header"><?php ee('Languages') ?></div>
      <div class="card-body">
        <p><?php ee('You can translate all strings using this tool. By default, the english language is always included. The language selector will not show until you add another language and it will be located in the footer of the page. Language files are created in the storage/languages directory.') ?></p>
      </div>
    </div>
    <div class="card card-default">
      <div class="card-header"><?php ee('Download Language Files') ?></div>
      <div class="card-body">
        <p><?php ee('A list of available language files can be found on our website below.') ?></p>
        <a href="https://gempixel.com/products/url-shortener-script/languages" target="_blank" class="btn btn-xs btn-primary"><?php ee('Download') ?></a>
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
<div class="modal fade" id="uploadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="<?php echo route('admin.languages.upload') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Upload Language') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="file" class="form-label"><?php ee('Language File') ?></label>
                    <input type="file" class="form-control" name="file" id="file" value="" accept=".zip" placeholder="e.g. en.zip">
                    <p class="form-text"><?php ee('Upload the zip file that comes in the package. Usually it is named {LANGCODE}.zip. Please make sure the language respects the file structure.') ?></p>
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