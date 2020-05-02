<form>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Telefone Celular</label>
            <input type="text" class="form-control" name="telefone_celular" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Telefone Fixo</label>
            <input type="text" class="form-control" name="telefone_fixo" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Telefone Comercial</label>
            <input type="text" class="form-control" name="telefone_comercial" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Telefone Corporativo</label>
            <input type="text" class="form-control" name="telefone_corporativo" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Email Corporativo</label>
            <input type="text" class="form-control" name="email_corporativo" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Email Pessoal</label>
            <input type="text" class="form-control" name="email_pessoal" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Telefone de Emergência</label>
            <input type="text" class="form-control" name="telefone_emergencia" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Contato de Emergência</label>
            <input type="text" class="form-control" name="contato_emergencia" readonly>
        </div>
    </div>

    <hr>

    <a href="<?= base_url('structure'); ?>" class="btn btn-secondary waves-effect waves-light mt-1">Voltar</a>
    <a href="javascript:;" class="btn btn-primary waves-effect waves-light mt-1 btn-edit" data-page="contact"> <i class="fa fa-edit"></i> Editar </a>

</form>