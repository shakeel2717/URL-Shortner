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
								<input type="text" class="form-control" name="name" id="name"  placeholder="e.g. Poll" value="<?php echo $overlay->name ?>" data-required="true">
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mb-3">
								<label class="form-label" for="subject"><?php ee("Question") ?></label>
								<input type="text" class="form-control" name="question" id="question" value="<?php echo $overlay->data->question ?>" placeholder="<?php ee('e.g. What is your favorite color?') ?>" data-required="true">
							</div>
						</div>						
					</div>
                    <hr>
                    <h4><?php ee("Options") ?> <small>(max 10)</small></h4>
					<p><?php ee("You can add up to 10 options for each poll. To add an extra option click Add Option above. To ignore a field, leave it empty.") ?></p>
					<div class="poll-options">
                        <?php foreach($overlay->data->answers as $key => $answer): ?>
						<div class="form-group mb-2">
							<input type="text" class="form-control" name="answer[]" value="<?php echo $answer->option ?>" data-id="<?php echo $key ?>">
						</div>						
                        <?php endforeach ?>
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
								<input type="text" class="form-control" name="votetext" id="votetext" value="<?php echo $overlay->data->votetext ?>">
							</div>							
						</div>	
                        <div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label" for="thankyou"><?php ee("Thank You Message") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control" name="thankyou" id="thankyou" value="<?php echo $overlay->data->thankyou ?>">
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
            <div class="poll-box" style="background-color: <?php echo $overlay->data->bg ?>;color: <?php echo $overlay->data->color ?>">
                <p class="poll-question" style="color:<?php echo $overlay->data->color ?>"><?php echo $overlay->data->question ?></p>
                <ol class="poll-answers">
                    <?php foreach($overlay->data->answers as $key => $answer): ?>
                        <li data-id="<?php echo $key ?>" style="color: <?php echo $overlay->data->color ?>"><?php echo $answer->option ?></li>
                    <?php endforeach ?>
                </ol>
                <button type="submit" class="poll-btn" data-trigger="vote" style="background-color:<?php echo $overlay->data->btnbg ?>;color:<?php echo $overlay->data->btncolor ?>"><?php echo $overlay->data->votetext ?></button>															
            </div>
        </div>		
        <div class="card mt-4">
            <div class="card-header">
                <h5><?php ee("Poll Results") ?></h5>
            </div>
            <div class="card-body">
                <h5 class="mb-3"><?php echo $overlay->data->question ?></h5>
                <?php foreach($overlay->data->answers as $key => $answer): ?>
                    <strong><?php echo $answer->option ?></strong> <small><?php echo $answer->votes ?></small>
                    <div class="progress mb-2">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $overlay->totalResponse > 0 ? round($answer->votes*100/$overlay->totalResponse) : '5' ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $answer->votes ?></div>
                    </div>
                <?php endforeach ?>
                <p class="mt-3"><strong><?php ee("Total") ?>:</strong> <?php echo $overlay->totalResponse ?></p>
            </div>
        </div>        
    </div>    
</div>