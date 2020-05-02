<?php $menu = $this->session->userdata('MENU_PORTAL'); ?>

<div id="sidebar-menu">
    <ul class="metismenu" id="side-menu">
        <?php foreach ($menu as $key => $value) : ?>
            <?php if (isset($value['menu']) && count($value['menu']) > 0) : ?>
                <li class="menu-title"><?= $value['title']; ?></li>
                <?php foreach ($value['menu'] as $key => $value) : ?>
                    <?php if (isset($value['menu_group']) && count($value['menu_group']) > 0) : ?>
                        <li>
                            <a href="javascript: void(0);">
                                <i class="<?= $value['icon']; ?>"></i>
                                <span> <?= $value['title']; ?> </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <?php foreach ($value['menu_group'] as $key => $value) : ?>
                                    <li>
                                        <a href="<?= base_url($value['url']); ?>"> <?= $value['title']; ?> </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= base_url($value['url']); ?>">
                                <i class="<?= $value['icon']; ?>"></i>
                                <span> <?= $value['title']; ?> </span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <li>
                    <a href="<?= base_url($value['url']); ?>">
                        <i class="<?= $value['icon']; ?>"></i>
                        <span> <?= $value['title']; ?> </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>