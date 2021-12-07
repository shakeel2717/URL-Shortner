<section class="slice slice-lg py-7 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container d-flex align-items-center" data-offset-top="#navbar-main">
        <div class="col py-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 col-lg-7 text-center">
                    <h1 class="display-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> mb-2"><?php ee($page->name) ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="slice slice-lg pt-10 pb-5 bg-section-secondary">
    <div class="container pb-6">
        <div class="row row-grid align-items-center">
            <div class="col-md-12">
                <article>
                    <?php echo $page->content ?>
                </article>
            </div>
        </div>
    </div>
</section>