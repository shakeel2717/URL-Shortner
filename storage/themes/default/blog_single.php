<section class="slice slice-lg pt-17 pb-0 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <?php if($post->image): ?>
                    <div class="position-relative top-3 overflow-hidden">
                        <a href="<?php echo route('blog.post', $post->slug) ?>" class="d-block">
                            <img alt="<?php echo $post->title ?>" src="<?php echo uploads($post->image, 'blog') ?>" class="card-img-top">
                        </a>
                    </div>
                <?php endif ?>                 
                <div class="card mb-n7 position-relative zindex-100">                                       
                    <div class="card-body p-md-5">
                        <div class=" text-center">
                            <h1 class="h2 lh-150 mt-3 mb-0"><?php echo $post->title ?></h1>
                        </div>
                        <div class="row align-items-center mt-5 pt-5 delimiter-top">
                            <div class="col mb-3 mb-lg-0">
                                <div class="media align-items-center">
                                    <img src="<?php echo $post->avatar ?>" alt="<?php echo $post->author ?>" class="avatar text-white rounded-circle mr-3">
                                    <div class="media-body">
                                        <span class="d-block h6 mb-0"><?php echo $post->author ?></span>
                                        <span class="text-sm text-muted"><?php ee('Published on') ?> <?php echo $post->date ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shape-container shape-position-bottom">
        <svg width="2560px" height="100px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none" x="0px" y="0px" viewBox="0 0 2560 100" style="enable-background:new 0 0 2560 100;" xml:space="preserve" class="">
            <polygon points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</section>

<section class="slice slice-lg pt-10 pb-5">

    <div class="container pb-6">
        <div class="row row-grid align-items-center">
            <div class="col-xl-8 col-lg-10 offset-xl-2 offset-lg-1">
                <?php \Helpers\App::ads('resp') ?>
                <article>
                    <?php echo $post->content ?>
                </article>
            </div>
        </div>
    </div>
</section>

<?php if($posts): ?>
<section class="slice slice-lg bg-section-secondary">
    <div class="container">
        <?php \Helpers\App::ads('resp') ?>
        <div class="row align-items-center mb-5">
            <div class="col-12 col-md">
                <h3 class="h4 mb-0"><?php ee('Keep reading') ?></h3>
                <p class="mb-0 text-muted"><?php ee('More posts from our blog') ?></p>
            </div>
            <div class="col-12 col-md-auto">
                <a href="<?php echo route('blog') ?>" class="btn btn-sm btn-neutral d-none d-md-inline"><?php ee("View all") ?></a>
            </div>
        </div>
        <!-- Posts -->
        <div class="row">
            <?php foreach($posts as $post): ?>
                <?php $post->content = null; view('partials.blog_post',['post' => $post]); ?>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>