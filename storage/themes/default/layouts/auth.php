<!DOCTYPE html>
<html lang="<?php echo \Core\Localization::locale() ?>"<?php echo \Core\Localization::get('rtl') ? 'dir=""':''?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php meta() ?>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="<?php echo assets('frontend/libs/select2/dist/css/select2.min.css') ?>">
        <link rel="stylesheet" href="<?php echo assets('frontend/css/style'.(request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true) ? '-dark' : '').'.css') ?>" id="stylesheet">
        <?php block('header') ?>
        <?php echo html_entity_decode(config('customheader')) ?>
    </head>
    <body<?php echo \Core\View::bodyClass() ?>>
        <?php section() ?>
        <script src="<?php echo assets('bundle.pack.js') ?>"></script>   
        <?php block('footer') ?>
        <script src="<?php echo assets('frontend/js/app.js') ?>"></script>
        <script src="<?php echo assets('custom.min.js') ?>"></script>
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
