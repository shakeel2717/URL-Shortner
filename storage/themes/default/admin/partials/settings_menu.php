<div class="card">
    <div class="card-body">
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings') ?>"><?php ee('General Settings') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['app']) ?>"><?php ee('Application Settings') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['link']) ?>"><?php ee('Link Settings') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['advanced']) ?>"><?php ee('Advanced Settings') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['theme']) ?>"><?php ee('Themes Settings') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['security']) ?>"><?php ee('Security Settings') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['membership']) ?>"><?php ee('Membership Settings') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['payments']) ?>"><?php ee('Payment Gateway') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['users']) ?>"><?php ee('Users Settings') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['mail']) ?>"><?php ee('Mail Settings') ?></a>
            <a class="list-group-item list-group-item-action" href="<?php echo route('admin.settings.config', ['integrations']) ?>"><?php ee('Integrations') ?></a>
        </div>
    </div>
</div>