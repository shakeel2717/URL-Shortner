<h1 class="h3 mb-5"><?php ee('Tools') ?></h1>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action active" href="#quick" data-bs-toggle="collapse"><?php echo e("Quick Shortener") ?></a>
                    <a class="list-group-item list-group-item-action" href="#bk" data-bs-toggle="collapse"><?php echo e("Bookmarklet") ?></a>
                    <a class="list-group-item list-group-item-action" href="#jshort" data-bs-toggle="collapse"><?php echo e("Full-Page Script") ?></a>
                    <a class="list-group-item list-group-item-action" href="#zapier" data-bs-toggle="collapse"><?php echo e("Zapier Integration") ?></a>
                    <?php if (config('slackclientid') && config('slacksecretid')): ?>
                        <a class="list-group-item list-group-item-action" href="#slack" data-bs-toggle="collapse"><?php echo e("Slack Integration") ?></a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9" id="tools">
        <div class="collapse show" id="quick" data-bs-parent="#tools">
          <div class="card">
            <div class="card-body">
              <h3 class="mb-5"><i class="me-3 fa fa-fighter-jet"></i> <?php echo e("Quick Shortener") ?></h3>

              <p><?php echo e("This tool allows you to quickly shorten any URL in any page without using any fancy method. This is perhaps the quickest and the easiest method available for you to shorten URLs across all platforms. This method will generate a unique short URL for you that you will be able to access anytime from your dashboard.") ?></p>

              <p><?php echo e("Use your quick URL below to shorten any URL by adding the URL after /q/?u=. <strong>For security reasons, you need to be logged in and using the remember me feature.</strong> Check out the examples below to understand how to use this method.") ?></p>
              <pre class="p-3 border rounded"><span><?php echo url("q/?u=URL_OF_SITE") ?></span></pre>

              <p><strong><?php echo e("Examples") ?></strong></p>
              <pre class="p-3 border rounded"><span><?php echo url("q/?u=https://www.google.com") ?></span><br><span><?php echo url("q/?u=gempixel.com") ?></span><br><span><?php echo url("q/?u=http://www.apple.com/iphone-13/") ?></span></pre>

              <p><strong><?php echo e("Notes") ?></strong></p>
              <p>
                <?php echo e("Please note that this method does not return anything. It simply redirects the user to the redirection page. However if you need the actual short URL, you can always get it from your dashboard.") ?>
              </p>
            </div>                
          </div>
        </div>
        <div class="collapse" id="bk" data-bs-parent="#tools">
          <div class="card">
            <div class="card-body">
              <h3 class="mb-5"><i class="me-3 fa fa-bookmark"></i> <?php echo e("Bookmarklet") ?></h3>

              <p><?php echo e("You can use our bookmarklet tool to instantaneously shorten any site you are currently viewing and if you are logged in on our site, it will be automatically saved to your account for future access. Simply drag the following link to your bookmarks bar or copy the link and manually add it to your favorites.") ?></p>

              <a class='btn btn-primary' href="javascript:void((function () {var h = '<?php echo config('url') ?>';var e = document.createElement('script');e.setAttribute('data-url', h);e.setAttribute('data-token', '<?php echo md5(PublicToken)?>');e.setAttribute('id', 'gem_bookmarklet');e.setAttribute('type', 'text/javascript');e.setAttribute('src', h+'/static/bookmarklet.js?v=<?php echo time() ?>');document.body.appendChild(e);})());" rel='nofollow' title='<?php echo e('Drag me to your Bookmark Bar') ?>' style='cursor:move'><?php echo e('Shorten URL')?> (<?php echo explode(" ", config("title"))[0] ?>)</a>

              <p class="mt-3"><?php echo e("If you can't drag the link above, use your browser's bookmark editor to create a new bookmark and add the URL below as the link.") ?></p>
              <pre class="p-3 border rounded"><span>javascript:void((function(){var e=document.createElement('script');e.setAttribute('data-url','<?php echo config('url')?>');e.setAttribute('data-token','<?php echo md5(PublicToken)?>');e.setAttribute('id','gem_bookmarklet');e.setAttribute('type','text/javascript');e.setAttribute('src','<?php echo config('url')?>/static/bookmarklet.js?v=<?php echo time() ?>');document.body.appendChild(e)})());</span></pre>
              
              <p><strong><?php echo e("Notes") ?></strong></p>
              <p>
                <?php echo e("Please note that for secured sites that use SSL, the widget will not pop up due to security issues. In that case, the user will be redirected our site where you will be able to view your short URL.") ?>
              </p>                    
            </div>
          </div>
        </div>
        <div class="collapse" id="jshort" data-bs-parent="#tools">
          <div class="card">
            <div class="card-body">
               <h3 class="mb-5"><i class="me-3 fa fa-file-code"></i> <?php echo e("Full-Page Script") ?></h3>
               
               <p><?php echo e("This script allows you to shorten all (or select) URLs on your website very easily. All you need to do is to copy and paste the code below at the end of your page. You can customize the selector as you wish to target URLs in a specific selector. Note you can just  copy the code below because everything is already for you.") ?></p>

               <p><pre class="p-3 border rounded"><span class="m-x-3">&lt;script type=&quot;text/javascript&quot;&gt;</span><span class="m-x-4">var key = &quot;<?php echo md5(user()->api) ?>&quot;;</span><span class="m-x-3">&lt;/script&gt;<span class="m-x-3">&lt;script type=&quot;text/javascript&quot; src=&quot;<?php echo url("script.js") ?>&quot;&gt;&lt;/script&gt;</span></span></pre></p>
          
               <h5><?php echo e("Choosing custom select") ?></h5>
               <p><?php echo e("By default, this script shortens all URLs in a page. If you want to target specific URLs then you can add a selector parameter. You can see an example below where the script will only shorten URLs having a class named mylink or all direct link in the .content container or all links in the .comments container") ?></p>

               <p><pre class="p-3 border rounded"><span class="m-x-3">&lt;script type=&quot;text/javascript&quot;&gt;</span><span class="m-x-4">var key = &quot;<?php echo md5(user()->api) ?>&quot;;</span><br><span class="m-x-4">var selector = &quot;.mylink, .content > a, .comments a&quot;;</span><br><span class="m-x-3">&lt;/script&gt;<br><span class="m-x-3">&lt;script type=&quot;text/javascript&quot; src=&quot;<?php echo url("script.js") ?>&quot;&gt;&lt;/script&gt;</span></span></pre></p>

               <h5><?php echo e("Excluding domain names") ?></h5>
               <p><?php echo e("You can exclude domain names if you wish. You can add an exclude parameter to exclude domain names. The example below shortens all URLs but excludes URLs from google.com or gempixel.com") ?></p>

               <p><pre class="p-3 border rounded"><span class="m-x-3">&lt;script type=&quot;text/javascript&quot;&gt;</span><span class="m-x-4">var key = &quot;<?php echo md5(user()->api) ?>&quot;;</span><br><span class="m-x-4">var exclude = [&quot;google.com&quot;,&quot;gempixel.com&quot;];</span><br><span class="m-x-3">&lt;/script&gt;<br><span class="m-x-3">&lt;script type=&quot;text/javascript&quot; src=&quot;<?php echo url("script.js") ?>&quot;&gt;&lt;/script&gt;</span></span></pre></p>

               <h5><?php echo e("Restricting domain names") ?></h5>
               <p><?php echo e("You can restrict domain names by adding an include parameter to restrict domain names. The example below shortens all URLs within the include domain name.") ?></p>

               <p><pre class="p-3 border rounded"><span class="m-x-3">&lt;script type=&quot;text/javascript&quot;&gt;</span><span class="m-x-4">var key = &quot;<?php echo  md5(user()->api) ?>&quot;;</span><br><span class="m-x-4">var include = [&quot;google.com&quot;];</span><br><span class="m-x-3">&lt;/script&gt;<br><span class="m-x-3">&lt;script type=&quot;text/javascript&quot; src=&quot;<?php echo url("script.js") ?>&quot;&gt;&lt;/script&gt;</span></span></pre></p>

            </div>
          </div>
        </div>
        <div class="collapse" id="zapier" data-bs-parent="#tools">
          <div class="card">
              <div class="card-body">
                  <div class="d-flex">
                    <h3 class="mb-5">
                        <i class="me-3 fa fa-bolt"></i> <?php echo e("Zapier Integration") ?>             
                    </h3>
                    <div class="ms-auto">
                        <?php if(user()->zapurl || user()->zapview): ?>
                            <span class="text-success"><i class="me-1 fa fa-check-circle"></i> <?php echo e("Active") ?></span>
                        <?php endif ?>                        
                    </div>
                </div>
               <p><?php echo e("You can use Zapier to automate campaigns. By adding the URL to the zapier webhook, we will send you important information to that webhook so you can use them.") ?></p>
                <form action="<?php echo route("user.zapier") ?>" method="post">
                  <div class="form-group">
                    <label for="zapurl" class="form-label"><?php echo e("URL Zapier Notification") ?></label>
                    <input type="text" id="zapurl" name="zapurl" class="form-control p-2" placeholder="e.g. https://" value="<?php echo user()->zapurl ?>">
                    <p class="form-text"><?php echo e("We will send a notification to this URL when you create a short URL.") ?></p>
                  </div>
                  <div class="form-group">
                    <label for="zapview" class="form-label"><?php echo e("Views Zapier Notification") ?></label>
                    <input type="text" id="zapview" name="zapview" class="form-control p-2" placeholder="e.g. https://" value="<?php echo user()->zapview ?>">
                    <p class="form-text"><?php echo e("We will send a notification to this URL when someone clicks your URL.") ?></p>
                  </div>
                  <?php echo csrf() ?>
                  <button class="btn btn-primary" type="submit"><?php echo e("Save") ?></button>
                </form>
                <hr>
                <h3 class="mb-5"><?php echo e("Sample Response") ?></h3>
                <strong><?php echo e("URL Zapier Notification") ?></strong>
                <pre class="p-3 border rounded">{<br>&nbsp;&nbsp;"type":"url",<br>&nbsp;&nbsp;"longurl":"https://google.com",<br>&nbsp;&nbsp;"shorturl":"<?php echo url("C2Rxy") ?>",<br>&nbsp;&nbsp;"title":"Google",<br>&nbsp;&nbsp;"date":"17-05-2020 04:17:44"<br>}</pre>

                <br>
                <strong><?php echo e("Views Zapier Notification") ?></strong>
                <pre class="p-3 border rounded">{<br>&nbsp;&nbsp"type":"view",<br>&nbsp;&nbsp;"shorturl":"<?php echo url("C2Rxy") ?>",<br>&nbsp;&nbsp;"country":"Canada",<br>&nbsp;&nbsp;"referer":"https://yahoo.com",<br>&nbsp;&nbsp;"os":"Windows",<br>&nbsp;&nbsp;"browser":"Chrome",<br>&nbsp;&nbsp;"date":"17-05-2020 04:20:19"<br>}</pre>                                  
              </div>
            </div>

        </div>
        <?php if (config('slackclientid') && config('slacksecretid')): ?>      
          <div class="collapse" id="slack" data-bs-parent="#tools">
            <div class="card">
              <div class="card-body">
                  <div class="d-flex">
                    <h3 class="mb-5">
                        <i class="me-3 fab fa-slack"></i> <?php echo e("Slack Integration") ?>                  
                    </h3>
                    <div class="ms-auto">
                        <?php if(user()->slackid): ?>
                            <span class="text-success"><i class="me-1 fa fa-check-circle"></i> <?php echo e("Connected") ?></span>
                        <?php endif ?>                        
                    </div>
                  </div>                 
                 <p><?php echo e("You can integrate this app with your slack account and shorten directly from the slack interface using the command line below. This slack integration will save all of your links in your account in case you need to access them later. Please see below how to use the command.") ?></p>
                 <?php if (user()->slackid): ?>
                    <h5><strong><?php echo e("Slack Command") ?></strong></h5>
                    <p><pre class="p-3 border rounded">/<?php echo config("slackcommand") ?></pre></p>

                    <h5><strong><?php echo e("Example") ?></strong></h5>
                    <p><pre class="p-3 border rounded">/<?php echo config("slackcommand") ?> https://google.com</pre></p>    

                    <h5><strong><?php echo e("Example with custom name") ?></strong></h5>
                    <p><?php echo e("To send a custom alias, use the following paramter (ABCDXYZ). This will tell the script to choose shorten the link with the custom alias ABCDXYZ.") ?></p>
                    <p><pre class="p-3 border rounded">/<?php echo config("slackcommand") ?> (google) https://google.com</pre></p>                    
                 <?php else: ?>
                    <p><?php echo $slack->generateAuth() ?></p>
                 <?php endif ?>

                 <p><?php echo e("The slack command will return you the short link if everything goes well. In case there is an error, it will return you the original link. If you use the custom parameter and the alias is already taken, the script will automatically increment the alias by 1 - this means if you choose 'google' and 'google' is not available, the script will use google-1") ?></p>
              </div>
            </div>
          </div>
        <?php endif ?>
    </div>
</div>