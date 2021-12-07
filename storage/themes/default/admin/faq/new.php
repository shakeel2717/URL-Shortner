<h1 class="h3 mb-5"><?php ee('New FAQ') ?></h1>
<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.faq.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="question" class="form-label"><?php ee('Question') ?></label>
                <input type="text" class="form-control p-2" name="question" id="question" value="<?php echo old('question') ?>" placeholder="My Sample Question">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="slug" class="form-label"><?php ee('Slug') ?></label>
                        <input type="text" class="form-control p-2" name="slug" id="slug" value="<?php echo old('slug') ?>" placeholder="my-sample-faq">
                        <p><?php ee('Leave this empty to automatically generate it from the title.') ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4 input-select">
                        <label for="category" class="form-label"><?php ee('Category') ?></label>
                        <select class="form-control" name="category" id="category" data-toggle="select">
                            <?php foreach(config('faqcategories') as $id => $category): ?>
                                <option value="<?php echo $id ?>"><?php echo $category->title ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="answer" class="form-label"><?php ee('Answer') ?></label>
                <p class="form-text"><?php ee('Use the rich editor below to write your FAQ.') ?></p>
                <textarea name="answer" id="editor"><?php echo old('answer') ?></textarea>
            </div>	
            <div class="form-group">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" data-binary="true" id="pricing" name="pricing" value="1">
                    <label class="form-check-label" for="pricing"><?php ee('Pricing Page') ?></label>
                </div>
                <p class="form-text"><?php ee('Do you want to show this FAQ on the pricing page?') ?></p>
            </div>  	                        
            <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add FAQ') ?></button>
        </form>

    </div>
</div>