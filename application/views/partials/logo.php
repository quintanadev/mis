<div class="logo-box">
    <a href="<?= base_url(); ?>" class="logo text-center">
        <span class="logo-lg">
            <img src="<?= base_url($this->session->userdata('CONFIG_G')['site_logo_topo']); ?>" alt="" height="36">
        </span>
        <span class="logo-sm">
            <img src="<?= base_url($this->session->userdata('CONFIG_G')['site_logo_topo_sm']); ?>" alt="" height="24">
        </span>
    </a>
</div>