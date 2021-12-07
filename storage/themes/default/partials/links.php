<div class="d-flex align-items-start">
    <div class="flex-grow-1">
        <div class="float-end">
            <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" data-trigger="shortinfo" data-shorturl="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><i data-feather="info"></i> <?php ee('More Info') ?></a></li>
                <li><a class="dropdown-item" href="<?php echo route('stats', [$url->id]) ?>"><i data-feather="bar-chart-2"></i> <?php ee('Statistics') ?></a></li>
                <?php if(user()->teamPermission('links.edit')): ?>
                    <li><a class="dropdown-item" href="<?php echo route('links.edit', [$url->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                    <?php if($url->archived): ?>
                        <li><a class="dropdown-item" href="<?php echo route('links.unarchive', ['link' => $url->id]) ?>" data-trigger="archiveselected"><i data-feather="briefcase"></i> <?php ee('Unarchive') ?></a></li>  
                    <?php else: ?>
                        <li><a class="dropdown-item" href="<?php echo route('links.archive', ['link' => $url->id]) ?>" data-trigger="archiveselected"><i data-feather="briefcase"></i> <?php ee('Archive') ?></a></li>  
                    <?php endif ?>
                    <?php if($url->public): ?>
                        <li><a class="dropdown-item" href="<?php echo route('links.private', ['link' => $url->id]) ?>" data-trigger="archiveselected"><i data-feather="eye-off"></i> <?php ee('Set Private') ?></a></li>  
                    <?php else: ?>
                        <li><a class="dropdown-item" href="<?php echo route('links.public', ['link' => $url->id]) ?>" data-trigger="archiveselected"><i data-feather="eye"></i> <?php ee('Set Public') ?></a></li>  
                    <?php endif ?>
                <?php endif ?>
                <?php if(user()->has('export')): ?>
                    <li><a class="dropdown-item" href="<?php echo route('links.stats.export', [$url->id]) ?>"><i data-feather="download"></i> <?php ee('Export Statistics') ?></a></li> 
                <?php endif ?>
                <li><hr class="dropdown-divider"></li>
                <?php if(user()->teamPermission('links.delete')): ?>
                    <li><a class="dropdown-item" href="<?php echo route('links.delete', [$url->id, \Core\Helper::nonce('link.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                <?php endif ?>
            </ul>                        
        </div>
        <div class="mb-2 d-block">
            <input class="form-check-input me-2" type="checkbox" data-dynamic="1" value="<?php echo $url->id ?>">
            <img src="<?php echo route('link.ico', $url->id) ?>" width="16" height="16" class="rounded-circle me-1" alt="<?php echo $url->meta_title ?>"> <a href="<?php echo $url->url ?>" target="_blank" rel="nofollow"><strong><?php echo \Core\Helper::truncate(\Core\Helper::empty($url->meta_title, $url->url), 50) ?></strong></a>   
        </div>
        <div class="d-none d-sm-block">
        <?php if(!$url->status): ?>
            <small class="badge bg-danger text-xs me-2"><?php ee('Disabled') ?></small>
        <?php endif ?>
        <?php if($url->archived): ?>
            <small class="badge bg-success text-xs me-2"><?php ee('Archived') ?></small>
        <?php endif ?>
        <?php if($url->public): ?>
            <i class="align-middle me-1" data-feather="eye"></i> <small class="me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Public') ?>">Public</small>        
        <?php endif ?>
        <?php if ($url->bundle): ?>            
            <i class="align-middle me-1" data-feather="crosshair"></i> <small class="me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Campaign') ?>: <?php echo $url->bundlename ?>"><?php echo $url->bundlename ?></small>
        <?php endif ?>
        <?php if (!empty($url->location)): ?>            
            <i class="align-middle me-1" data-feather="map-pin"></i>  <small class="me-2"><?php echo e('Geo Targeted')?></small>
        <?php endif ?>
        <?php if (!empty($url->devices)): ?>            
            <i class="align-middle me-1" data-feather="smartphone"></i> <small class="me-2"><?php echo e('Device Targeted')?></small>
        <?php endif ?>
        <?php if (!empty($url->pass)): ?>            
            <i class="align-middle me-1" data-feather="lock"></i> <small class="me-2"><?php echo e('Protected')?></small>
        <?php endif ?>
        <?php if (!empty($url->expiry)): ?>            
            <i class="align-middle me-1" data-feather="calendar"></i> <small class="me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e("Expiry on") ?> <?php echo date("d F, Y", strtotime($url->expiry)) ?>"> <?php ee("Expiration") ?></small>
        <?php endif ?>
        <?php if (!empty($url->pixels)): ?>            
            <i class="align-middle me-1" data-feather="compass"></i> <small class="me-2" data-bs-toggle="tooltip" data-bs-placement="top"><?php echo e('Pixels')?></small>
        <?php endif ?>
        <?php if (!empty($url->description)): ?>
            <i class="align-middle me-1" data-feather="book-open"></i> <small class="me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $url->description ?>"><?php echo e('Note')?></small>
        <?php endif ?>
        <?php if ($parameters = json_decode($url->parameters, TRUE)): ?>         
            <i class="align-middle me-1" data-feather="sliders"></i> <small class="me-2"><?php echo e('Parameters')?></small>
        <?php endif ?>
        </div>
        <div class="d-block mt-1">            
            <small class="text-navy"><?php echo \Core\Helper::timeago($url->date) ?> -</small>
            <a href="<?php echo route('stats', [$url->id]) ?>" class="d-none d-sm-inline"><small class="text-navy"><?php echo $url->click ?> <?php ee('Clicks') ?></small> -</a> 
            <small class="text-navy d-none d-sm-inline"><?php echo $url->uniqueclick ?> <?php ee('Unique Clicks') ?> -</small>            
            <small class="text-muted " data-href="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?></small>
            <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><small><?php echo e("Copy")?></small></a>	
        </div>                                        
    </div>
</div>          
<hr> 