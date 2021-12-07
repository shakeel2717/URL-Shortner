<div class="d-flex align-items-start">
    <div class="flex-grow-1">
        <input class="form-check-input me-2" type="checkbox" data-dynamic="1" value="<?php echo $url->id ?>">
        <div class="float-end">
            <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo route('stats', [$url->id]) ?>"><i data-feather="bar-chart-2"></i> <?php ee('Statistics') ?></span></a></li>
                <li><a class="dropdown-item" href="<?php echo route('admin.links.edit', [$url->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></span></a></li>
                <?php if(!$url->status): ?>
                    <li><a class="dropdown-item" href="<?php echo route('admin.links.approve', [$url->id]) ?>"><i data-feather="check-circle"></i> <?php ee('Approve') ?></span></a></li>  
                <?php else: ?>
                    <li><a class="dropdown-item" href="<?php echo route('admin.links.disable', [$url->id]) ?>"><i data-feather="x-circle"></i> <?php ee('Disable') ?></span></a></li>  
                <?php endif ?>
                <?php if($url->userid): ?>
                    <li><a class="dropdown-item" href="<?php echo route('admin.users.view', [$url->userid]) ?>"><i data-feather="user"></i> <?php ee('View User') ?></span></a></li>
                <?php endif ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo route('admin.links.delete', [$url->id, \Core\Helper::nonce('link.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></span></a></li>
            </ul>                        
        </div>
        <img src="<?php echo route('link.ico', $url->id) ?>" width="16" height="16" class="rounded-circle me-1" alt="<?php echo $url->meta_title ?>"> <a href="<?php echo $url->url ?>" target="_blank" rel="nofollow"><strong><?php echo \Core\Helper::truncate(\Core\Helper::empty($url->meta_title, $url->url), 50) ?></strong></a>
        <?php if(!$url->status): ?>
            <small class="badge bg-danger"><?php ee('Disabled') ?></small>
        <?php endif ?>
        <br />
        <small class="text-navy"><?php echo \Core\Helper::timeago($url->date) ?></small> -
        <?php if(!$url->userid): ?>
            <small class="text-navy"><?php ee("Anonymous User") ?></small> - 
        <?php endif ?>
        <small class="text-navy"><?php echo $url->click ?> <?php ee('Clicks') ?></small> - 
        <small class="text-navy"><?php echo $url->uniqueclick ?> <?php ee('Unique Clicks') ?></small> -            
        <small class="text-muted" data-href="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?></small>
        <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><small><?php echo e("Copy")?></small></a>	                                        
    </div>
</div>          
<hr> 