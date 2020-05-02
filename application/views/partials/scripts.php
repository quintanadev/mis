<?php $scripts = $this->session->userdata('MENU_SCRIPTS'); ?>

<!-- Vendor js -->
<script src="<?= base_url('assets/plugins/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/vendor.min.js'); ?>"></script>

<!-- App js-->
<script src="<?= base_url('assets/js/app.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/site/app-custom.js'); ?>"></script>
<script src="<?= base_url('assets/js/site/app-config.js'); ?>"></script>

<!-- Global js-->
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/ladda/spin.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/ladda/ladda.js'); ?>"></script>

<?php foreach ($scripts as $script) : ?>

    <script src="<?= base_url($script['script']); ?>"></script>

<?php endforeach; ?>