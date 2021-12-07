<h1 class="h3 mb-5"><?php ee('User Testimonials') ?></h1>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.testimonial.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
                        <label for="name" class="form-label"><?php ee('Name') ?></label>
                        <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo old('name') ?>" placeholder="E.g John Doe" required>
                    </div>  
                    <div class="form-group mb-4">
                        <label for="email" class="form-label"><?php ee('Email') ?></label>
                        <input type="text" class="form-control p-2" name="email" id="email" value="<?php echo old('email') ?>" placeholder="E.g johndoe@apple.com">
                        <p class="form-text"><?php ee("If the email is provided, gravatar will be used to display the user's avatar.") ?></p>
                    </div>
                    <div class="form-group mb-4">
                        <label for="job" class="form-label"><?php ee('Job Title') ?></label>
                        <input type="text" class="form-control p-2" name="job" id="job" value="<?php echo old('job') ?>" placeholder="E.g Web Developer">
                        <p class="form-text"><?php ee("User's title or company") ?></p>
                    </div>                    
                    <div class="form-group mb-4">
                        <label for="testimonial" class="form-label"><?php ee('Testimonial') ?></label>
                        <textarea name="testimonial" id="testimonial" class="form-control"><?php echo old('testimonial') ?></textarea>
                    </div>		                                         
                    <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Testimonial') ?></button>
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
                            <th><?php ee('User') ?></th>
                            <th width="70%"><?php ee('Testimonial') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($testimonials as $id => $testimonial): ?>
                            <tr>
                                <td><?php echo $testimonial->email ? '<img src="https://www.gravatar.com/avatar/'.md5(trim($testimonial->email)).'?s=30&d=identicon" class="rounded-circle" width="30">': '' ?> <?php echo $testimonial->name ?> <?php echo $testimonial->job  ? "({$testimonial->job})" : "" ?></td>
                                <td><?php echo $testimonial->testimonial ?></td>
                                <td>
                                    <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.testimonial.delete', [$id+1, \Core\Helper::nonce('testimonial.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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