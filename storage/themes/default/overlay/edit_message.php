<h1 class="h3 mb-2"><?php echo $overlay->name ?> <small><?php echo $name ?></small></h1>
<p class="text-muted mb-3"><?php echo $description ?></p>
<div class="row">
    <div class="col-md-8">
		<form method="post" action="<?php echo route("overlay.update", [$overlay->id]) ?>" enctype="multipart/form-data" id="settings-form" autocomplete="off">
			<div class="card">
				<div class="card-body">
                    <?php echo csrf() ?>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="name"><?php ee("Name") ?></label>
								<input type="text" class="form-control" name="name" id="name"  placeholder="e.g. Promo" value="<?php echo $overlay->name ?>" data-required="true">
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="logo" class="form-label"><?php ee("Logo") ?></label>
								<input type="file" class="form-control" id="logo" name="logo">
								<p class="form-text"><?php ee("Logo should be square with a maximum size of 100x100. To remove the image, click on the upload field and then cancel it.") ?></p>
							</div>								
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<div class="form-group">
								<label for="message" class="form-label"><?php ee("Custom Message") ?> (Max: 140 chars)</label>
								<textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="e.g. <?php ee("Get a $10 discount with any purchase more than $50") ?>"><?php echo $overlay->data->message ?></textarea>
							</div>																
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="label" class="form-label"><?php ee("Overlay label") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control" name="label" id="label"  placeholder="e.g. Promo" value="<?php echo $overlay->data->label ?>">
							</div>								
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label for="link" class="form-label"><?php ee("Button Link") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control" name="link" id="link"  placeholder="e.g. http://domain.com/" value="<?php echo $overlay->data->link ?>">
								<p class="form-text"><?php ee("If you remove the button text below but add a link here, the whole overlay will be linked to this when clicked.") ?></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label for="text" class="form-label"><?php ee("Button Text") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control" name="text" id="text"  placeholder="e.g. <?php ee("Learn more") ?>" value="<?php echo $overlay->data->text ?>">
							</div>	
						</div>
					</div>					
				</div>
			</div>
			<div class="card">
				<div class="card-header mt-2">					
					<h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <a href="" data-bs-toggle="collapse" role="button" data-bs-target="#custom"><?php ee('Appearance Customization') ?></a></h5>
				</div>				
				<div class="card-body collapse" id="custom">					
					<div class="row">						
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="bg"><?php ee("Overlay Background Color") ?></label> <br>
								<input type="text" name="bg" id="bg" value="<?php echo $overlay->data->bg ?>">
							</div>			
						</div>	
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="color"><?php ee("Overlay Text Color") ?></label><br>
								<input type="text" name="color" id="color" value="<?php echo $overlay->data->color ?>">
							</div>	
						</div>
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="labelbg"><?php ee("Label Background Color") ?></label><br>
								<input type="text" name="labelbg" id="labelbg" value="<?php echo $overlay->data->labelbg ?>">
							</div>		
						</div>
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="labelcolor"><?php ee("Label Text Color") ?></label><br>
								<input type="text" name="labelcolor" id="labelcolor" value="<?php echo $overlay->data->labelcolor ?>">
							</div>			
						</div>
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="btnbg"><?php ee("Button Background Color") ?></label><br>
								<input type="text" name="btnbg" id="btnbg" value="<?php echo $overlay->data->btnbg ?>">
							</div>		
						</div>
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="btncolor"><?php ee("Button Text Color") ?></label><br>
								<input type="text" name="btncolor" id="btncolor" value="<?php echo $overlay->data->btncolor ?>">
							</div>					
						</div>
					</div>				
					<div class="form-group">
						<label class="form-label d-block" for="position"><?php ee("Overlay Position") ?></label>
						<select name="position" id="position" class="form-control" data-toggle="select">
							<option value="tl"<?php echo $overlay->data->position == 'tl' ? 'selected' : '' ?>><?php ee("Top Left") ?></option>
							<option value="tr"<?php echo $overlay->data->position == 'tr' ? 'selected' : '' ?>><?php ee("Top Right") ?></option>                            
							<option value="bl"<?php echo $overlay->data->position == 'bl' ? 'selected' : '' ?>><?php ee("Bottom Left") ?></option>
							<option value="br"<?php echo $overlay->data->position == 'br' ? 'selected' : '' ?>><?php ee("Bottom Right") ?></option> 
							<option value="bc"<?php echo $overlay->data->position == 'bc' ? 'selected' : '' ?>><?php ee("Bottom Center") ?></option> 
						</select>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary"><?php ee("Update") ?></button>
		</form>
    </div>
    <div class="col-md-4">
        <div class="position-sticky" id="main-overlay">
			<div class="custom-message position-relative bottom-0 mx-0" style="background-color: <?php echo $overlay->data->bg ?>">
				<div class="custom-label" style="background-color:<?php echo $overlay->data->labelbg ?>;color:<?php echo $overlay->data->labelcolor ?>"><?php echo $overlay->data->label ?></div>
				<div class="d-flex">
					<div class="custom-img"><?php echo (isset($overlay->data->image) && $overlay->data->image ? '<img src="'.config('url').'/content/'.$overlay->data->image.'">' : "") ?></div>
					<div style="color: #fff">
						<span class="custom-text"><?php echo $overlay->data->message ?></span>											
						<a href="<?php echo $overlay->data->link ?>" class="btn btn-sm mt-3" style="<?php echo !$overlay->data->text ? 'display:none;' : '' ?>background-color:<?php echo $overlay->data->btnbg ?>;color:<?php echo $overlay->data->btncolor ?>"><?php echo $overlay->data->text ?></a>
					</div>
				</div>
			</div>
        </div>		
    </div>
</div>