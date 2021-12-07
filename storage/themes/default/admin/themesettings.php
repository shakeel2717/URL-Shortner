<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Theme Settings') ?></h1>
    </div>    
</div>
<div class="row">
    <?php foreach($settings as $setting): ?>
        <?php echo $setting ?>
    <?php endforeach ?>
</div>