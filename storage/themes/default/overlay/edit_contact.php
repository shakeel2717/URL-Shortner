<h1 class="h3 mb-2"><?php echo $overlay->name ?> <small><?php echo $name ?></small></h1>
<p class="text-muted mb-3"><?php echo $description ?></p>
<div class="row">
    <div class="col-md-8">
		<form method="post" action="<?php echo route("overlay.update", [$overlay->id]) ?>" enctype="multipart/form-data" id="settings-form" autocomplete="off" data-validate="true">
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
								<label class="form-label" for="email"><?php ee("Send Email Address") ?></label>
								<input type="email" class="form-control" name="email" id="email" value="<?php echo $overlay->data->email ?>" placeholder="<?php ee("Emails from the form will be sent to this address") ?>" data-required="true">
							</div>								
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="subject"><?php ee("Email Subject") ?></label>
								<input type="text" class="form-control" name="subject" id="subject" value="<?php echo $overlay->data->subject ?>" placeholder="<?php ee("Something you would know where it comes from.") ?>" data-required="true">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="label"><?php ee("Form Label") ?> <small><?php ee("(leave empty to disable)") ?></small></label>
								<input type="text" class="form-control" name="label" id="label"  value="<?php echo $overlay->data->label ?>" placeholder="<?php ee("e.g. Need help?") ?>">
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="content"><?php ee("Form Description") ?> <small><?php ee("(leave empty to disable)") ?></small></label>
								<input class="form-control" name="content" id="content" placeholder="<?php ee("(optional) Provide a description or anything you want to add to the form.") ?>" value="<?php echo $overlay->data->content ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="success"><?php ee("Thank You Message") ?> <small><?php ee("(leave empty to disable)") ?></small></label>
								<input type="text" class="form-control" name="success" id="success"  value="<?php echo $overlay->data->success??'' ?>" placeholder="<?php ee("e.g. Thank you. We will respond asap.") ?>">
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
					<h5 class="card-title mb-4 fw-bold"><?php ee('Text Labels') ?></h5>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group mb-3">
								<label class="form-label" for="name-p"><?php ee("Name Placeholder") ?></label>
								<input type="text" class="form-control" name="lang[name]" id="name-p" value="<?php echo $overlay->data->lang->name ?>">
								<p class="form-text"><?php ee("If you want to use a different language, change these.") ?></p>
							</div>					
						</div>
						<div class="col-md-3">
							<div class="form-group mb-3">
								<label class="form-label" for="email-p"><?php ee("Email Placeholder") ?></label>
								<input type="text" class="form-control" name="lang[email]" id="email-p" value="<?php echo $overlay->data->lang->email ?>">
								<p class="form-text"><?php ee("If you want to use a different language, change these.") ?></p>
							</div>							
						</div>
						<div class="col-md-3">
							<div class="form-group mb-3">
								<label class="form-label" for="message-p"><?php ee("Message Placeholder") ?></label>
								<input type="text" class="form-control" name="lang[message]" id="message-p" value="<?php echo $overlay->data->lang->message ?>">
								<p class="form-text"><?php ee("If you want to use a different language, change these.") ?></p>
							</div>							
						</div>
						<div class="col-md-3">
							<div class="form-group mb-3">
								<label class="form-label" for="button-p"><?php ee("Send Button Placeholder") ?></label>
								<input type="text" class="form-control" name="lang[button]" id="button-p" value="<?php echo $overlay->data->lang->button ?>">
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
								<label class="form-label" for="bg"><?php ee("Form Background Color") ?></label> <br>
								<input type="text" name="bg" id="bg" value="<?php echo $overlay->data->bg ?>">
							</div>			
						</div>	
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="color"><?php ee("Form Text Color") ?></label><br>
								<input type="text" name="color" id="color" value="<?php echo $overlay->data->color ?>">
							</div>	
						</div>
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="inputbg"><?php ee("Input Background Color") ?></label><br>
								<input type="text" name="inputbg" id="inputbg" value="<?php echo $overlay->data->inputbg ?>">
							</div>		
						</div>
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="inputcolor"><?php ee("Input Text Color") ?></label><br>
								<input type="text" name="inputcolor" id="inputcolor" value="<?php echo $overlay->data->inputcolor ?>">
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
						<input type="text" name="webhook" id="webhook" class="form-control" value="<?php echo $overlay->data->webhook ?>" placeholder="e.g. https://domain.com/path/to/webhook-receiver">
						<p class="form-text"><?php ee("If you want to receive a notification directly to your app, add the url to your app's handler and as soon as there is a submission, we will send a notification to this url as well as an email to the address provided above.") ?></p>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary"><?php ee("Update") ?></button>
		</form>
    </div>
    <div class="col-md-4">
        <div class="position-sticky" id="main-overlay">
            <a style="color:<?php echo $overlay->data->color ?>;background-color:<?php echo $overlay->data->bg ?> !important" id="contact-button" href="#cev" class="contact-event w-50 mt-4"><i class="fa fa-question" style="color:<?php echo $overlay->data->btncolor ?> ;background-color:<?php echo $overlay->data->btnbg ?> !important"></i> <span><?php echo $overlay->data->label ?></span></a>        
            <div class="contact-box mx-0 d-block w-100" style="color:<?php echo $overlay->data->color ?>;background-color:<?php echo $overlay->data->bg ?> !important">
                <h1 class="contact-label"><?php echo $overlay->data->label ?></h1>
                <p class="contact-description"><?php echo $overlay->data->content ?></p>
                <div class="form-group">
                    <label for="contact-name" class="form-label"><?php echo $overlay->data->lang->name ?></label>
                    <input type="text" class="form-control" id="contact-name" placeholder="John Smith" style="color:<?php echo $overlay->data->inputcolor ?>;background-color:<?php echo $overlay->data->inputbg ?> !important">
                </div>
                <div class="form-group">
                    <label for="contact-email" class="form-label"><?php echo $overlay->data->lang->email ?></label>
                    <input type="text" class="form-control" id="contact-email" placeholder="johnsmith@company.com" style="color:<?php echo $overlay->data->inputcolor ?>;background-color:<?php echo $overlay->data->inputbg ?> !important">
                </div>		
                <div class="form-group">
                    <label for="contact-message" class="form-label"><?php echo $overlay->data->lang->message ?></label>
                    <textarea class="form-control" id="contact-message" placeholder="..." style="color:<?php echo $overlay->data->inputcolor ?>;background-color:<?php echo $overlay->data->inputbg ?> !important"></textarea>
                </div>
                <button type="submit" class="contact-btn mt-3" style="color:<?php echo $overlay->data->btncolor ?>;background-color:<?php echo $overlay->data->btnbg ?> !important"><?php echo $overlay->data->lang->button ?></button>																
            </div>
        </div>
		<div class="card mt-4">
			<div class="card-header">
				<h5><?php ee("Webhook Notification") ?></h5>
			</div>
			<div class="card-body">
				<p><?php ee("If you add a webhook url, we will send a notification to that url with the contact form data. You will be able to integrate it with your own app or a third-party app. Below is a sample data that will be sent in <code>JSON</code> format via a <code>POST</code> request.") ?></p>
				<pre class="bg-light p-3 text-break">{<br> "type": "contact",<br> "data":{<br>&nbsp;&nbsp;&nbsp;"name":"John Smith",<br>&nbsp;&nbsp;&nbsp;"email":"johnsmith@company.com",<br>&nbsp;&nbsp;&nbsp;"message":"Consequat incididunt elit do sed duis culpa sint consectetur dolore non esse veniam.",<br>&nbsp;&nbsp;&nbsp;"date":"2020-01-01 12:00"<br>  }<br> }</pre>
			</div>
		</div>
    </div>
</div>