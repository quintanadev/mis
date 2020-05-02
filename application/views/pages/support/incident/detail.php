<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-widgets">
                    <a href="<?= base_url('support/incident'); ?>"><i class="mdi mdi-arrow-left-bold"></i></a>
                    <a data-toggle="collapse" href="#form_incident" role="button" aria-expanded="false" aria-controls="form_incident"><i class="mdi mdi-minus"></i></a>
                </div>
                <h4 class="header-title"><i class="fe-flag"></i> INCIDENTE N° #<span id="id_incident"><span></h4>
                <form id="form_incident" class="collapse pt-3 show">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Aberto Por</label>
                            <input type="text" class="form-control" readonly id="user_created">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Data Abertura</label>
                            <input type="text" class="form-control" readonly id="created_at">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Email</label>
                            <input type="text" class="form-control" readonly id="email">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Operação</label>
                            <input type="text" class="form-control" readonly id="operation">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Tipo de Solicitação</label>
                            <input type="text" class="form-control" readonly id="request_type">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Solicitação</label>
                            <input type="text" class="form-control" readonly id="request">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Status</label>
                            <input type="text" class="form-control" readonly id="dstatus">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">SLA</label>
                            <input type="text" class="form-control" readonly id="sla_solution">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="col-form-label">Descrição</label>
                            <div class="text-custom bg-secondary" style="height: 150px;" id="description"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-widgets">
                    <a data-toggle="collapse" href="#form_history" role="button" aria-expanded="false" aria-controls="form_history"><i class="mdi mdi-minus"></i></a>
                </div>
                <h4 class="header-title"><i class="fe-info"></i> HISTÓRICO</h4>
                <div id="form_history" class="collapse pt-3 show">
                    
                    <div class="chat-conversation">
                        <ul class="conversation-list slimscroll" style="max-height: 350px;">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-widgets">
                    <a data-toggle="collapse" href="#form_comment" role="button" aria-expanded="false" aria-controls="form_comment"><i class="mdi mdi-minus"></i></a>
                </div>
                <h4 class="header-title"><i class="fe-edit"></i> COMENTAR</h4>
                <form id="form_comment" class="collapse pt-3 show">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="text-custom bg-secondary" style="height: 150px;" id="comment"></div>
                            <input type="hidden" name="comment">
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="col-form-label"> Status </label>
                            <select class="selectpicker form-control" data-style="btn-secondary" name="id_status">
                                <option value="0">Selecione...</option>
                                <option value="0">Em Tratativa</option>
                                <option value="0">Respondido</option>
                                <option value="0">Aguardando Usuário</option>
                                <option value="0">Pendência Externa</option>
                                <option value="0">Stand By</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label"> Ações </label>
                            <a href="javascript:;" class="form-control btn btn-primary waves-effect waves-light btn-save-comment">Salvar Comentário</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>