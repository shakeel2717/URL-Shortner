<?php ee('This features requires an Extended License. Please purchase an extended license or upgrade your regular license to unlock this feature.') ?>
<form method="post" action="<?php echo route('admin.verify') ?>">
    <?php echo csrf() ?>
    <div class="form-group mt-4">
        <label class="form-label"><?php ee('Envato Purchase Code') ?></label>
        <input class="form-control" name="purchasecode" value="<?php echo config("purchasecode") ?>">
    </div>
    <button type="submit" class="btn btn-success mt-2"><?php ee('Verify and Unlock') ?></button> 
</form>