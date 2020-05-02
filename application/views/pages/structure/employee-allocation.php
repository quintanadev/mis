<form>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Gestor Imediato</label>
            <input type="text" class="form-control" name="nome_gestor_1" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Gestor 2</label>
            <input type="text" class="form-control" name="nome_gestor_2">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Gestor 3</label>
            <input type="text" class="form-control" name="nome_gestor_3">
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Diretor</label>
            <input type="text" class="form-control" name="nome_diretor">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label"> Setor </label>
            <input type="text" class="form-control" name="setor" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label"> Site </label>
            <input type="text" class="form-control" name="site" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label"> Cliente </label>
            <input type="text" class="form-control" name="cliente" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label"> Segmento </label>
            <input type="text" class="form-control" name="segmento" readonly>
        </div>
    </div>

    <hr>

    <a href="<?= base_url('structure'); ?>" class="btn btn-secondary waves-effect waves-light mt-1">Voltar</a>
    <a href="javascript:;" class="btn btn-primary waves-effect waves-light mt-1 btn-edit" data-page="allocation"> <i class="fa fa-edit"></i> Editar </a>

</form>