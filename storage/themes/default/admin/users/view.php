<h1 class="h3 mb-5"><?php ee('Profile') ?></h1>
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo $user->email ?></h5>
            </div>
            <div class="card-body text-center">
                <img src="<?php echo $user->avatar() ?>" alt="<?php echo $user->username ?>" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                <h5 class="card-title mb-0"><?php echo $user->username ?></h5>
                <div class="text-muted mb-2"><?php echo $user->pro && $plan ? $plan->name : 'Free user' ?></div>

                <div>
                    <a class="btn btn-primary btn-sm" href="<?php echo route('admin.email', ['email'=> $user->email]) ?>"><span data-feather="message-square"></span> <?php echo e('Send Email') ?></a>
                    <a class="btn btn-primary btn-sm" href="<?php echo route('admin.users.edit', [$user->id]) ?>"><span data-feather="edit"></span></a>
                </div>
            </div>            
        </div>
        <div class="card">
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action" href="<?php echo route('admin.users.view', [$user->id]) ?>"><?php ee('Links') ?></a>
                    <a class="list-group-item list-group-item-action" href="<?php echo route('admin.payments', ['userid' => $user->id]) ?>"><?php ee('Payments') ?></a>
                    <a class="list-group-item list-group-item-action" href="<?php echo route('admin.subscriptions', ['userid' => $user->id]) ?>"><?php ee('Subscriptions') ?></a>
                    <a class="list-group-item list-group-item-action" href="<?php echo route('admin.domains', ['userid' => $user->id]) ?>"><?php ee('Domains') ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php ee('Links') ?></h5>
            </div>
            <div class="card-body h-100">
                <?php foreach($urls as $url): ?>
                    <div class="d-flex align-items-start">
                        <img src="<?php echo route('link.ico', $url->id) ?>" width="36" height="36" class="rounded-circle me-2" alt="<?php echo $url->meta_title ?>">
                        <div class="flex-grow-1">
                            <small class="float-end text-navy"><?php echo \Core\Helper::timeago($url->date) ?></small>
                            <a href="<?php echo $url->url ?>" target="_blank" rel="nofollow"><strong><?php echo \Core\Helper::empty($url->meta_title, $url->url) ?></strong></a><br />
                            <small class="text-muted"><?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?></small> - 
                            <a href="<?php echo route('admin.links.delete', [$url->id, \Core\Helper::nonce('link.delete')]) ?>"><small class="text-danger"><?php ee('Delete') ?></span></small></a>
                        </div>
                    </div>          
                <hr>          
                <?php endforeach ?>
                <?php echo pagination('pagination') ?>
            </div>
        </div>
    </div>
</div>