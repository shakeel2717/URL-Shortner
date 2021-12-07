<ul class="nav nav-tabs overflow-x">
    <li class="nav-item">
        <a href="<?php echo route('stats', $url->id) ?>" class="nav-link"><i data-feather="home"></i> <?php ee('Summary') ?></a>
    </li>
    <li class="nav-item">
        <a href="<?php echo route('stats.countries', $url->id) ?>" class="nav-link"><i data-feather="map-pin"></i> <?php ee('Countries') ?></a>
    </li>
    <li class="nav-item">
        <a href="<?php echo route('stats.platforms', $url->id) ?>" class="nav-link"><i data-feather="monitor"></i> <?php ee('Platforms') ?></a>
    </li>
    <li class="nav-item">
        <a href="<?php echo route('stats.browsers', $url->id) ?>" class="nav-link"><i data-feather="sidebar"></i> <?php ee('Browsers') ?></a>
    </li>
    <li class="nav-item">
        <a href="<?php echo route('stats.languages', $url->id) ?>" class="nav-link"><i data-feather="user"></i> <?php ee('Languages') ?></a>
    </li>
    <li class="nav-item">
        <a href="<?php echo route('stats.referrers', $url->id) ?>" class="nav-link"><i data-feather="globe"></i> <?php ee('Referrers') ?></a>
    </li>
</ul>