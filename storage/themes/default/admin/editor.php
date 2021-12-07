<h1 class="h3 mb-5"><?php ee('Theme Editor') ?></h1>
<div class="card card-editor">
    <div class="card-body">
        <div class="d-flex">
            <div>
                <?php ee('Editing') ?> <?php echo $file["current"] ?>
            </div>
            <div class="ms-auto">
                <select name="theme_files" id="theme_files" data-trigger="redirect" data-name="file" data-toggle="select">
                    <?php foreach($themefiles as $tf): ?>
                        <option value="<?php echo $tf['file'] ?>" <?php echo $file['name'] == $tf['file'] ? 'selected': '' ?>><?php echo $tf['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>
    <form method="post" action="<?php echo route('admin.themes.editor.update', ['file' => $file['name']]) ?>" enctype="multipart/form-data" data-trigger="codeeditor">
        <?php echo csrf() ?>   
        <div class="form-group mb-4">
            <div id="code-editor"><?php echo $file['content'] ?></div>
            <textarea class="d-none" id="code" name="code"></textarea>
        </div>
        <div class="card-body">
            <button type="submit" class="btn btn-primary"><?php ee('Update') ?></button>
        </div>
    </form>
</div>