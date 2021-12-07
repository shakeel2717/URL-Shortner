<div class="row">
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header"><label for="email.registration">Registration Email</label></div>
					<div class="card-body">
						<form action="<?php echo route("admin.email.template") ?>" method="post">
							<div class="form-group">
								<textarea name="email.registration" id="email.registration" cols="30" rows="10" class="form-control editor"><?php echo config('email.registration') ?></textarea>
							</div>
							<?php echo csrf() ?>
							<button type="submit" class="btn btn-primary mt-2"><?php ee('Save') ?></button>
						</form>				
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header"><label for="email.activation">Activation Email</label></div>
					<div class="card-body">
						<form action="<?php echo route("admin.email.template") ?>" method="post">
							<div class="form-group">
								<textarea name="email.activation" id="email.activation" cols="30" rows="10" class="form-control editor"><?php echo config('email.activation') ?></textarea>
							</div>
							<?php echo csrf() ?>
							<button type="submit" class="btn btn-primary mt-2"><?php ee('Save') ?></button>
						</form>				
					</div>
				</div>
			</div>			
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header"><label for="email.activated">Activation Success Email</label></div>
					<div class="card-body">
						<form action="<?php echo route("admin.email.template") ?>" method="post">
							<div class="form-group">
								<textarea name="email.activated" id="email.activated" cols="30" rows="10" class="form-control editor"><?php echo config('email.activated') ?></textarea>
							</div>
							<?php echo csrf() ?>
							<button type="submit" class="btn btn-primary mt-2"><?php ee('Save') ?></button>
						</form>				
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header"><label for="email.reset">Password Reset Email</label></div>
					<div class="card-body">
						<form action="<?php echo route("admin.email.template") ?>" method="post">
							<div class="form-group">
								<textarea name="email.reset" id="email.reset" cols="30" rows="10" class="form-control editor"><?php echo config('email.reset') ?></textarea>
							</div>
							<?php echo csrf() ?>
							<button type="submit" class="btn btn-primary mt-2"><?php ee('Save') ?></button>
						</form>				
					</div>
				</div>
			</div>			
		</div>			
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header"><label for="email.invitation">Team Invitation Email</label></div>
					<div class="card-body">
						<form action="<?php echo route("admin.email.template") ?>" method="post">
							<div class="form-group">
								<textarea name="email.invitation" id="email.invitation" cols="30" rows="10" class="form-control editor"><?php echo config('email.invitation') ?></textarea>
							</div>
							<?php echo csrf() ?>
							<button type="submit" class="btn btn-primary mt-2"><?php ee('Save') ?></button>
						</form>				
					</div>
				</div>
			</div>
		</div>				
	</div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header">Shortcodes</div>
			<div class="card-body">
        <ul>
          <li>User's Username: <strong>{user.username}</strong></li>
          <li>User's Email: <strong>{user.email}</strong></li>
          <li>User's Sign Up Date: <strong>{user.date}</strong></li>
          <li>Activation Link or Password Reset: <strong>{user.activation}</strong></li>
          <li>Site's Title: <strong>{site.title}</strong></li>
          <li>Site's Link: <strong>{site.link}</strong></li>
        </ul>				
			</div>
		</div>
	</div>
</div>