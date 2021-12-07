<h1 class="h3 mb-5"><?php ee('Send Email') ?></h1>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4"><?php ee('Subscribed to newsletter') ?></h5>
                <h1 class="mt-1 mb-3"><?php echo $newsletterusers ?></h1>
                <div class="mb-1">
                    <span class="text-muted"><?php ee("Users") ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4"><?php ee('Active') ?></h5>
                <h1 class="mt-1 mb-3"><?php echo $activeusers ?></h1>
                <div class="mb-1">
                    <span class="text-muted"><?php ee("Users") ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4"><?php ee('All') ?></h5>
                <h1 class="mt-1 mb-3"><?php echo $allusers ?></h1>
                <div class="mb-1">
                    <span class="text-muted"><?php ee("Users") ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">        
        <div class="card">
            <div class="card-body">                            
                <form method="post" action="<?php echo route('admin.email.send') ?>" enctype="multipart/form-data" data-trigger="editor">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
                        <label for="sendto" class="form-label"><?php ee('Send To') ?></label>
                        <input type="text" class="form-control" name="sendto" id="sendto" value="<?php echo (new \Core\Request)->email ?: 'list.newsletter' ?>" data-toggle="tags" placeholder="Type an email or a list and press enter">
                        <p class="form-text"><?php ee('You can choose to send email to a built-in list or send email to specific email adresses') ?></p>
                    </div>
                    <div class="form-group mb-4">
                        <label for="subject" class="form-label"><?php ee('Subject') ?></label>
                        <input type="text" class="form-control p-2" name="subject" id="subject" value="<?php echo old('subject') ?>" placeholder="e.g. Annoucement...">
                    </div>                    
                    <div class="form-group mb-4">
                        <label for="content" class="form-label"><?php ee('Content') ?></label>
                        <p class="form-text"><?php ee('You can send a custom message to your users to let them know of changes or important announcements. Simply enter your message below and press send. You can also use some shortcodes to add dynamic data.') ?></p>
                        <textarea id="editor" name="content"><?php echo old('content') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php ee('Send email') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
            <p><?php ee('This tool can be very memory intensive so you absolutely have to make sure that your hosting provider supports this function or allows you send many emails at once otherwise it will most likely get you in trouble. Please don\'t spam your users otherwise they will blacklist your domain name forever. Don\'t send too many newsletters as your hosting provider will suspect you of spam.') ?></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4"><?php ee('Built-in Lists') ?></h5>
                <ul>
                    <li><?php ee('Users with newsletters') ?>: <strong>list.newsletter</strong></li>
                    <li><?php ee('Active users') ?>: <strong>list.active</strong></li>
                    <li><?php ee('All users') ?>: <strong>list.all</strong></li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4"><?php ee('Shortcodes') ?></h5>
                <ul>
                    <li><?php ee("User's username") ?>: <strong>{username}</strong></li>
                    <li><?php ee("User's email") ?>: <strong>{email}</strong></li>
                    <li><?php ee("User's registration date") ?>: <strong>{date}</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>