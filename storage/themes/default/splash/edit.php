<h1 class="h3 mb-2"><?php ee('Create a Custom Splash') ?></h1>
<p class="text-muted mb-3"><?php ee('A custom splash page is a transitional page where you can customize it however you want.') ?></p>    
<div class="row mt-3">
    <div class="col-md-7">
		<form method="post" action="<?php echo route("splash.update", [$splash->id]) ?>" enctype="multipart/form-data" autocomplete="off">		
			<div class="card">
				<div class="card-body">
                    <?php echo csrf() ?>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="name"><?php ee("Name") ?></label>
								<input type="text" class="form-control p-2" name="name" id="name"  placeholder="e.g. Promo" value="<?php echo $splash->name ?>" data-required="true">
							</div>	
						</div>
                        <div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="counter"><?php ee("Counter") ?></label>
								<input type="text" class="form-control p-2" name="counter" id="counter"  placeholder="e.g. 15" value="<?php echo $splash->data->counter ?? '' ?>">
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="product"><?php ee('Link to Product') ?></label>
                                <input type="text" class="form-control p-2" name="product" id="product" value="<?php echo $splash->data->product ?>" placeholder="e.g. http://domain.com/">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="title"><?php ee('Custom Title') ?></label>
                                <input type="text" class="form-control p-2" name="title" id="title" value="<?php echo $splash->data->title ?>" placeholder="e.g. <?php ee("Get a $10 discount") ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="banner"><?php ee('Upload Banner') ?></label>
                                <input type="file" class="form-control" name="banner" id="banner">
                                <div class="form-text"><?php ee("The minimum width must be 980px and the height must be between 250 and 500. The format must be a PNG or a JPG. Maximum size is 500KB") ?></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="avatar"><?php ee('Upload Avatar') ?> (200x200, PNG/JPEG, max 300KB)</label>
                                <input type="file" class="form-control" name="avatar" id="avatar" >
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <label class="form-label" for="message"><?php ee('Custom Message') ?></label>
                                <textarea name="message" id="message" cols="30" rows="5" class="form-control p-2" placeholder="e.g. <?php ee("Get a $10 discount with any purchase more than $50") ?>"><?php echo $splash->data->message ?></textarea>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary"><?php ee("Update") ?></button>
		</form>
    </div>
    <div class="col-md-5">
        <div class="card shadow mb-3">
            <img src="<?php echo uploads($splash->data->banner) ?>" class="rounded w-100">
        </div>
        <div class="d-flex align-items-center">
            <div>
                <img src="<?php echo uploads($splash->data->avatar) ?>" height="100" class="rounded">
            </div>
            <div class="ms-3">
                <strong><?php echo $splash->data->title ?></strong>
                <p class="mt-2"><?php echo $splash->data->message ?></p>
                <p><a href="<?php echo $splash->data->product ?>" rel="nofollow" target="_blank" class='btn btn-primary btn-sm'><?php ee('View site') ?></a></p>
            </div>
        </div>        
    </div>
</div>