<h1 class="h3 mb-5"><?php ee('Edit Domain') ?></h1>
<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.domains.update', [$domain->id]) ?>" enctype="multipart/form-data" data-trigger="codeeditor">
            <?php echo csrf() ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="domain" class="form-label"><?php ee('Domain') ?></label>
                        <input type="text" class="form-control p-2" name="domain" id="domain" value="<?php echo $domain->domain ?>" placeholder="https://domain.com">
                    </div>	
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="user" class="form-label"><?php ee('Assign to User') ?></label>
                        <select name="user" id="user" class="form-control p-2" data-toggle="select">
                            <?php foreach($users as $user): ?>
                                <option value="<?php echo $user->id ?>" <?php echo $user->id == $domain->userid ? 'selected': '' ?>><?php echo $user->id ?> - <?php echo $user->email ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="status" class="form-label"><?php ee('Status') ?></label>
                        <select name="status" id="status" class="form-control p-2" data-toggle="select">
                            <option value="0" <?php echo $domain->status == '0' ? 'selected' : '' ?>><?php ee('Disabled') ?></option>
                            <option value="1" <?php echo $domain->status == '1' ? 'selected' : '' ?>><?php ee('Active') ?></option>
                            <option value="2" <?php echo $domain->status == '2' ? 'selected' : '' ?>><?php ee('Pending DNS') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="root" class="form-label"><?php ee('Domain Root') ?></label>
                        <input type="text" class="form-control p-2" name="root" id="root" value="<?php echo $domain->redirect ?>" placeholder="https://mycompany.com">
                    </div>	
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="root404" class="form-label"><?php ee('Domain 404') ?></label>
                        <input type="text" class="form-control p-2" name="root404" id="root404" value="<?php echo $domain->redirect404 ?>" placeholder="https://mycompany.com/404">
                    </div>	
                </div>                
            </div>
            
            <button type="submit" class="btn btn-primary"><?php ee('Update Domain') ?></button>
        </form>
    </div>
</div>