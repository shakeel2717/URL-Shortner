<h1 class="h3 mb-5"><?php ee('Import Links') ?></h1>
<div class="row">
    <div class="col-md-6">        
        <div class="card">
            <div class="card-body">
                <p><?php ee('This tool allows you to import links from other software. You need to format the import file as CSV with the following structure. Note that this tool only imports links. It does not import statistics.') ?></p>

                <p><?php ee('When creating the CSV file, you need to keep the header but the column name can be anything as long as their position is respected. If the custom alias is taken, the importer will generate a random alias.') ?></p>
                <form method="post" action="<?php echo route('admin.links.import') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group">
                        <label for="file" class="form-label"><?php ee('CSV File') ?> (.csv)</label>
                        <input type="file" class="form-control" name="file" id="file" accept=".csv">
                    </div>

                    <div class="form-group mt-3">
                        <label for="user" class="form-label"><?php ee('User') ?></label>
                        <select name="user" id="user" class="form-control" data-toggle="select">
                            <option value="0">Public/Anonymous</option>
                            <?php foreach($users as $user): ?>
                                <option value="<?php echo $user->id ?>">#<?php echo $user->id ?>: <?php echo $user->email ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success mt-3"><?php ee('Import') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php ee('CSV Format') ?></h5>
                <pre class="bg-dark rounded p-3 text-white mt-3">longurl,alias,title,description</pre>

                <h5 class="card-title mt-3"><?php ee('Sample') ?></h5>
                <pre class="bg-dark rounded p-3 text-white mt-3">longurl,alias,title,description<br>https://google.com,google,Google,Google search engine</pre>
            </div>
        </div>
    </div>
</div>