<h1 class="h3 mb-5"><?php ee('Edit Domain') ?></h1>
<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo route('domain.update', [$domain->id]) ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="domain" class="form-label"><?php ee('Domain') ?></label>
                        <input type="text" class="form-control p-2" disabled value="<?php echo $domain->domain ?>" placeholder="https://domain.com">
                    </div>	
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="rootdomain" class="form-label"><?php ee('Domain Root') ?></label>
                        <input type="text" class="form-control p-2" name="root" id="rootdomain" value="<?php echo $domain->redirect ?>" placeholder="https://mycompany.com">
                        <div class="form-text"><?php ee('Redirects to this page if someone visits the root domain above without a short alias.') ?></div>
                    </div>	
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="root404" class="form-label"><?php ee('Domain 404') ?></label>
                        <input type="text" class="form-control p-2" name="root404" id="root404" value="<?php echo $domain->redirect404 ?>" placeholder="https://mycompany.com/404">
                        <div class="form-text"><?php ee('Redirects to this page if a short url is not found (error 404).') ?></div>
                    </div>	
                </div>                
            </div>
            
            <button type="submit" class="btn btn-primary"><?php ee('Update Domain') ?></button>
        </form>
    </div>
</div>