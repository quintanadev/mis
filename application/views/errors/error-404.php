<div class="row justify-content-center">
    <div class="col-lg-12 col-xl-6 mb-6">
        <div class="error-text-box">
            <svg viewBox="0 0 600 200">
                <!-- Symbol-->
                <symbol id="s-text">
                    <text text-anchor="middle" x="50%" y="50%" dy=".35em">404!</text>
                </symbol>
                <!-- Duplicate symbols-->
                <use class="text" xlink:href="#s-text"></use>
                <use class="text" xlink:href="#s-text"></use>
                <use class="text" xlink:href="#s-text"></use>
                <use class="text" xlink:href="#s-text"></use>
                <use class="text" xlink:href="#s-text"></use>
            </svg>
        </div>
        <div class="text-center">
            <h3 class="mt-0 mb-2">Oops! Esta página não existe </h3>
            <p class="text-muted mb-3">
                Você está tentando acessar uma página não disponível.
                <br/>
                Retorne a tela principal ou tente navegar através dos menus disponíveis.
            </p>

            <a href="<?= base_url(); ?>" class="btn btn-success waves-effect waves-light">Voltar a Página Principal</a>
        </div>
    </div>
</div>