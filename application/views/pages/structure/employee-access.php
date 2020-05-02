<form>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">CPF</label>
            <input type="text" class="form-control" name="cpf" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Identidade</label>
            <input type="text" class="form-control" name="identidade" readonly>
        </div>
    </div>

    <hr>

    <a href="<?= base_url('structure'); ?>" class="btn btn-secondary waves-effect waves-light mt-1">Voltar</a>
    <a href="javascript:;" class="btn btn-primary waves-effect waves-light mt-1 btn-edit" data-page="access"> <i class="fa fa-edit"></i> Editar </a>

</form>