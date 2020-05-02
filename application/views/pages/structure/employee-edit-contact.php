<div class="card-box">
    <h4 class="header-title mb-4">
        <img src="<?= base_url('assets/media/users/' . $this->session->userdata('USER')['avatar']); ?>" alt="" title="" class="avatar-sm" />
        &nbsp;RODRIGO DA CUNHA QUINTANA
    </h4>

    <form class="d-none">
        
        <input type="hidden" name="id_estrutura">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Telefone Celular</label>
                <input type="text" class="form-control" name="telefone_celular" data-toggle="input-mask" data-mask-format="(00) 0000-00000">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Telefone Fixo</label>
                <input type="text" class="form-control" name="telefone_fixo" data-toggle="input-mask" data-mask-format="(00) 0000-00000">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Telefone Comercial</label>
                <input type="text" class="form-control" name="telefone_comercial" data-toggle="input-mask" data-mask-format="(00) 0000-00000">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Telefone Corporativo</label>
                <input type="text" class="form-control" name="telefone_corporativo" data-toggle="input-mask" data-mask-format="(00) 0000-00000">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Email Corporativo</label>
                <input type="email" class="form-control" name="email_corporativo">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Email Pessoal</label>
                <input type="email" class="form-control" name="email_pessoal">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Telefone de Emergência</label>
                <input type="text" class="form-control" name="telefone_emergencia" data-toggle="input-mask" data-mask-format="(00) 0000-00000">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Contato de Emergência</label>
                <input type="text" class="form-control" name="contato_emergencia">
            </div>
        </div>

        <hr>

        <a href="javascript:;" class="btn btn-secondary waves-effect waves-light mt-1 btn-cancel-edit" data-style="zoom-in"> Cancelar </a>
        <a href="javascript:;" class="btn btn-primary waves-effect waves-light mt-1 btn-save" data-style="zoom-in"> <i class="fa fa-save"></i> Salvar </a>

    </form>
</div>