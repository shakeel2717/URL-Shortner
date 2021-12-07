<h1 class="h3 mb-5"><?php ee('Backup/Restore Data') ?></h1>
<div class="row">
    <div class="col-md-6">        
        <div class="card">
            <div class="card-body">                            
                <h5 class="card-title fw-bold"><?php ee('Backup') ?></h5>
                <p><?php ee('This tool will generate a file that contains all of your data. It can be used to backup data and import it later. This feature can take some time, depending on the amount of data your database has. If your database is very large, we recommend that you do not use this tool or do not export the stats table. Do not attempt to use this tool otherwise your server will most likely timeout.') ?></p>                

                <form action="<?php echo route('admin.backup') ?>" method="post">
                    <?php echo csrf() ?>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="ads" checked>
                        <span class="form-check-label">ads</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="affiliates" checked>
                        <span class="form-check-label">affiliates</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="bundle" checked>
                        <span class="form-check-label">bundle</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="coupons" checked>
                        <span class="form-check-label">coupons</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="domains" checked>
                        <span class="form-check-label">domains</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="faqs" checked>
                        <span class="form-check-label">faqs</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="overlay" checked>
                        <span class="form-check-label">overlay</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="page" checked>
                        <span class="form-check-label">page</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="payment" checked>
                        <span class="form-check-label">payment</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="pixels" checked>
                        <span class="form-check-label">pixels</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="plans" checked>
                        <span class="form-check-label">plans</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="posts" checked>
                        <span class="form-check-label">posts</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="profiles" checked>
                        <span class="form-check-label">profiles</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="qrs" checked>
                        <span class="form-check-label">qr codes</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="reports" checked>
                        <span class="form-check-label">reports</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="settings" checked>
                        <span class="form-check-label">settings</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="splash" checked>
                        <span class="form-check-label">splash</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="stats" checked>
                        <span class="form-check-label">stats</span>
                    </label><br>
                    <?php if(\Helpers\App::isExtended()): ?>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="1" name="subscription" checked>
                            <span class="form-check-label">subscription</span>
                        </label><br>
                    <?php endif ?>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="url" checked>
                        <span class="form-check-label">url</span>
                    </label><br>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="user" checked>
                        <span class="form-check-label">user</span>
                    </label><br>
                    <button type="submit" class="btn btn-success mt-3"><?php ee('Backup') ?></button>
                </form>
            </div>
        </div>
    </div> 
    <div class="col-md-6">        
        <div class="card">
            <div class="card-body">                            
                <h5 class="card-title fw-bold"><?php ee('Restore Data') ?></h5>
                <p><?php ee('This tool will restore your data if you have a valid backup file generated by the backup tool. Please do not use this tool if the backup file is very large as your server will most likely timeout before restoring all data.') ?></p>
                <form method="post" action="<?php echo route('admin.restore') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group">
                        <label for="file" class="form-label"><?php ee('Backup File') ?> (.gem)</label>
                        <input type="file" class="form-control" name="file" id="file" accept=".gem">
                    </div>
                    <div class="alert alert-danger mt-3 p-2 rounded"><?php ee('Your existing data will be deleted and replaced with imported data. If you do not wish to delete your current data, please do not use this feature!') ?></div>                    
                    <button type="submit" class="btn btn-success mt-3"><?php ee('Restore') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>