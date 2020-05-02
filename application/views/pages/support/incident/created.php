<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><i class="fe-plus"></i> Criar Novo Incidente </h4>
                <p class="text-muted font-13">
                    Informe os dados abaixo, com <code>informações detalhadas</code> para que possamos prestar o melhor suporte e que atendam as necessidades.
                </p>

                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label"> Tipo de Solicitação </label>
                            <select class="selectpicker form-control" data-style="btn-secondary" name="id_request_type">
                                <option value="0">Selecione...</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label"> Solicitação </label>
                            <select class="selectpicker form-control" data-style="btn-secondary" name="id_request">
                                <option value="0">Selecione...</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label"> Operação </label>
                            <select class="selectpicker form-control" data-style="btn-secondary" data-live-search="true" name="id_operation">
                                <option value="0">Selecione...</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="col-form-label">Telefone</label>
                            <input type="text" class="form-control bg-secondary" data-toggle="input-mask" data-mask-format="(00) 0000-00000" placeholder="informe para contato caso necessário..." name="phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-form-label"> Assunto </label>
                        <input type="text" class="form-control bg-secondary" placeholder="Assunto resumido..." name="subject">
                    </div>

                    <div class="form-group">
                        <label for="" class="col-form-label"> Descrição </label>
                        <div class="bubble-editor text-custom bg-secondary" style="height: 300px;" id="description"></div>
                        <input type="hidden" name="description">
                    </div>

                    <hr>

                    <a href="<?= base_url('support/incident'); ?>" class="btn btn-secondary waves-effect waves-light mt-1">Voltar</a>
                    <a href="javascript:;" class="btn btn-primary waves-effect waves-light mt-1 btn-save-incident">Enviar Incidente</a>

                </form>

            </div>
        </div>
    </div>
</div>
