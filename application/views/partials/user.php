<li class="dropdown notification-list">
    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <img src="<?= base_url($this->session->userdata('CONFIG_G')['user-dir-avatar'] . $this->session->userdata('CONFIG_G')['user-avatar']); ?>" alt="user-image" class="rounded-circle">
        <span class="pro-user-name ml-1">
            <?= $this->session->userdata('USU_NOME') . ' ' . $this->session->userdata('USU_SOBRENOME'); ?> <i class="mdi mdi-chevron-down"></i>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
        <!-- item-->
        <div class="dropdown-header noti-title">
            <h6 class="text-overflow m-0">Bem vindo !</h6>
        </div>

        <!-- item-->
        <a href="<?= base_url('user/profile'); ?>" class="dropdown-item notify-item">
            <i class="fe-user"></i>
            <span>Meu Perfil</span>
        </a>

        <!-- item-->
        <a href="<?= base_url('user/lock-screen'); ?>" class="dropdown-item notify-item">
            <i class="fe-lock"></i>
            <span>Bloquear Tela</span>
        </a>

        <div class="dropdown-divider"></div>

        <!-- item-->
        <a href="<?= base_url('user/logout'); ?>" class="dropdown-item notify-item">
            <i class="fe-log-out"></i>
            <span>Sair</span>
        </a>

    </div>
</li>