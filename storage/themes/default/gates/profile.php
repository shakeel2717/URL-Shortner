<div class="container mt-5 mb-2" id="profile">    
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center my-5">
            <?php if(isset($profiledata['avatar']) && $profiledata['avatar']): ?>
                <img src="<?php echo uploads($profiledata['avatar'], 'profile') ?>" class="rounded-circle mb-3" width="120" height="120">
            <?php else: ?>
                <img src="<?php echo $user->avatar() ?>" class="rounded-circle mb-3" width="120" height="120">
            <?php endif ?>
            <h3><span><?php echo $profile->name ?></span></h3></em>
            <div id="social" class="text-center mt-2">
                <?php foreach($profiledata['social'] as $key => $value): ?>
                    <?php if(empty($value)) continue ?>
                    <a href="<?php echo $value ?>" class="mx-2"><i class="fab fa-<?php echo $key ?>"></i></a>
                <?php endforeach ?>
            </div>
            <div id="content" class="mt-5">
                <?php foreach($profiledata['links'] as $value): ?>
                    <div class="item mb-3">
                        <?php if($value['type'] == "text"): ?>
                            <p><?php echo $value['text'] ?></p>
                        <?php endif ?>

                        <?php if($value['type'] == "whatsapp"): ?>
                            <a href="https://wa.me/<?php echo str_replace(' ', '', $value['phone']) ?>" class="btn btn-block btn-custom"><img src="<?php echo assets('images/whatsapp.svg') ?>" height="25" class="mr-3"> <?php echo isset($value['label']) && $value['label'] ? $value['label'] : $value['phone'] ?></a>
                        <?php endif ?>
                        
                        <?php if($value['type'] == "link"): ?>
                            <a href="<?php echo $value['link'] ?>" class="btn btn-block btn-custom"><?php echo $value['text'] ?></a>
                        <?php endif ?>

                        <?php if($value['type'] == "youtube"): ?>
                            <iframe width="100%" height="315" src="<?php echo $value["link"] ?>" class="rounded"></iframe>
                        <?php endif ?>

                        <?php if($value['type'] == "paypal"): ?>

                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">

                                <input type="hidden" name="business" value="<?php echo $value['email'] ?>">

                                <input type="hidden" name="cmd" value="_xclick">

                                <input type="hidden" name="item_name" value="<?php echo $value['label'] ?>">
                                <input type="hidden" name="amount" value="<?php echo $value['amount'] ?>">
                                <input type="hidden" name="currency_code" value="<?php echo $value['currency'] ?>">

                                <button type="submit" name="submit" class="btn btn-block btn-custom"><?php echo $value['label'] ?></button>                            
                            </form>
                        <?php endif ?>
                        <?php if($value['type'] == "spotify"): ?>
                            <iframe width="100%" height="315" src="<?php echo $value["link"] ?>" class="rounded"></iframe>
                        <?php endif ?>                        

                        <?php if($value['type'] == "tiktok"): ?>
                            <blockquote class="tiktok-embed rounded" cite="<?php echo $value['link'] ?>" data-video-id="<?php echo $value['id'] ?>" style="max-width: 605px;min-width: 325px;" > <section> </section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>
                        <?php endif ?>                        
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <div class="text-center mt-8 opacity-8">
        <a class="navbar-brand" href="<?php echo route('home') ?>">
            <?php if(config('logo')): ?>
                <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" width="80" id="navbar-logo">
            <?php else: ?>                
                <h1 class="h5 mt-2"><?php echo config('title') ?></h1>
            <?php endif ?>
        </a>   
    </div>
</div>