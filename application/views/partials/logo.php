<div class="logo-box">
    <a href="<?= base_url(); ?>" class="logo text-center">
        <span class="logo-lg">
            <img src="<?= base_url($this->session->userdata('CONFIG_G')['site-logo-top']); ?>" alt="" height="32">
        </span>
        <span class="logo-sm">
            <img src="<?= base_url($this->session->userdata('CONFIG_G')['site-logo-top-sm']); ?>" alt="" height="24">
        </span>
    </a>
</div>