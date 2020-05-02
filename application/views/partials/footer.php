<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <?= $this->session->userdata('CONFIG_G')['site-footer']; ?>
            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-sm-block">
                    <a href="http://grupoelo.com/" target="_blank">Sobre o Grupo Elo</a>
                    <a href="javascript:;">FAQ</a>
                    <a href="mailto:mis@elocontactcenter.com.br">Contate-nos</a>
                </div>
            </div>
        </div>
    </div>
</footer>