<h1 class="h3 mb-5"><?php ee('Edit Page') ?></h1>
<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.page.update', [$page->id]) ?>" enctype="multipart/form-data" data-trigger="editor">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="name" class="form-label"><?php ee('Name') ?></label>
                <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo $page->name ?>" placeholder="My Sample Page">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="slug" class="form-label"><?php ee('Slug') ?></label>
                        <input type="text" class="form-control p-2" name="slug" id="slug" value="<?php echo $page->seo ?>" placeholder="my-sample-page">
                        <p class="form-text"><?php ee('Leave this empty to automatically generate it from the title.') ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4 input-select">
                        <label for="category" class="form-label"><?php ee('Category') ?></label>
                        <select class="form-control" name="category" id="category" data-toggle="select">
                            <?php foreach(\Helpers\App::pageCategories() as $id => $category): ?>
                                <option value="<?php echo $id ?>" <?php if($page->category == $id) echo "selected" ?>><?php echo $category ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>            
            <div class="form-group mb-4">
                <label for="content" class="form-label"><?php ee('Content') ?></label>
                <p class="form-text"><?php ee('Use the rich editor below to write your page.') ?></p>
                <textarea name="content" id="editor"><?php echo $page->content ?></textarea>
            </div>
            <hr>
            <div class="form-group">
                <label for="menu" class="form-label"><?php ee('Menu') ?></label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" data-binary="true" id="menu" name="menu" value="1" <?php echo $page->menu ? 'checked' : '' ?>>
                    <label class="form-check-label" for="menu"><?php ee('Enabled') ?></label>
                </div>
                <p class="form-text"><?php ee('Do you want to add a link to this page in the menu?') ?></p>
            </div>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary"><?php ee('Update Page') ?></button>
                <div class="ms-auto">
                    <a href="<?php echo route('page', [$page->seo]) ?>" class="btn btn-success" target="_blank"><?php ee('View Page') ?></a>
                </div>
            </div>
        </form>

    </div>
</div>