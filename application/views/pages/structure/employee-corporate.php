<form>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">ID Estrutura</label>
            <input type="text" class="form-control" name="id_estrutura" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Matrícula Elo</label>
            <input type="text" class="form-control" name="matricula_elo" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label"> Status Oficial </label>
            <input type="text" class="form-control" name="status" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label"> Status Gestor </label>
            <input type="text" class="form-control" name="status_gestor" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label"> Função </label>
            <input type="text" class="form-control" name="funcao" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label"> Nível Hierárquico </label>
            <input type="text" class="form-control" name="nivel_hierarquico" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label"> Tipo de Contratação </label>
            <input type="text" class="form-control" name="tipo_contratacao" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Data de Admissão</label>
            <input type="text" class="form-control" name="data_admissao" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Data de Desligamento</label>
            <input type="text" class="form-control" name="data_desligamento" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label"> Motivo do Desligamento </label>
            <input type="text" class="form-control" name="motivo_desligamento" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Horário Entrada</label>
            <input type="text" class="form-control" name="horario_entrada" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Horário Saída</label>
            <input type="text" class="form-control" name="horario_saida" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="col-form-label">Jornada Diária</label>
            <input type="text" class="form-control" name="jornada_trabalho_dia" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="col-form-label">Jornada Mensal</label>
            <input type="text" class="form-control" name="jornada_trabalho_mes" readonly>
        </div>
    </div>

    <hr>

    <a href="<?= base_url('structure'); ?>" class="btn btn-secondary waves-effect waves-light mt-1">Voltar</a>
    <a href="javascript:;" class="btn btn-primary waves-effect waves-light mt-1 btn-edit" data-page="corporate"> <i class="fa fa-edit"></i> Editar </a>

</form>