<h1 class="h3 mb-5"><?php ee('New Domain') ?></h1>
<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.domains.save') ?>" enctype="multipart/form-data" data-trigger="codeeditor">
            <?php echo csrf() ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="domain" class="form-label"><?php ee('Domain') ?></label>
                        <input type="text" class="form-control p-2" name="domain" id="domain" value="<?php echo old('domain') ?>" placeholder="https://domain.com">
                    </div>	
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4 input-select">
                        <label for="user" class="form-label"><?php ee('Assign to User') ?></label>
                        <select name="user" id="user" class="form-control p-2" data-toggle="select">
                            <?php foreach($users as $user): ?>
                                <option value="<?php echo $user->id ?>"><?php echo $user->id ?> - <?php echo $user->email ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4 input-select">
                        <label for="status" class="form-label"><?php ee('Status') ?></label>
                        <select name="status" id="status" class="form-control p-2" data-toggle="select">
                            <option value="0"><?php ee('Disabled') ?></option>
                            <option value="1" selected><?php ee('Active') ?></option>
                            <option value="2"><?php ee('Pending DNS') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="root" class="form-label"><?php ee('Domain Root') ?></label>
                        <input type="text" class="form-control p-2" name="root" id="root" value="<?php echo old('root') ?>" placeholder="https://mycompany.com">
                    </div>	
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="root404" class="form-label"><?php ee('Domain 404') ?></label>
                        <input type="text" class="form-control p-2" name="root404" id="root404" value="<?php echo old('root404') ?>" placeholder="https://mycompany.com/404">
                    </div>	
                </div>                
            </div>
            
            <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Domain') ?></button>
        </form>
    </div>
</div>