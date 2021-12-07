<section class="slice slice-lg py-7 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container d-flex align-items-center" data-offset-top="#navbar-main">
        <div class="col py-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 col-lg-7 text-center">
                    <h1 class="display-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> mb-2"><?php ee('Blog') ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="slice pt-5 pb-7 bg-section-secondary">
    <div class="container masonry-container">
        <?php \Helpers\App::ads('resp') ?>
        <div class="row masonry">
            <?php foreach($posts as $post): ?>
                <?php view('partials.blog_post', compact('post')); ?>
            <?php endforeach ?>
        </div>
       <?php echo pagination('pagination', 'page-item', 'page-link') ?>
    </div>
</section>