<section class="slice slice-lg py-7 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>">
    <div class="container d-flex justify-content-md-center align-items-center" data-offset-top="#navbar-main">
        <div class="py-5 col-auto">
           <div class="card shadow">
               <div class="card-body text-center p-md-8">
                    <h1><?php ee('Earn {p} commission on affiliate sales', null, ['p' => "<strong class=\"text-success\"><u>{$affiliate->rate}%</u></strong>"]) ?></h1>
                    <p class="my-5"><?php ee('Refer customers to us and we will reward you a {p}% commission on all qualifying sales made on our website. Anyone can join the affiliate program.', null, ['p' => $affiliate->rate]) ?></p>
                    <?php if(\Core\Auth::logged()): ?>
                        <a href="<?php echo route('user.affiliate') ?>" class="btn btn-success"><?php ee('View Affiliate Portal') ?></a>
                    <?php else: ?>
                        <a href="<?php echo route('register') ?>" class="btn btn-success"><?php ee('Join now') ?></a>
                    <?php endif ?>
               </div>
           </div>
        </div>
    </div>
</section>
<section class="slice slice-lg pt-8 bg-section-secondary">
    <div class="container">            
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-8 col-md-10">
                <h2 class="mt-4"><?php ee('Frequently Asked Questions') ?></h2>
                <p><?php echo $affiliate->terms ?></p>
            </div>
        </div>
        <div class="row">
            <?php foreach(\Core\DB::faqs()->where('category', 'affiliate')->find() as $i => $faq): ?>
                <?php if($i > 0 && $i % 2 == 0): ?>
                    </div>
                    <div class="row">
                <?php endif; ?>                
                <div class="col-xl-6">
                    <div id="<?php echo 'faq-holder-'.$faq->slug ?>" class="accordion accordion-spaced">
                        <div class="card">
                            <div class="card-header py-4" id="<?php echo $faq->slug ?>" data-toggle="collapse" role="button" data-target="#faq-<?php echo $faq->id ?>" aria-expanded="false" aria-controls="faq-<?php echo $faq->id ?>">
                                <h6 class="mb-0"><i data-feather="help-circle" class="mr-3"></i><?php echo $faq->question ?></h6>
                            </div>
                            <div id="faq-<?php echo $faq->id ?>" class="collapse" aria-labelledby="<?php echo $faq->slug ?>" data-parent="#<?php echo 'faq-holder-'.$faq->slug ?>">
                                <div class="card-body">
                                    <?php echo $faq->answer ?>
                                </div>
                            </div>
                        </div>
                    </div>         
                </div>                  
            <?php endforeach ?> 
        </div>
    </div>
</section>