<h1 class="h3 mb-5"><?php ee('New Post') ?></h1>
<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.page.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="name" class="form-label"><?php ee('Name') ?></label>
                <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo old('name') ?>" placeholder="My Sample Page">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="slug" class="form-label"><?php ee('Slug') ?></label>
                        <input type="text" class="form-control p-2" name="slug" id="slug" value="<?php echo old('slug') ?>" placeholder="my-sample-page">
                        <p class="form-text"><?php ee('Leave this empty to automatically generate it from the title.') ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4 input-select">
                        <label for="category" class="form-label"><?php ee('Category') ?></label>
                        <select class="form-control" name="category" id="category" data-toggle="select">
                            <?php foreach(\Helpers\App::pageCategories() as $id => $category): ?>
                                <option value="<?php echo $id ?>"><?php echo $category ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>                    
            <div class="form-group mb-4">
                <label for="content" class="form-label"><?php ee('Content') ?></label>
                <p class="form-text"><?php ee('Use the rich editor below to write your page.') ?></p>
                <textarea name="content" id="editor"><?php echo old('content') ?></textarea>
            </div>		            
            <div class="form-group">
                <label for="menu" class="form-label"><?php ee('Menu') ?></label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" data-binary="true" id="menu" name="menu" value="1" checked>
                    <label class="form-check-label" for="menu"><?php ee('Enabled') ?></label>
                </div>
                <p class="form-text"><?php ee('Do you want to add a link to this page in the menu?') ?></p>
            </div>
            <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> <?php ee('Add Page') ?></button>
        </form>

    </div>
</div>