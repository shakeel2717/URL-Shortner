<div class="masonry-item col-xl-4 col-md-6">
    <div class="card hover-translate-y-n3 hover-shadow-lg overflow-hidden">
        <?php if($post->image): ?>
            <div class="position-relative overflow-hidden">
                <a href="<?php echo route('blog.post', $post->slug) ?>" class="d-block">
                    <img alt="<?php echo $post->title ?>" src="<?php echo uploads($post->image, 'blog') ?>" class="card-img-top">
                </a>
            </div>
        <?php endif ?>
        <div class="card-body py-4">
            <small class="d-block text-sm mb-2"><?php echo $post->date ?></small>
            <a href="<?php echo route('blog.post', $post->slug) ?>" class="h5 stretched-link lh-150"><?php echo $post->title ?></a>
            <p class="mt-3 mb-0 lh-170"><?php echo $post->content ?></p>
        </div>
        <div class="card-footer border-0 delimiter-top">
            <div class="row align-items-center">
                <div class="col-auto">
                    <?php if($post->avatar): ?>
                        <img alt="<?php echo $post->title ?>" src="<?php echo $post->avatar ?>" width="30" class="rounded-circle mr-2">
                    <?php else: ?>
                        <span class="avatar avatar-sm bg-primary rounded-circle"><?php echo $post->author[0] ?></span>
                    <?php endif ?>
                    <span class="text-sm mb-0 avatar-content"><?php echo $post->author ?></span>
                </div>
            </div>
        </div>
    </div>
</div>  