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
							<div class="form-group mb-3">
								<label class="form-label" for="label"><?php ee("Form Label") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control" name="label" id="label"  value="<?php echo $overlay->data->label ?>" placeholder="<?php ee("e.g. Need help?") ?>">
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="content"><?php ee("Form Description") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input class="form-control" name="content" id="content" placeholder="<?php ee("(optional) Provide a description or anything you want to add to the form.") ?>" value="<?php echo $overlay->data->content ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="success"><?php ee("Thank You Message") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control" name="success" id="success"  value="<?php echo $overlay->data->success ?>" placeholder="<?php ee("e.g. Thank you.") ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header mt-2">
					<h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <a href="" data-bs-toggle="collapse" role="button" data-bs-target="#textlabels"><?php ee('Text Labels') ?></a></h5>
				</div>				
				<div class="card-body collapse" id="textlabels">				
					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label class="form-label" for="button-p"><?php ee("Button") ?></label>
								<input type="text" class="form-control" name="button" id="button-p" value="<?php echo $overlay->data->button ?>">
								<p class="form-text"><?php ee("If you want to use a different language, change these.") ?></p>
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
					<div class="form-group mb-3">
						<label class="form-label d-block" for="position"><?php ee("Overlay Position") ?></label>
						<select name="position" id="position" class="form-control" data-toggle="select">
							<option value="tl"<?php echo $overlay->data->position == 'tl' ? 'selected' : '' ?>><?php ee("Top Left") ?></option>
							<option value="tr"<?php echo $overlay->data->position == 'tr' ? 'selected' : '' ?>><?php ee("Top Right") ?></option>                            
							<option value="bl"<?php echo $overlay->data->position == 'bl' ? 'selected' : '' ?>><?php ee("Bottom Left") ?></option>
							<option value="br"<?php echo $overlay->data->position == 'br' ? 'selected' : '' ?>><?php ee("Bottom Right") ?></option> 
							<option value="bc"<?php echo $overlay->data->position == 'bc' ? 'selected' : '' ?>><?php ee("Bottom Center") ?></option> 
						</select>
					</div>
					<hr>
					<div class="form-group mb-3">
						<label class="form-label" for="webhook"><?php ee("Webhook Notification") ?></label><br>
						<input type="text" name="webhook" id="webhook" class="form-control" placeholder="e.g. https://domain.com/path/to/webhook-receiver" value="<?php echo $overlay->data->webhook ?>">
						<p class="form-text"><?php ee("If you want to receive a notification directly to your app, add the url to your app's handler and as soon as there is a submission, we will send a notification to this url as well as an email to the address provided above.") ?></p>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary"><?php ee("Update") ?></button>
		</form>
    </div>
    <div class="col-md-4">
        <div class="position-sticky" id="main-overlay">                  
			<div class="contact-box mx-0 d-block w-100" style="color:<?php echo $overlay->data->color ?>;background-color:<?php echo $overlay->data->bg ?> !important">
                <h1 class="contact-label" style="color:<?php echo $overlay->data->color ?>"><?php ee('Newsletter') ?></h1>
                <p class="contact-description" style="color:<?php echo $overlay->data->color ?>"><?php ee('Description') ?></p>
                <div class="d-flex align-items-center border rounded bg-white p-1">
                    <div>                         
                        <input type="text" class="form-control border-0" id="contact-email" placeholder="johnsmith@company.com">
                    </div>		
                    <div class="ms-auto">				
                        <button type="submit" class="btn btn-dark btn-lg" style="color:<?php echo $overlay->data->btncolor ?>;background-color:<?php echo $overlay->data->btnbg ?> !important"><?php echo $overlay->data->button ?></button>																
                    </div>
                </div>															
            </div>
        </div>
		<div class="card mt-4">
			<div class="card-header">
				<h5><?php ee("Newsletter Emails") ?></h5>
			</div>
			<div class="card-body">
				<p><?php ee('Collected {c} emails in total', null, ['c' => count($overlay->data->emails)]) ?></p>
				<a href="?downloadcsv=1" class="btn btn-success"><?php ee('Download as CSV') ?></a>
			</div>
		</div>
		<div class="card mt-4">
			<div class="card-header">
				<h5><?php ee("Webhook Notification") ?></h5>
			</div>
			<div class="card-body">
				<p><?php ee("If you add a webhook url, we will send a notification to that url with the form data. You will be able to integrate it with your own app or a third-party app. Below is a sample data that will be sent in <code>JSON</code> format via a <code>POST</code> request.") ?></p>
				<pre class="bg-light p-3 text-break">{<br> "type": "newsletter",<br> "data":{<br>&nbsp;&nbsp;&nbsp;"email":"johnsmith@company.com",<br>&nbsp;&nbsp;&nbsp;"date":"2020-01-01 12:00"<br>  }<br>}</pre>
			</div>
		</div>
    </div>
</div>