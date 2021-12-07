<h1 class="h3 mb-5"><?php ee('Custom Code') ?></h1>
<form method="post" action="<?php echo route('admin.themes.custom.update') ?>" enctype="multipart/form-data" data-trigger="codeeditor">    
    <?php echo csrf() ?>   
    <div class="row">
        <div class="col-md-6">
            <div class="card card-editor">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <?php ee('Custom CSS/JS (Header)') ?>
                            <p class="form-text mt-2"><?php ee('You can code (CSS/JS) and it will be output in the header region of the page before &lt;/head&gt;') ?></p>
                        </div>            
                    </div>
                </div>        
                <div class="form-group mb-4">
                    <div id="customheader"><?php echo config('customheader') ?></div>
                    <textarea class="d-none" id="customhead" name="customheader"></textarea>                     
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-primary"><?php ee('Update') ?></button>
                </div>                 
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-editor">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <?php ee('Custom JS (Footer)') ?>
                            <p class="form-text mt-2"><?php ee('You can add JS/HTML and the code will be output in the footer region of the page before &lt;/body&gt;') ?></p>
                        </div>            
                    </div>
                </div>        
                <div class="form-group mb-4">
                    <div id="customfooter"><?php echo config('customfooter') ?></div>
                    <textarea class="d-none" id="customfoot" name="customfooter"></textarea>                    
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-primary"><?php ee('Update') ?></button>
                </div>                 
            </div>
        </div>
    </div>           
</form>