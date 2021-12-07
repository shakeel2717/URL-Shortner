<ul class="sidebar-nav">
    <li class="sidebar-item active">
        <a class="sidebar-link" href="<?php echo route('admin') ?>">
            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle"><?php ee('Dashboard') ?></span>
        </a>
    </li>    
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-urls" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="link"></i> <span class="align-middle"><?php ee('Links') ?></span>
        </a>
        <ul id="nav-urls" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links') ?>"><?php ee('All Links') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links.expired') ?>"><?php ee('Expired Links') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links.archived') ?>"><?php ee('Archived Links') ?></a></li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?php echo route('admin.links.report') ?>"><?php ee('Reported Links') ?>
                    <?php if($notifications['data']['reports']['count']): ?>
                        <span class="sidebar-badge badge bg-primary"><?php echo $notifications['data']['reports']['count'] ?></span>
                    <?php endif ?>
                </a>        
            </li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links.pending') ?>"><?php ee('Pending Links') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links.import') ?>"><?php ee('Import Links') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-users" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="users"></i> <span class="align-middle"><?php ee('Users') ?></span>
        </a>
        <ul id="nav-users" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.new') ?>"><?php ee('Add User') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users') ?>"><?php ee('All Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.inactive') ?>"><?php ee('Inactive Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.banned') ?>"><?php ee('Banned Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.admin') ?>"><?php ee('Admin Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.testimonial') ?>"><?php ee('Testimonials') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-card" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle"><?php ee('Memberships') ?></span>
        </a>
        <ul id="nav-card" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.plans') ?>"><?php ee('Plans') ?></a></li>
            <?php if(\Helpers\App::isExtended()): ?>
                <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.subscriptions') ?>"><?php ee('Subscriptions') ?></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.coupons') ?>"><?php ee('Coupons') ?></a></li>
            <?php endif ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.payments') ?>"><?php ee('Payments') ?></a></li>
        </ul>
    </li>    
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-blog" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="book"></i> <span class="align-middle"><?php ee('Blog') ?></span>
        </a>
        <ul id="nav-blog" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.blog.new') ?>"><?php ee('Add Post') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.blog') ?>"><?php ee('All Posts') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-pages" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="file-text"></i> <span class="align-middle"><?php ee('Pages') ?></span>
        </a>
        <ul id="nav-pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.page.new') ?>"><?php ee('Add Page') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.page') ?>"><?php ee('All Pages') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-domain" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="globe"></i> <span class="align-middle"><?php ee('Domains') ?></span>
        </a>
        <ul id="nav-domain" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.domains.new') ?>"><?php ee('Add Domain') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.domains') ?>"><?php ee('All Domains') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-faqs" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="help-circle"></i> <span class="align-middle"><?php ee('FAQs') ?></span>
        </a>
        <ul id="nav-faqs" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.faq.new') ?>"><?php ee('Add FAQ') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.faq') ?>"><?php ee('All FAQs') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.faq.categories') ?>"><?php ee('FAQ Categories') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-aff" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="percent"></i> <span class="align-middle"><?php ee('Affiliates') ?></span>
        </a>
        <ul id="nav-aff" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.affiliate.payments') ?>"><?php ee('Payments') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.affiliate') ?>"><?php ee('Referrals & Settings') ?></a></li>
        </ul>
    </li> 
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" href="<?php echo route('admin.ads') ?>">
            <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle"><?php ee('Advertisement') ?></span>
        </a>
    </li>   
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-theme" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="eye"></i> <span class="align-middle"><?php ee('Themes') ?></span>
        </a>
        <ul id="nav-theme" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.themes') ?>"><?php ee('Themes') ?></a></li>
            <?php if(\Core\View::config('settings')): ?>
                <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.themes.settings') ?>"><?php ee('Settings') ?></a></li>
            <?php endif ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.themes.editor') ?>"><?php ee('Editor') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.themes.custom') ?>"><?php ee('Custom CSS/JS') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" href="<?php echo route('admin.languages') ?>">
            <i class="align-middle" data-feather="flag"></i> <span class="align-middle"><?php ee('Languages') ?></span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-plugin" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="server"></i> <span class="align-middle"><?php ee('Plugins') ?></span>
        </a>
        <ul id="nav-plugin" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.plugins') ?>"><?php ee('All Plugins') ?></span></a></li>
            <?php plug('adminmenu') ?>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-setting" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="settings"></i> <span class="align-middle"><?php ee('Settings') ?></span>
        </a>
        <ul id="nav-setting" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings') ?>"><?php ee('General Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['app']) ?>"><?php ee('Application Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['link']) ?>"><?php ee('Link Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['advanced']) ?>"><?php ee('Advanced Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['theme']) ?>"><?php ee('Themes Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['security']) ?>"><?php ee('Security Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['membership']) ?>"><?php ee('Membership Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['payments']) ?>"><?php ee('Payment Gateway') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['users']) ?>"><?php ee('Users Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['mail']) ?>"><?php ee('Mail Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['integrations']) ?>"><?php ee('Integrations') ?></a></li>
        </ul>
    </li>    
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-tool" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="tool"></i> <span class="align-middle"><?php ee('Tools & Emails') ?></span>
        </a>
        <ul id="nav-tool" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.tools') ?>"><?php ee('All Tools') ?></a></li>        
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.email') ?>"><?php ee('Send Email') ?></a></li>        
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.email.template') ?>"><?php ee('Email Templates') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.data') ?>"><?php ee('Backup/Restore Data') ?></a></li>
        </ul>
    </li>    
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('admin.stats') ?>">
            <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle"><?php ee('Statistics') ?></span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('admin.crons') ?>">
            <i class="align-middle" data-feather="terminal"></i> <span class="align-middle"><?php ee('Cron Jobs') ?></span>
        </a>
    </li>    
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route("admin.update") ?>">
            <i class="align-middle" data-feather="download-cloud"></i> <?php ee('Update') ?>
            <?php if(\Helpers\App::newUpdate(true)): ?>
                <small class="badge bg-success ms-2"><?php ee('New') ?></small>
            <?php endif ?>
        </a>
    </li>
</ul>