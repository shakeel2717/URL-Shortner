<!DOCTYPE html>
<html lang="<?php echo \Core\Localization::locale() ?>"<?php echo \Core\Localization::get('rtl') ? 'dir="rtl"':''?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php meta() ?>
        <link rel="stylesheet" href="<?php echo assets('frontend/css/style'.(request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true) ? '-dark' : '').'.css') ?>" id="stylesheet">
        <?php block('header') ?>
        <?php echo html_entity_decode(config('customheader')) ?>
    </head>
    <body>
        <header id="header-main">            
            <nav class="navbar navbar-main navbar-expand-lg <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'navbar-light bg-white border-bottom', 'navbar-dark bg-dark') ?>" id="navbar-main">
                <div class="container-fluid">                    
                    <a class="navbar-brand" href="<?php echo route('home') ?>">
                        <?php if(config('logo')): ?>
                            <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                        <?php else: ?>
                            <h1 class="h5 mt-2 text-white"><?php echo config('title') ?></h1>
                        <?php endif ?>
                    </a>                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>                    
                    <div class="collapse navbar-collapse navbar-collapse-overlay" id="navbar-main-collapse">                        
                        <div class="position-relative">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <?php view('partials.main_menu') ?>
                    </div>
                </div>
            </nav>
        </header>
        <?php section() ?>
        <?php view('partials.footer') ?>
        
        <a href="#top" data-scroll-to data-scroll-to-offset="50" class="btn btn-white btn-icon-only rounded-circle position-fixed zindex-101 right-4 bottom-4 d-none d-lg-inline-flex">
            <span class="btn-inner--icon">
                <i data-feather="arrow-up"></i>
            </span>
        </a>
        <script src="<?php echo assets('bundle.pack.js') ?>"></script>   
        <?php block('footer') ?>
        <script src="<?php echo assets('frontend/js/app.js') ?>"></script>
        <script src="<?php echo assets('server.min.js') ?>"></script>  
        <script>
            feather.replace({
                'width': '1em',
                'height': '1em'
            })
        </script>
        <?php echo html_entity_decode(config('customfooter')) ?>
        <?php if(!empty(config('analytics'))): ?>
			<script async src='https://www.googletagmanager.com/gtag/js?id=<?php echo config('analytics') ?>'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '<?php echo config('analytics') ?>');</script>
		<?php endif ?>
    </body>
</html>
