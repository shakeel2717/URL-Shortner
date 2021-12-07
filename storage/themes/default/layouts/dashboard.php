<!DOCTYPE html>
<html lang="<?php echo \Core\Localization::locale() ?>" <?php echo \Core\Localization::get('rtl') ? 'dir="rtl"' : '' ?>>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php meta() ?>

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="<?php echo assets('backend/css/app.css') ?>" rel="stylesheet">
    <link href="<?php echo assets('frontend/libs/select2/dist/css/select2.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="<?php echo assets('backend/css/style.min.css') ?>" rel="stylesheet">
    <?php if (config('font')) : ?>
        <link href="https://fonts.googleapis.com/css2?family=<?php echo config('font') ?>:wght@300;400;600&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: '<?php echo config('font') ?>' !important
            }
        </style>
    <?php else : ?>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <?php endif ?>
    <?php echo html_entity_decode(config('customheader')) ?>
    <?php block('header') ?>
</head>
<body<?php echo request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true) ? ' class="dark"' : '' ?>>
    <?php $user = \Core\Auth::user() ?>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-content <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'sidebar-light', '') ?> js-simplebar">
                <a class="sidebar-brand" href="<?php echo route('home') ?>">
                    <?php if (config('logo')) : ?>
                        <div class="d-flex align-items-center bg-light p-2 rounded">
                            <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" class="img-responsive w-25">
                            <h2 class="ml-3 pt-2">TSBOI</h2>

                        </div>
                    <?php else : ?>
                        <span class="align-middle"><?php echo config('title') ?></span>
                    <?php endif ?>
                </a>
                <?php view('partials.sidebar_menu', compact('user')) ?>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <?php view('partials.topbar_menu', compact('user')) ?>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">
                    <?php \Helpers\App::ads('resp') ?>
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
                                <?php foreach (\Helpers\App::pages() as $page) : ?>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a>
                                    </li>
                                <?php endforeach ?>
                                <?php if (config('api')) : ?>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="<?php echo route('apidocs') ?>"><?php ee('Developer API') ?></a>
                                    </li>
                                <?php endif ?>
                                <?php if (config('report')) : ?>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="<?php echo route('report') ?>"><?php ee('Report') ?></a>
                                    </li>
                                <?php endif ?>
                                <?php if (config('contact')) : ?>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="<?php echo route('contact') ?>"><?php ee('Contact') ?></a>
                                    </li>
                                <?php endif ?>
                                <?php if ($langs = \Helpers\App::langs()) : ?>
                                    <li class="list-inline-item dropup">
                                        <a class="text-muted" data-bs-toggle="dropdown" href="#"><i data-feather="globe" class="me-1"></i> <?php echo strtoupper(\Core\Localization::locale()) ?></a>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($langs  as $lang) : ?>
                                                <li><a class="dropdown-item" href="?lang=<?php echo $lang['code'] ?>"><?php echo $lang['name'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?php echo assets('backend/js/app.js') ?>"></script>
    <script src="<?php echo assets('frontend/libs/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?php echo assets('frontend/libs/select2/dist/js/select2.min.js') ?>"></script>
    <script src="<?php echo assets('frontend/libs/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>
    <?php block('footer') ?>
    <script type="text/javascript">
        var lang = <?php echo json_encode([
                        "error" => e('Please enter a valid URL.'),
                        "imageerror" => e('The selected image is not valid. Please select a jpg or png with a maximum size of 1mb'),
                        "del" => "Delete",
                        "continue"  =>  e("Continue"),
                        "cookie" => e("This website uses cookies to ensure you get the best experience on our website."),
                        "cookieok" => e("Got it!"),
                        "cookiemore" => e("Learn more"),
                        "couponinvalid" => e("The coupon enter is not valid"),
                        "minurl" => e("You must select at least 1 url."),
                        "minsearch" => e("Keyword must be more than 3 characters!"),
                        "nodata" => e("No data is available for this request."),
                        "modal" => [
                            "title" => e("Are you sure you want to proceed?"),
                            "proceed" => e("Proceed"),
                            "cancel" => e("Cancel"),
                            "close" => e("Close"),
                            "content" => e("Note that this action is permanent. Once you click proceed, you <strong>may not undo</strong> this. Click anywhere outside this modal or click <a href='#close' class='close-modal'>close</a> to close this.")
                        ]
                    ]) ?>
    </script>
    <script src="<?php echo assets('custom.min.js') ?>"></script>
    <script src="<?php echo assets('server.min.js') ?>"></script>
    <?php echo html_entity_decode(config('customfooter')) ?>
    </body>

</html>