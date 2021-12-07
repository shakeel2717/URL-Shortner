<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex">                
                <h4 class="card-title mb-0"><?php echo $title ?></h4>
                <div class="ms-auto">
                    <form class="d-none d-sm-inline-block rounded border" id="search" action="<?php echo route('search') ?>">
                        <div class="input-group input-group-navbar">
                            <input type="text" class="form-control bg-white" placeholder="<?php ee('Search for links') ?>" aria-label="Search">
                            <button class="btn btn-white bg-white" type="submit">
                                <i class="align-middle" data-feather="search"></i>
                            </button>
                            <button class="btn btn-white d-none bg-white" data-trigger="clearsearch" type="button">
                                <i class="align-middle" data-feather="x"></i>
                            </button>
                            <button type="button" class="btn btn-default bg-white border-start" data-bs-toggle="dropdown"  aria-expanded="false"><span  data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Sort Results') ?>"><i data-feather="filter"></i></span></button>
                            <ul class="dropdown-menu" id="sort">
                                <li><a class="dropdown-item" href="?<?php echo appendquery(['sort'=>'latest']) ?>"><?php ee('Latest') ?></a></li>
                                <li><a class="dropdown-item" href="?<?php echo appendquery(['sort'=>'oldest']) ?>"><?php ee('Oldest') ?></a></li>                                
                                <li><a class="dropdown-item" href="?<?php echo appendquery(['sort'=>'popular']) ?>"><?php ee('Most Popular') ?></a></li>
                                <li><a class="dropdown-item" href="?<?php echo appendquery(['sort'=>'less']) ?>"><?php ee('Less Popular') ?></a></li>
                            </ul> 
                        </div>
                    </form>                    
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="" data-trigger="options">
                    <?php echo csrf() ?>
                    <input type="hidden" name="selected">
                    <div class="btn-group btn-group-sm mb-4">
                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e("Select All") ?>" data-trigger="selectall" class="fa fa-check-square btn btn-default p-2"></a>
                        <?php if(user()->teamPermission('links.edit')): ?>
                            <?php if(\Gem::currentRoute() == 'archive'): ?>
                                <a href="<?php echo route('links.unarchive') ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e("Unarchive Selected") ?>" data-trigger="archiveselected" class="fa fa-briefcase btn btn-default p-2"></a>
                            <?php else: ?>
                                <a href="<?php echo route('links.archive') ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e("Archive Selected") ?>" data-trigger="archiveselected" class="fa fa-briefcase btn btn-default p-2"></a>
                            <?php endif ?>
                        <?php endif ?>
                        <span data-bs-toggle="modal" data-bs-target="#bundleModal" data-trigger="getchecked" data-for="#bundleids">
                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e("Add to Campaign") ?>" class="fa fa-folder-open btn btn-default p-2"></a>
                        </span>
                        <?php if(user()->teamPermission('links.delete')): ?>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e("Delete Selected") ?>" href="<?php echo route('links.deleteall') ?>" data-trigger="submitchecked" class="fa fa-trash btn btn-default p-2"></a>
                        <?php endif ?>
                    </div>
                </form>				
                <div id="return-ajax"></div>
                <div id="link-holder" data-refresh="<?php echo \Gem::currentRoute() == 'archive' ? route('links.refresh.archive') : route('links.refresh') ?>">
                    <?php foreach($urls as $url): ?>
                        <?php view('partials.links', compact('url')) ?>      
                    <?php endforeach ?>                     
                    
                    <div class="d-flex">
                        <?php echo simplePagination() ?>
                    </div> 
                </div>           
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php \Helpers\App::ads('resp') ?>
        
        <?php if(\Models\User::where('id', user()->rID())->first()->has('export') !== false): ?>
        <div class="card">
            <div class="card-body">                            
                <h5 class="card-title fw-bold"><?php ee('Export Links') ?></h5>
                <p><?php ee('This tool allows you to generate a list of urls in CSV format. Some basic data such clicks will be included as well.') ?></p>
                <a href="<?php echo route('user.export.links') ?>" class="btn btn-success"><?php ee('Export') ?></a>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Are you sure you want to delete this?') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to delete a record. This action is permanent and cannot be reversed.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Short Link Info') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex">
            <div class="modal-qr me-3">
                <p></p>
                <div class="btn-group" role="group" aria-label="downloadQR">
                    <a href="#" class="btn btn-primary" id="downloadPNG"><?php ee('Download') ?></a>
                    <div class="btn-group" role="group">
                        <button id="btndownloadqr" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">PNG</button>
                        <ul class="dropdown-menu" aria-labelledby="btndownloadqr">
                            <li><a class="dropdown-item" href="#">PDF</a></li>
                            <li><a class="dropdown-item" href="#">SVG</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <div class="form-group">
                    <label for="short" class="form-label"><?php ee('Short Link') ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="modal-input" name="shortlink" value="">
                        <div class="input-group-text bg-white">
                            <button class="btn btn-primary copy" data-clipboard-text=""><?php ee('Copy') ?></button>
                        </div>
                    </div>
                </div>    
                <div class="mt-3" id="modal-share">
                    <?php echo \Helpers\App::share('--url--') ?>
                </div>
            </div>            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal"><?php ee('Done') ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="bundleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">    
    <div class="modal-content">
      <form action="<?php echo route('links.addtocampaign') ?>" data-trigger="server-form">
        <?php echo csrf() ?>
        <div class="modal-header">
            <h5 class="modal-title"><?php ee('Add to Campaign') ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label for="campaigns" class="form-label d-block mb-2"><?php ee('Campaigns') ?></label>
            <div class="input-group">            
                <select name="campaigns" id="campaigns" class="form-control" data-toggle="select">
                    <option value="0"><?php ee('None') ?></option>
                    <?php foreach(\Core\DB::bundle()->where('userid', user()->rId())->findArray() as $campaign): ?>
                        <option value="<?php echo $campaign['id'] ?>"><?php echo $campaign['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <input type="hidden" name="bundleids" id="bundleids" value="">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-success" class="btn btn-success" data-bs-dismiss="modal" data-trigger="addtocampaign"><?php ee('Add') ?></button>
        </div>          
      </form>
    </div>
  </div>
</div>