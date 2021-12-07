<h1 class="h3 mb-5"><?php ee('Coupons') ?></h1>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.coupons.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
                        <label for="name" class="form-label"><?php ee('Name') ?></label>
                        <input type="text" class="form-control p-2" name="name" id="name" value="" placeholder="My Sample Coupon" required>
                    </div>                    
                    <div class="form-group mb-4">
                        <label for="description" class="form-label"><?php ee('Description') ?></label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="code" class="form-label"><?php ee('Promo Code') ?></label>
                        <input type="text" class="form-control p-2" name="code" id="code" value="" placeholder="e.g. SAVE20" required>
                    </div> 
                    <div class="form-group mb-4">
                        <label for="discount" class="form-label"><?php ee('Discount Percentage') ?></label>
                        <input type="number" class="form-control p-2" name="discount" id="discount" value="" max="100" min="1" placeholder="e.g. 20" required>
                    </div> 
                    <div class="form-group mb-4">
                        <label for="validuntil" class="form-label"><?php ee('Valid Until') ?></label>
                        <input type="text" class="form-control p-2" data-toggle="datetimepicker" name="validuntil" id="validuntil" value="" placeholder="e.g. 01-01-2020" required>
                    </div> 		                                         
                    <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Coupon') ?></button>
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
                            <th><?php ee('Coupon Name') ?></th>
                            <th><?php ee('Coupon Code') ?></th>
                            <th><?php ee('Discount') ?></th>
                            <th><?php ee('Valid Until') ?></th>
                            <th><?php ee('Used') ?></th>
                            <th></th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($coupons as $coupon): ?>
                            <tr>
                                <td><?php echo $coupon->name ?></td>
                                <td><span class="badge bg-primary"><?php echo $coupon->code ?></span></td>
                                <td><?php echo $coupon->discount ?>% OFF</td>
                                <td><?php echo $coupon->validuntil ? date("d-m-Y", strtotime($coupon->validuntil)) : "N/A"?></td>
                                <td><?php echo $coupon->used ?> times</td>
                                <td>
                                    <button type="button" class="btn btn-default shadow-lg bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo route('admin.coupons.update', [$coupon->id]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#updateModal" data-toggle="updateFormContent" data-content='<?php echo json_encode(['newname' => $coupon->name,'newdescription' => $coupon->description, 'newvaliduntil' => \Core\Helper::dtime($coupon->validuntil, 'Y-m-d')]) ?>'><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.coupons.delete', [$coupon->id, \Core\Helper::nonce('coupon.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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
                <h5 class="modal-title"><?php ee('Edit Coupon') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="newname" class="form-label"><?php ee('Name') ?></label>
                    <input type="text" class="form-control p-2" name="newname" id="newname" value="" placeholder="My Sample Coupon" required>
                </div>                    
                <div class="form-group mb-4">
                    <label for="newdescription" class="form-label"><?php ee('Description') ?></label>
                    <textarea name="newdescription" id="newdescription" class="form-control"></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="newvaliduntil" class="form-label"><?php ee('Valid Until') ?></label>
                    <input type="text" class="form-control p-2" data-datepicker name="newvaliduntil" id="newvaliduntil" value="" placeholder="e.g. 01-01-2020" required>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Update Coupon') ?></button>
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