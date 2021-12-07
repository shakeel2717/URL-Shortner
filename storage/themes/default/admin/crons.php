<h1 class="h3 mb-5"><?php ee('Cron Jobs') ?></h1>
<p><?php ee('You need to add the following cron jobs either through cPanel (or other control panel) or directly to your server cron jobs.') ?></p>     
<?php if(\Helpers\App::isExtended()): ?>
<div class="row">    
    <div class="col-md-6 h-100">
        <div class="card">
            <div class="card-header"><?php ee('User Membership') ?></div>
            <div class="card-body">
                <div class="form-group mb-2">
                    <p><?php ee('This cron will check all users and if they are expired, it will switch them to a free plan') ?></p>
                    
                    <label for="date" class="form-label"><?php ee('Cron Link') ?></label>
                    <input type="text" class="form-control" value="<?php echo route('crons.user', [md5('user'.AuthToken)]) ?>" disabled>
                </div>
                <p class="mt-3"><?php ee('Cron Command') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">wget -q -O - <?php echo route('crons.user', [md5('user'.AuthToken)]) ?> >/dev/null 2>&1</pre>
                
                <p class="mt-3"><?php ee('The following command line will run every day at midnight. You can change it as per your needs.') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">0 0 * * * wget -q -O - <?php echo route('crons.user', [md5('user'.AuthToken)]) ?> >/dev/null 2>&1</pre>                
            </div>
        </div>
    </div>    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><?php ee('Logs') ?></div>
            <div class="card-body">
                <textarea rows="15" class="form-control w-100"><?php echo file_exists(LOGS.'/Cron.users.log') ? file_get_contents(LOGS.'/Cron.users.log') : 'Log not found' ?></textarea>
            </div>
        </div>
    </div>
</div>
<?php endif ?>
<div class="row">
    <div class="col-md-6 h-100">
        <div class="card">
            <div class="card-body">
                <div class="form-group mb-2">
                    <label for="date" class="form-label"><?php ee('Data Retention') ?></label>
                    <p><?php ee('This cron will remove data with respect to the data retention settings in the plan.') ?></p>
                    <input type="text" class="form-control" value="<?php echo route('crons.data', [md5('data'.AuthToken)]) ?>" disabled>
                </div>
                <p class="mt-3"><?php ee('Cron Command') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">wget -q -O - <?php echo route('crons.data', [md5('data'.AuthToken)]) ?> >/dev/null 2>&1</pre>
                
                <p class="mt-3"><?php ee('The following command line will run every day at midnight. You can change it as per your needs.') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">0 0 * * * wget -q -O - <?php echo route('crons.data', [md5('data'.AuthToken)]) ?> >/dev/null 2>&1</pre>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><?php ee('Logs') ?></div>
            <div class="card-body">
                <textarea rows="15" class="form-control w-100"><?php echo file_exists(LOGS.'/Cron.data.log') ? file_get_contents(LOGS.'/Cron.data.log') : 'Log not found' ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-md-6 h-100">
        <div class="card">
            <div class="card-body">
                <div class="form-group mb-2">
                    <label for="date" class="form-label"><?php ee('URL Checks') ?> (Optional)</label>
                    <p><?php ee('This cron will check each URL in the database against active security checks like Web Risk, Phishtank, Virus Total or Blacklist.') ?></p>
                    <div class="alert bg-danger p-3 text-white rounded">
                        <?php ee('Using this cron job will be expensive for services like Web Risk or Virus Total as each check will count as a request and some services charge per request. Use it at your own risk.') ?>
                    </div>
                    <input type="text" class="form-control" value="<?php echo route('crons.urls', [md5('url'.AuthToken)]) ?>" disabled>

                    <p class="mt-3"><?php ee('Cron Command') ?></p>
                    <pre class="bg-dark text-white p-3 rounded my-3">wget -q -O - <?php echo route('crons.urls', [md5('urls'.AuthToken)]) ?> >/dev/null 2>&1</pre> 

                    <p class="mt-3"><?php ee('The following command line will run every day at midnight. You can change it as per your needs.') ?></p>
                    <pre class="bg-dark text-white p-3 rounded my-3">0 0 * * * wget -q -O - <?php echo route('crons.urls', [md5('urls'.AuthToken)]) ?> >/dev/null 2>&1</pre> 
                </div>                
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><?php ee('Logs') ?></div>
            <div class="card-body">
                <textarea rows="15" class="form-control w-100"><?php echo file_exists(LOGS.'/Cron.urls.log') ? file_get_contents(LOGS.'/Cron.urls.log') : 'Log not found' ?></textarea>
            </div>
        </div>
    </div>
</div>