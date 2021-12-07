<!DOCTYPE html>
<html lang="<?php echo \Core\Localization::locale() ?>" <?php echo \Core\Localization::get('rtl') ? 'dir="rtl"' : '' ?>>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php meta() ?>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets('frontend/libs/select2/dist/css/select2.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo assets('cookieconsent.min.css') ?>">
    <link rel="stylesheet" href="<?php echo assets('frontend/css/style' . (request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true) ? '-dark' : '') . '.min.css') ?>" id="stylesheet">
    <script>
        var appurl = '<?php echo url() ?>';
    </script>
    <?php echo html_entity_decode(config('customheader')) ?>
    <?php block('header') ?>
</head>

<body>
    <header class="header-transparent" id="header-main">
        <nav class="navbar navbar-main navbar-expand-lg <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'navbar-light bg-white', 'navbar-dark bg-dark') ?>" id="navbar-main">
            <div class="container">
                <a class="navbar-brand" href="<?php echo route('home') ?>">
                    <?php if (config('logo')) : ?>
                        <div class="d-flex align-items-center bg-light p-2 rounded">
                            <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                            <h2 class="ml-3 pt-2">TSBOI</h2>
                        </div>
                    <?php else : ?>
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

    <script src="<?php echo assets('bundle.pack.js') ?>"></script>
    <?php if (config('cookieconsent')->enabled) : ?>
        <script src="<?php echo assets('cookieconsent.min.js') ?>"></script>
    <?php endif ?>
    <?php block('footer') ?>
    <script type="text/javascript">
        var lang = <?php echo json_encode([
                        "error" => e('Please enter a valid URL.'),
                        "cookie" => !empty(config('cookieconsent')->message) ? e(config('cookieconsent')->message) : e("This website uses cookies to ensure you get the best experience on our website."),
                        "cookieok" => e("Got it!"),
                        "cookiemore" => e("Learn more"),
                        "cookielink" => !empty(config('cookieconsent')->link) ? config('cookieconsent')->link : route('page', ['terms']),
                        "couponinvalid" => e("The coupon enter is not valid"),
                        "minurl" => e("You must select at least 1 url."),
                        "minsearch" => e("Keyword must be more than 3 characters!"),
                        "nodata" => e("No data is available for this request."),
                        "datepicker" => [
                            '7d' => 'Last 7 Days',
                            '3d' => 'Last 30 Days',
                            'tm' => 'This Month',
                            'lm' => 'Last Month',
                        ]
                    ]) ?>
    </script>
    <script>
        feather.replace({
            'width': '1em',
            'height': '1em'
        })
    </script>
    <script src="<?php echo assets('frontend/js/app.min.js') ?>"></script>
    <script src="<?php echo assets('server.min.js') ?>"></script>
    <?php echo html_entity_decode(config('customfooter')) ?>
    <?php if (!empty(config('analytics'))) : ?>
        <script async src='https://www.googletagmanager.com/gtag/js?id=<?php echo config('analytics') ?>'></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?php echo config('analytics') ?>');
        </script>
    <?php endif ?>
</body>

</html>