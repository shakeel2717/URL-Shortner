<!DOCTYPE html>
<html lang="<?php echo \Core\Localization::locale() ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php meta() ?>

        <link rel="preconnect" href="https://fonts.gstatic.com">

        <link href="<?php echo assets('backend/css/app.css') ?>" rel="stylesheet">
        <link href="<?php echo assets('frontend/libs/select2/dist/css/select2.min.css') ?>" rel="stylesheet">
        <link href="<?php echo assets('backend/css/style.min.css') ?>" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=<?php echo config('font') ? str_replace(' ', '+', ucwords(config('font'))) : 'Inter:wght@300;400;600' ?>&display=swap" rel="stylesheet">
        <?php echo html_entity_decode(config('customheader')) ?>
        <?php block('header') ?>
    </head>
    <body <?php echo request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true) ? 'class="dark"' : '' ?>>
        <?php $user = \Core\Auth::user() ?>
        <?php $notifications = \Helpers\App::notifications() ?>
        <div class="wrapper">
            <nav id="sidebar" class="sidebar">
                <div class="sidebar-content <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'sidebar-light', '') ?> js-simplebar">
                    <a class="sidebar-brand" href="<?php echo route('dashboard') ?>">
                        <?php if(config('logo')): ?>
                            <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" class="img-responsive w-50">
                        <?php else: ?>
                            <span class="align-middle"><?php echo config('title') ?></span>
                        <?php endif ?>
                        <small class="badge bg-primary fs-6">Admin</small>
                    </a>
                    <?php view('admin.partials.sidebar_menu', compact('user', 'notifications')) ?>
                </div>
            </nav>

            <div class="main">
                <nav class="navbar navbar-expand navbar-light navbar-bg">
                    <?php view('admin.partials.topbar_menu', compact('user', 'notifications')) ?>
                </nav>

                <main class="content">
                    <div class="container-fluid p-0">
                        <?php message() ?>
                        <?php section() ?>
                    </div>
                </main>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row text-muted">
                            <div class="col-6 text-start">
                                <p class="mb-0">
                                    <?php echo date('Y') ?> &copy; <a href="<?php echo route('home') ?>" class="text-muted"><strong><?php echo config('title') ?></strong></a>
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <ul class="list-inline">
                                    <?php foreach(\Helpers\App::pages() as $page): ?>
                                        <li class="list-inline-item">
                                            <a class="text-muted" href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a>
                                        </li>
                                    <?php endforeach ?>
                                    <?php if(config('api')): ?>
                                        <li class="list-inline-item">
                                            <a class="text-muted" href="<?php echo route('apidocs') ?>"><?php ee('Developer API') ?></a>
                                        </li>
                                    <?php endif ?>
                                    <?php if(config('report')): ?>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="<?php echo route('report') ?>"><?php ee('Report') ?></a>
                                    </li>
                                    <?php endif ?>
                                    <?php if(config('contact')): ?>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="<?php echo route('contact') ?>"><?php ee('Contact') ?></a>
                                    </li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script type="text/javascript">
            var lang = <?php echo json_encode([
                "del" => "Delete",
                "continue"  =>  e("Continue"),
                "cookie" => e("This website uses cookies to ensure you get the best experience on our website."),
                "cookieok" => e("Got it!"),
                "cookiemore" => e("Learn more"),
                "couponinvalid" => e("The coupon enter is not valid"),
                "minurl" => e("You must select at least 1 url."),
                "minsearch" => e("Keyword must be more than 3 characters!"),
                "modal" => [
                    "title" => e("Are you sure you want to proceed?"),
                    "proceed" => e("Proceed"),
                    "cancel" => e("Cancel"),
                    "close" => e("Close"),
                    "content" => e("Note that this action is permanent. Once you click proceed, you <strong>may not undo</strong> this. Click anywhere outside this modal or click <a href='#close' class='close-modal'>close</a> to close this.")
                ]]) ?>
        </script> 
        <script src="<?php echo assets('backend/js/app.js') ?>"></script>
        <script src="<?php echo assets('frontend/libs/jquery/dist/jquery.min.js') ?>"></script>
        <script src="<?php echo assets('frontend/libs/select2/dist/js/select2.min.js') ?>"></script> 
        <script src="<?php echo assets('frontend/libs/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>               
        <?php block('footer') ?>
        <script src="<?php echo assets('custom.js') ?>"></script>
    </body>
</html>