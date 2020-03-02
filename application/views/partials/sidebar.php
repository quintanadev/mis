<?php $menu = $this->session->userdata('MENU_PORTAL'); ?>

<div id="sidebar-menu">
    <ul class="metismenu" id="side-menu">
        <?php foreach ($menu as $key => $value) : ?>
            <?php if (isset($value['Menu']) && count($value['Menu']) > 0) : ?>
                <li class="menu-title"><?= $value['MenuTitulo']; ?></li>
                <?php foreach ($value['Menu'] as $key => $value) : ?>
                    <?php if (isset($value['MenuGrupo']) && count($value['MenuGrupo']) > 0) : ?>
                        <li>
                            <a href="javascript: void(0);">
                                <i class="<?= $value['MenuIcone']; ?>"></i>
                                <span> <?= $value['MenuTitulo']; ?> </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <?php foreach ($value['MenuGrupo'] as $key => $value) : ?>
                                    <li>
                                        <a href="<?= base_url($value['MenuURL']); ?>"> <?= $value['MenuTitulo']; ?> </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= base_url($value['MenuURL']); ?>">
                                <i class="<?= $value['MenuIcone']; ?>"></i>
                                <span> <?= $value['MenuTitulo']; ?> </span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <li>
                    <a href="<?= base_url($value['MenuURL']); ?>">
                        <i class="<?= $value['MenuIcone']; ?>"></i>
                        <span> <?= $value['MenuTitulo']; ?> </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>