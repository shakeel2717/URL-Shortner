<h1 class="h3 mb-5"><?php ee('New Advertisement') ?></h1>
<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.ads.save') ?>" enctype="multipart/form-data" data-trigger="codeeditor">
            <?php echo csrf() ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="name" class="form-label"><?php ee('Name') ?></label>
                        <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo old('name') ?>" placeholder="My Sample Ad">
                    </div>	
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="type" class="form-label"><?php ee('Ad Type/Placement') ?></label>
                        <select name="type" id="type" class="form-control" data-toggle="select">
                            <?php foreach(\Helpers\App::adType() as $id => $type): ?>
                                <option value="<?php echo $id ?>"><?php echo $type["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="code" class="form-label"><?php ee('Ad Code') ?></label>
                <div id="code-editor"><?php echo old('code') ?></div>
                <textarea class="d-none" id="code" name="code"></textarea>
            </div>	        		            		
            <hr>			              					  			
            <div class="form-group">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" data-binary="true" id="enabled" name="enabled" value="1" checked>
                    <label class="form-check-label" for="enabled"><?php ee('Enabled') ?></label>
                </div>
                <p class="form-text"><?php ee('Do you want to enable this ad unit?') ?></p>
            </div>
            <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Advertisement') ?></button>
        </form>
    </div>
</div>