<div class="card-box">
    <h4 class="header-title mb-4">
        <img src="<?= base_url('assets/media/users/' . $this->session->userdata('USER')['avatar']); ?>" alt="" title="" class="avatar-sm" />
        &nbsp;RODRIGO DA CUNHA QUINTANA
    </h4>

    <form class="d-none">
        
        <input type="hidden" name="id_estrutura">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label"> Estado Civil </label>
                <select class="selectpicker form-control" name="id_estado_civil" data-live-search="true" data-size="6">
                </select>
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label"> Grau de Instrução </label>
                <select class="selectpicker form-control" name="id_grau_instrucao" data-live-search="true" data-size="6">
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Nome da Mãe</label>
                <input type="text" class="form-control" name="nome_mae">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Nome do Pai</label>
                <input type="text" class="form-control" name="nome_pai">
            </div>
        </div>

        <hr>

        <a href="javascript:;" class="btn btn-secondary waves-effect waves-light mt-1 btn-cancel-edit" data-style="zoom-in"> Cancelar </a>
        <a href="javascript:;" class="btn btn-primary waves-effect waves-light mt-1 btn-save" data-style="zoom-in"> <i class="fa fa-save"></i> Salvar </a>

    </form>
</div>