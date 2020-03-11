<?php if (count($pbi) > 0) : ?>

    <div class="row">
        <?php foreach ($pbi as $key => $value) : ?>
            <div class="col-md-4">
                <a href="<?= base_url('powerbi/dashboard/'. $value['IDDashboard']); ?> ">
                    <div class="card-box" id="" style="height: 150px; background-color: <?= $value['ClasseCor']; ?>; padding-top: 1rem; padding-left: 1rem;">
                        <div class="row text-center">
                            <div class="col-3">
                                <img src="<?= base_url($value['Imagem']); ?>" alt="logo" class="avatar-md mb-3">
                            </div>
                            <div class="col-9"">
                                <h4 class="" style="color: white; font-weight: bold; margin-top: 2px;"><?= $value['Dashboard']; ?></h4>
                                <p class="" style="color: white; text-align: left!important;"><?= substr($value['Descricao'], 0, 80) . (strlen($value['Descricao']) > 80 ? '...' : ''); ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>