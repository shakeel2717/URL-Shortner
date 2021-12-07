<h1 class="h3 mb-5"><?php ee('Edit User') ?></h1>
<?php if($user->auth): ?>
    <div class="alert alert-warning rounded shadow p-3"><?php ee('User logged using {auth} auth. It is possible that the user does not have any username or email.', null, ['auth' => $user->auth]) ?></div>
<?php endif ?>
<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.users.update', [$user->id]) ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="admin" name="admin" value="1" <?php echo $user->admin ? 'checked' : '' ?>>
                            <label class="form-check-label" for="admin"><?php ee('Admin') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Do you want this user to be admin or just a regular user?') ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="active" name="active" value="1" <?php echo $user->active ? 'checked' : '' ?>>
                            <label class="form-check-label" for="active"><?php ee('Active') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Do you want this user to be active?') ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="banned" name="banned" value="1" <?php echo $user->banned ? 'checked' : '' ?>>
                            <label class="form-check-label" for="banned"><?php ee('Banned') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Do you want to ban this user?') ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="public" name="public" value="1" <?php echo $user->public ? 'checked' : '' ?>>
                            <label class="form-check-label" for="public"><?php ee('Public Profile') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Do you want to make this user\'s profile public?') ?></p>
                    </div>
                </div>
            </div>
            <hr>            
            <div class="form-group mb-4">
                <label for="username" class="form-label"><?php ee('Username') ?></label>
                <input type="text" class="form-control p-2" name="username" id="username" value="<?php echo $user->username ?>" placeholder="username">
                <p class="form-text"><?php ee('A username is required for the public profile to be visible.') ?></p>
            </div>				
            <div class="form-group mb-4">
                <label for="email" class="form-label"><?php ee('Email') ?></label>
                <input type="text" class="form-control p-2" name="email" id="email" value="<?php echo $user->email ?>" placeholder="admin@site.com">
                <p class="form-text"><?php ee('Please make sure that email is valid.') ?></p>
            </div>
            <div class="form-group mb-4">
                <label for="password" class="form-label"><?php ee('Password') ?></label>
                <input type="password" class="form-control p-2" name="password" id="password" value="" placeholder="">
                <p class="form-text"><?php ee('Password needs to be at least 5 characters.') ?></p>
            </div>
            <div class="form-group mb-4 input-select">
                <label for="plan" class="form-label"><?php ee('Plan') ?></label>
                <select name="plan" id="plan" class="form-control" data-toggle="select">
                    <?php foreach($plans as $plan): ?>
                        <option value="<?php echo $plan->id ?>"<?php echo $plan->id == $user->planid ? ' selected' : '' ?>><?php echo $plan->name ?></option>
                    <?php endforeach ?>
                </select>
                <p class="form-text"><?php ee('Choose the membership plan. This does not subscribe a user You will have to do that manually!') ?></p>
            </div>
            <div class="form-group mb-4">
                <label for="lastpayment" class="form-label"><?php ee('Last Payment') ?></label>
                <input type="text" class="form-control p-2" name="lastpayment" id="lastpayment" value="<?php echo $user->last_payment ?>" data-toggle="datetimepicker">
                <p class="form-text"><?php ee('Set the last payment date in this format: YYYY-MM-DD (e.g. 2014-04-01)') ?></p>
            </div>
            <div class="form-group mb-4">
                <label for="expiration" class="form-label"><?php ee('Expiration') ?></label>
                <input type="text" class="form-control p-2" name="expiration" id="expiration" value="<?php echo $user->expiration ?>" data-toggle="datetimepicker">
                <p class="form-text"><?php ee('Set the expiration payment date in this format: YYYY-MM-DD (e.g. 2014-04-01)') ?></p>
            </div>   
            <hr>
            <div class="form-group mb-4">
                <label for="api" class="form-label"><?php ee('API Key') ?></label>
                <input type="text" class="form-control p-2" name="api" id="api" value="<?php echo $user->api ?>">
                <p class="form-text"><?php ee('An API key allows users to shorten URLs from their own app or site.') ?></p>
            </div> 
            <div class="form-group mb-4">
                <label for="secret2fa" class="form-label"><?php ee('2FA Key') ?></label>
                <input type="text" class="form-control p-2" name="secret2fa" id="secret2fa" value="<?php echo $user->secret2fa ?>">
                <p class="form-text"><?php ee('2FA is an extra layer of security. If the field is empty then it is disabled. If it is not empty, do not change anything here otherwise the user will be locked out. To remove 2FA in case the user loses the key and contact you, empty this field and save the form.') ?></p>
            </div>           
            <button type="submit" class="btn btn-primary"><?php ee('Update User') ?></button>
        </form>

    </div>
</div>