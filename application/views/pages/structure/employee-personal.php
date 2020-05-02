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

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Data Nascimento</label>
            <input type="text" class="form-control" name="data_nascimento" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Sexo</label>
            <input type="text" class="form-control" name="sexo" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label"> Estado Civil </label>
            <input type="text" class="form-control" name="estado_civil" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label"> Grau de Instrução </label>
            <input type="text" class="form-control" name="grau_instrucao" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Nome da Mãe</label>
            <input type="text" class="form-control" name="nome_mae" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Nome do Pai</label>
            <input type="text" class="form-control" name="nome_pai" readonly>
        </div>
    </div>

    <hr>

    <a href="<?= base_url('structure'); ?>" class="btn btn-secondary waves-effect waves-light mt-1">Voltar</a>
    <a href="javascript:;" class="btn btn-primary waves-effect waves-light mt-1 btn-edit" data-page="personal"> <i class="fa fa-edit"></i> Editar </a>

</form>