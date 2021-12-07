<div class="container">
    <div class="card shadow mt-7">
        <img src="<?php echo uploads($splash->data->banner) ?>" class="rounded w-100">
        <div class="card-body">
            <div class="d-flex flex-sm-row flex-column align-items-center">
                <div>
                    <img src="<?php echo uploads($splash->data->avatar) ?>" height="150" class="rounded">
                </div>
                <div class="ml-3">
                    <strong><?php echo $splash->data->title ?></strong>
                    <p class="mt-2"><?php echo $splash->data->message ?></p>
                    <p><a href="<?php echo $splash->data->product ?>" rel="nofollow" target="_blank" class='btn btn-primary btn-sm'><?php ee('View site') ?></a></p>
                </div>
                <div class="ml-auto ml-md-auto">
                    <p id="counter" class="text-center"><span class="display-4">0</span><br><?php ee('Seconds') ?></p>
                </div>
            </div>
        </div>
    </div>    
    <?php echo e('Powered by') ?> <a href="<?php echo config('url') ?>" class="font-weight-bold"><?php echo config('title') ?></a>      
</div>