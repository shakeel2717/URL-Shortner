<ul class="sidebar-nav">
    <li class="sidebar-item active">
        <a class="sidebar-link" href="<?php echo route('dashboard') ?>">
            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle"><?php ee('Dashboard') ?></span>
        </a>
    </li>
    <?php if($user->has('bio')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('bio') ?>">
            <i class="align-middle" data-feather="layout"></i> <span class="align-middle"><?php ee('Bio Pages') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if($user->has('qr')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('qr') ?>">
            <i class="align-middle" data-feather="aperture"></i> <span class="align-middle"><?php ee('QR Codes') ?></span>
        </a>
    </li>
    <?php endif ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('user.stats') ?>">
            <i class="align-middle" data-feather="bar-chart"></i> <span class="align-middle"><?php ee('Statistics') ?></span>
        </a>
    </li>
    <li class="sidebar-header"><?php ee('Link Management') ?></li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('links') ?>">
            <i class="align-middle" data-feather="link"></i> <span class="align-middle"><?php ee('Links') ?> </span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('archive') ?>">
            <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle"><?php ee('Archived Links') ?> </span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('expired') ?>">
            <i class="align-middle" data-feather="calendar"></i> <span class="align-middle"><?php ee('Expired Links') ?></span>
        </a>
    </li>    
    <?php if($user->has('bundle')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('campaigns') ?>">
            <i class="align-middle" data-feather="crosshair"></i> <span class="align-middle"><?php ee('Campaigns') ?></span>
        </a>
    </li>    
    <?php endif ?>
    <?php if($user->has('splash')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('splash') ?>">
            <i class="align-middle" data-feather="loader"></i> <span class="align-middle"><?php ee('Custom Splash') ?></span>
        </a>
    </li>    
    <?php endif ?>
    <?php if($user->has('overlay')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('overlay') ?>">
            <i class="align-middle" data-feather="layers"></i> <span class="align-middle"><?php ee('CTA Overlay') ?></span>
        </a>
    </li>    
    <?php endif ?>
    <?php if($user->has('pixels')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('pixel') ?>">
            <i class="align-middle" data-feather="compass"></i> <span class="align-middle"><?php ee('Tracking Pixels') ?></span>
        </a>
    </li>    
    <?php endif ?>
    <?php if($user->has('domain')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('domain') ?>">
            <i class="align-middle" data-feather="globe"></i> <span class="align-middle"><?php ee('Branded Domains') ?></span>
        </a>
    </li>    
    <?php endif ?>    
    <?php if($user->has('team')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('team') ?>">
            <i class="align-middle" data-feather="users"></i> <span class="align-middle"><?php ee('Teams') ?></span>
        </a>
    </li>    
    <?php endif ?>   
    <?php plug('usermenu') ?>
    <li class="sidebar-item">        
        <a class="sidebar-link collapsed" data-bs-target="#nav-tool" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="terminal"></i> <span class="align-middle"><?php ee('Tools') ?></span>
        </a>
        <ul id="nav-tool" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('tools') ?>"><?php ee('All Tools') ?></a></li>                
            <?php if($user->has('api')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('apidocs') ?>"><?php ee('Developer API') ?></a></li>
            <?php endif ?>
        </ul>
    </li>     
</ul>