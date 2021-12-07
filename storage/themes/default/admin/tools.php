<h1 class="h3 mb-5"><?php ee('Removal Tools') ?></h1>
<div class="row">
    <div class="col-md-4">        
        <div class="card">
            <div class="card-body">                            
                <h5 class="card-title fw-bold"><?php ee('Remove Anonymous Links') ?></h5>
                <p><?php ee('This tool deletes all URLs (and their associated stats) shortened by anonymous users (non-registered). If you are experiencing slow response, this is recommended. You can also choose a date to remove all anon links before.') ?></p>                

                <form action="<?php echo route('admin.toolsAction', ['flushurls', \Core\Helper::nonce('tools')]) ?>" method="get">
                    <div class="form-group mb-2">
                        <label for="date" class="form-label"><?php ee('Remove Links Before') ?></label>
                        <input type="text" data-toggle ="datepicker" class="form-control" id="date" name="date" placeholder="Leave empty to remove all urls" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-danger"><?php ee('Remove links') ?></button>
                </form>
            </div>
        </div>
    </div> 
    <div class="col-md-4">        
        <div class="card">
            <div class="card-body">                            
                <h5 class="card-title fw-bold"><?php ee('Delete Inactive links') ?></h5>
                <p><?php ee('This tool deletes links that did not receive any clicks in the last 30 days. It can free up some resource in your database.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['deleteurls', \Core\Helper::nonce('tools')]) ?>" class="btn btn-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" ><?php ee('Delete') ?></a>
            </div>
        </div>
    </div>   
    <div class="col-md-4">        
        <div class="card">
            <div class="card-body">                            
                <h5 class="card-title fw-bold"><?php ee('Delete Inactive Users') ?></h5>
                <p><?php ee('This tool deletes users who registered but did not activate their account. This can be users attempting to use fake emails or even spammers.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['deleteusers', \Core\Helper::nonce('tools')]) ?>" class="btn btn-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" ><?php ee('Delete') ?></a>
            </div>
        </div>
    </div>     
</div>
<hr>
<h1 class="h3 mb-5"><?php ee('Export Tools') ?></h1>
<div class="row">
    <div class="col-md-4">        
        <div class="card">
            <div class="card-body">                            
                <h5 class="card-title fw-bold"><?php ee('Export Links') ?></h5>
                <p><?php ee('This tool allows you to generate a list of urls in CSV format. Some basic data such clicks will be included as well.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['exporturls', \Core\Helper::nonce('tools')]) ?>" class="btn btn-success"><?php ee('Export') ?></a>
            </div>
        </div>
    </div>   
    <div class="col-md-4">        
        <div class="card">
            <div class="card-body">                            
                <h5 class="card-title fw-bold"><?php ee('Export Users') ?></h5>
                <p><?php ee('This tool allows you to generate a list of users in CSV format. You can then import that in the email marketing tools.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['exportusers', \Core\Helper::nonce('tools')]) ?>" class="btn btn-success"><?php ee('Export') ?></a>
            </div>
        </div>
    </div> 
    <div class="col-md-4">        
        <div class="card">
            <div class="card-body">                            
                <h5 class="card-title fw-bold"><?php ee('Export Payments') ?></h5>
                <p><?php ee('This tool allows you to generate a list of payments in CSV format. You can then import that in your accounting tools.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['exportpayments', \Core\Helper::nonce('tools')]) ?>" class="btn btn-success"><?php ee('Export') ?></a>
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