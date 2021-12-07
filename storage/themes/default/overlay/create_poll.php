<h1 class="h3 mb-2"><?php echo $name ?></h1>
<p class="text-muted mb-3"><?php echo $description ?></p>
<div class="row">
    <div class="col-md-8">
		<form method="post" action="<?php echo route("overlay.save", [$type]) ?>" enctype="multipart/form-data" id="settings-form" autocomplete="off">		
			<div class="card">
				<div class="card-body">
                    <?php echo csrf() ?>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="name"><?php ee("Name") ?></label>
								<input type="text" class="form-control" name="name" id="name"  placeholder="e.g. Poll" value="" data-required="true">
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mb-3">
								<label class="form-label" for="subject"><?php ee("Question") ?></label>
								<input type="text" class="form-control" name="question" id="question" value="" placeholder="<?php ee('e.g. What is your favorite color?') ?>" data-required="true">
							</div>
						</div>						
					</div>
                    <hr>
                    <h4><?php ee("Options") ?> <small>(max 10)</small></h4>
					<p><?php ee("You can add up to 10 options for each poll. To add an extra option click Add Option above. To ignore a field, leave it empty.") ?></p>
					<div class="poll-options">
						<div class="form-group mb-2">
							<input type="text" class="form-control" name="answer[]" placeholder="#1" data-id="1">
						</div>	
						<div class="form-group mb-2">
							<input type="text" class="form-control" name="answer[]" placeholder="#2" data-id="2">
						</div>
					</div>
                    <a href="#" data-trigger="addpollchoice" class='btn btn-sm btn-primary'><?php ee("Add Option") ?></a>
				</div>
			</div>
			<div class="card">
				<div class="card-header mt-2">
					<h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <a href="" data-bs-toggle="collapse" role="button" data-bs-target="#textlabels"><?php ee('Text Labels') ?></a></h5>
				</div>				
				<div class="card-body collapse" id="textlabels">				
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="votetext"><?php ee("Vote Button Placeholder") ?></label>
								<input type="text" class="form-control" name="votetext" id="votetext" value="<?php ee('Vote') ?>">
							</div>							
						</div>	
                        <div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="thankyou"><?php ee("Thank You Message") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control" name="thankyou" id="thankyou" placeholder="<?php ee('Thanks...') ?>">
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
								<input type="text" name="bg" id="bg">
							</div>			
						</div>	
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="color"><?php ee("Overlay Text Color") ?></label><br>
								<input type="text" name="color" id="color">
							</div>	
						</div>
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="btnbg"><?php ee("Button Background Color") ?></label><br>
								<input type="text" name="btnbg" id="btnbg">
							</div>		
						</div>
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label" for="btncolor"><?php ee("Button Text Color") ?></label><br>
								<input type="text" name="btncolor" id="btncolor">
							</div>					
						</div>
					</div>				
					<div class="form-group mb-3">
						<label class="form-label d-block" for="position"><?php ee("Overlay Position") ?></label>
						<select name="position" id="position" class="form-control" data-toggle="select">                        
							<option value="bl"><?php ee("Bottom Left") ?></option>
							<option value="br" selected><?php ee("Bottom Right") ?></option> 
							<option value="bc"><?php ee("Bottom Center") ?></option> 
						</select>
                    </div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary"><?php ee("Create") ?></button>
		</form>
    </div>
    <div class="col-md-4">
        <div class="position-sticky" id="main-overlay">
            <div class="poll-box">
                <p class="poll-question"><?php ee("Your question here?") ?></p>
                <ol class="poll-answers">
                    <li data-id="1">#1</li>
                    <li data-id="2">#2</li>
                </ol>
                <button type="submit" class="poll-btn" data-trigger="vote"><?php ee("Vote") ?></button>
            </div>
        </div>		
    </div>
</div>