<?php $skin = (isset($this->session->userdata('CONFIG_U')['site-skin']) ? $this->session->userdata('CONFIG_U')['site-skin'] : $this->session->userdata('CONFIG_G')['site-skin']); ?>

<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="dripicons-cross noti-icon"></i>
        </a>
        <h5 class="m-0 text-white">Preferências:</h5>
    </div>
    <div class="slimscroll-menu">
        
        <hr class="mt-0" />
        <h5 class="pl-3">Layout do site</h5>
        <hr class="mb-0" />

        <div class="p-3">
            <div class="radio radio-primary mb-2">
                <input id="skin-dark" type="radio" name="site-skin" value="dark" <?= ($skin === 'dark' ? 'checked' : ''); ?>>
                <label for="skin-dark"> Dark </label>
            </div>
            <div class="radio radio-primary mb-2">
                <input id="skin-light" type="radio" name="site-skin" value="light" <?= ($skin === 'light' ? 'checked' : ''); ?>>
                <label for="skin-light"> Light </label>
            </div>
            <div class="radio radio-primary mb-2">
                <input id="skin-purple" type="radio" name="site-skin" value="purple" <?= ($skin === 'purple' ? 'checked' : ''); ?>>
                <label for="skin-purple"> Purple </label>
            </div>
        </div>

    </div>
</div>