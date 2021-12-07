<div class="container mt-5 mb-2" id="profile">    
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center  my-5">
            <?php if(isset($profiledata['avatar']) && $profiledata['avatar']): ?>
                <img src="<?php echo uploads($profiledata['avatar'], 'profile') ?>" class="rounded-circle mb-3" width="120" height="120">
            <?php else: ?>
                <img src="<?php echo $user->avatar() ?>" class="rounded-circle mb-3" width="120" height="120">
            <?php endif ?>
            <h3><span><?php echo $profile->name ?></span></h3></em>
            <div id="social" class="text-center mt-2">
                <?php foreach($profiledata['social'] as $key => $value): ?>
                    <?php if(empty($value)) continue ?>
                    <a href="<?php echo $value ?>" class="mx-2"><i class="fab fa-<?php echo $key ?>"></i></a>
                <?php endforeach ?>
            </div>
            <div id="content" class="mt-5">
                <?php foreach($urls as $url): ?>
                    <div class="item mb-3">
                        <a href="<?php echo \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>" class="btn btn-block btn-custom"><?php echo !empty($url->meta_title) ? $url->meta_title : $url->url ?></a>
                    </div>
                <?php endforeach ?>
                <?php echo simplePagination('btn-custom') ?>
            </div>
        </div>
    </div>
    <div class="text-center mt-8 opacity-8">
        <a class="navbar-brand" href="<?php echo route('home') ?>">
            <?php if(config('logo')): ?>
                <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" width="80" id="navbar-logo">
            <?php else: ?>                
                <h1 class="h5 mt-2"><?php echo config('title') ?></h1>
            <?php endif ?>
        </a>   
    </div>
</div>