<div class="card-box">
    <h4 class="header-title mb-4">
        <img src="<?= base_url('assets/media/users/' . $this->session->userdata('USER')['avatar']); ?>" alt="" title="" class="avatar-sm" />
        &nbsp;RODRIGO DA CUNHA QUINTANA
    </h4>

    <ul class="nav nav-tabs nav-bordered">
        <li class="nav-item">
            <a href="#dados-corporativos" data-toggle="tab" aria-expanded="true" class="nav-link active">
                Dados Corporativos
            </a>
        </li>
        <li class="nav-item">
            <a href="#dados-alocacao" data-toggle="tab" aria-expanded="false" class="nav-link">
                Alocação
            </a>
        </li>
        <li class="nav-item">
            <a href="#dados-acessos" data-toggle="tab" aria-expanded="false" class="nav-link">
                Acessos
            </a>
        </li>
        <li class="nav-item">
            <a href="#dados-pessoais" data-toggle="tab" aria-expanded="false" class="nav-link">
                Dados Pessoais
            </a>
        </li>
        <li class="nav-item">
            <a href="#dados-contatos" data-toggle="tab" aria-expanded="false" class="nav-link">
                Contatos
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane show active" id="dados-corporativos">
            <?php $this->load->view('pages/structure/employee-corporate'); ?>
        </div>
        <div class="tab-pane" id="dados-alocacao">
            <?php $this->load->view('pages/structure/employee-allocation'); ?>
        </div>
        <div class="tab-pane" id="dados-acessos">
            <?php $this->load->view('pages/structure/employee-access'); ?>
        </div>
        <div class="tab-pane" id="dados-pessoais">
            <?php $this->load->view('pages/structure/employee-personal'); ?>
        </div>
        <div class="tab-pane" id="dados-contatos">
            <?php $this->load->view('pages/structure/employee-contact'); ?>
        </div>
    </div>
</div>