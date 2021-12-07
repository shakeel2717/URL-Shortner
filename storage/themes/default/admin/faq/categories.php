<h1 class="h3 mb-5"><?php ee('FAQ Categories') ?></h1>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.faq.categories.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
                        <label for="title" class="form-label"><?php ee('Title') ?></label>
                        <input type="text" class="form-control p-2" name="title" id="title" value="<?php echo old('title') ?>" placeholder="My Sample Category" required>
                    </div>                    
                    <div class="form-group mb-4">
                        <label for="description" class="form-label"><?php ee('Short Description') ?></label>
                        <textarea name="description" id="description" class="form-control"><?php echo old('description') ?></textarea>
                    </div>		                                         
                    <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Category') ?></button>
                </form>
            </div>
        </div>     
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Category') ?></th>
                            <th><?php ee('Description') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $id => $category): ?>
                            <tr>
                                <td><?php echo $category->title ?></td>
                                <td><?php echo $category->description?:e('none') ?></td>
                                <td>
                                    <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo route('admin.faq.categories.update', [$id]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#updateModal" data-toggle="updateFormContent" data-content='<?php echo json_encode(['newtitle' => $category->title, 'newdescription' => $category->description]) ?>'><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.faq.categories.delete', [$id, \Core\Helper::nonce('category.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="#" method="post">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Edit Category') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="newtitle" class="form-label"><?php ee('Title') ?></label>
                    <input type="text" class="form-control p-2" name="newtitle" id="newtitle" value="" placeholder="My Sample Category" required>
                </div>                    
                <div class="form-group mb-4">
                    <label for="newdescription" class="form-label"><?php ee('Short Description') ?></label>
                    <textarea name="newdescription" id="newdescription" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Update Category') ?></button>
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