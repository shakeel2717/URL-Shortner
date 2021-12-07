<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-body">
                <div class="embed">
                    <?php echo $url->embed ?>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-9">
                        <h6><?php echo $url->meta_title ?></h6>
                    </div>
                    <div class="col-sm-3 text-right">
                        <span><?php echo $url->click+1 ?></span>
                        <?php echo e("Views") ?>
                    </div>						
                </div>
                <p class="mt-2">
                    <?php echo $url->meta_description ?>				
                </p>					
            </div>
            <?php echo \Helpers\App::ads(728) ?>
        </div>
        <div class="col-md-4">
            <?php echo \Helpers\App::ads(300) ?>
            <div class="card card-body">
                <h6><?php echo e("Short URL") ?></h6>
                <input type="text" class="form-control" value="<?php echo \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>" readonly>
                <br>
                <a href="#copy" class="btn btn-primary copy" data-clipboard-text="<?php echo \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><?php echo e("Copy") ?></a>
                <?php if(config("sharing")): ?>
                    <hr>
                    <p>
                        <a href="https://www.facebook.com/sharer.php?u=<?php echo \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>" class="btn btn-facebook btn-block"><?php echo e("Share on") ?> Facebook</a></p>
                    <p><a href="https://twitter.com/share?url=<?php echo \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>&amp;text=Check+out+this+url" class="btn btn-twitter btn-block"><?php echo e("Share on") ?> Twitter</a>
                    </p>
                <?php endif ?>					
            </div>
        </div>				
    </div>
</div>