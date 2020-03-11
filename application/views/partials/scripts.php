<?php $scripts = $this->session->userdata('MENU_SCRIPTS'); ?>

<?php foreach ($scripts as $script) : ?>

    <script src="<?= base_url($script['Script']); ?>"></script>

<?php endforeach; ?>