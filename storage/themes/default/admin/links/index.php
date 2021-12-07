<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php echo \Core\View::$title ?></h1>
    </div>
</div>
<div class="card flex-fill">
    <div class="card-header">
        <div class="d-flex">
            <div>
            </div>
            <div class="ms-auto">
                <select name="sortable" id="sortable" data-trigger="redirect" data-name="sort" data-toggle="select">
                  <optgroup label="Sort by">
                    <option value=""<?php if(!request()->sort) echo " selected" ?>><?php ee('Newest') ?></option>
                    <option value="old"<?php if(request()->sort == 'old') echo " selected" ?>><?php ee('Oldest') ?></option>
                    <option value="most"<?php if(request()->sort == 'most') echo " selected" ?>><?php ee('Most Popular') ?></option>
                    <option value="less"<?php if(request()->sort == 'less') echo " selected" ?>><?php ee('Less Popular') ?></option>       
                  </optgroup>
                </select>
            </div>
        </div>
    </div> 
    <div class="card-body h-100">
      <form method="post" action="" data-trigger="options">
        <?php echo csrf() ?>
        <input class="form-check-input me-2" type="checkbox" data-trigger="checkall">
        <input type="hidden" name="selected">
        <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
        <ul class="dropdown-menu">				
          <li><a class="dropdown-item" href="<?php echo route('admin.links.deleteall') ?>" data-trigger="submitchecked"><i data-feather="trash"></i> <?php ee('Delete All') ?></span></a></li>
        </ul> 
      </form>
      <hr>
        <?php foreach($urls as $url): ?>
            <?php view('admin.partials.links', compact('url')) ?>
        <?php endforeach ?>
        <?php echo pagination('pagination') ?>
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